"""
HarvestModel — Random Forest yield predictor
=============================================
On first run: trains on 2000 synthetic samples (~10 sec).
Saves model to model/harvest_model.pkl for reuse.
"""

import os
import pickle
import logging
import numpy as np
import pandas as pd
from sklearn.ensemble import RandomForestRegressor
from sklearn.preprocessing import OneHotEncoder
from sklearn.pipeline import Pipeline
from sklearn.compose import ColumnTransformer
from sklearn.model_selection import cross_val_score
from sklearn.metrics import mean_absolute_error

logger = logging.getLogger(__name__)

MODEL_PATH = os.path.join(os.path.dirname(__file__), 'model', 'harvest_model.pkl')
DATA_PATH  = os.path.join(os.path.dirname(__file__), 'data',  'harvest_history.csv')

os.makedirs(os.path.dirname(MODEL_PATH), exist_ok=True)
os.makedirs(os.path.dirname(DATA_PATH),  exist_ok=True)

# Base yield kg/m² per culture — matches HarvestIaService.php constants
BASE_YIELD = {
    'Blé':0.35,'Maïs':0.90,'Riz':0.55,'Avoine':0.30,
    'Tomates':8.00,'Salades':3.50,'Pomme de terre':4.00,
    'Carottes':3.50,'Oignon':3.00,'Lentille':0.25,
    'Pomme':15.00,'Pêche':12.00,'Orange':18.00,
    'Fraise':4.00,'Framboise':2.50,'Banane':20.00,
    'Rosier':5.00,'Tulipe':8.00,'Jasmin':2.00,'Laurier-rose':3.00,
}

CULTURE_TYPES = {
    'Blé':'Céréales','Maïs':'Céréales','Riz':'Céréales','Avoine':'Céréales',
    'Tomates':'Légumes','Salades':'Légumes','Pomme de terre':'Légumes',
    'Carottes':'Légumes','Oignon':'Légumes','Lentille':'Légumes',
    'Pomme':'Fruits','Pêche':'Fruits','Orange':'Fruits',
    'Fraise':'Fruits','Framboise':'Fruits','Banane':'Fruits',
    'Rosier':'Ornementales','Tulipe':'Ornementales',
    'Jasmin':'Ornementales','Laurier-rose':'Ornementales',
}

FEATURE_COLS = [
    'culture_nom','type_culture','surface','days_late','total_days',
    'storm_days','rain_days','heat_days','frost_days',
    'high_hum_days','high_wind_days','avg_temp','avg_humidity','avg_wind',
]


class HarvestModel:

    def __init__(self):
        self.pipeline   = None
        self.is_trained = False

    # ── Public ───────────────────────────────────────────────────────────────

    def load_or_train(self):
        if os.path.exists(MODEL_PATH):
            try:
                with open(MODEL_PATH, 'rb') as f:
                    self.pipeline = pickle.load(f)
                self.is_trained = True
                logger.info(f"Model loaded from {MODEL_PATH}")
                return
            except Exception as e:
                logger.warning(f"Could not load model: {e} — retraining")
        self._train_from_seed()

    def predict(self, data: dict) -> dict:
        nom     = data.get('culture_nom', '')
        surface = float(data.get('surface', 1))
        base    = BASE_YIELD.get(nom, 2.0) * surface

        lf = self._lateness_factor(int(data.get('days_late', 0)))
        wf = self._weather_factor(data)

        if self.is_trained:
            try:
                df  = self._to_df(data)
                qty = float(max(0, self.pipeline.predict(df)[0]))
                src = 'ml'
            except Exception as e:
                logger.warning(f"ML predict failed: {e}")
                qty = base * lf * wf
                src = 'formula_fallback'
        else:
            qty = base * lf * wf
            src = 'formula'

        return {
            'quantite_kg':     round(qty, 2),
            'ia_score':        round(lf * wf * 100, 1),
            'base_yield':      round(base, 2),
            'lateness_factor': round(lf, 4),
            'weather_factor':  round(wf, 4),
            'source':          src,
        }

    def record_harvest(self, data: dict):
        row = {col: data.get(col, 0) for col in FEATURE_COLS + ['actual_quantite']}
        row['culture_nom']  = str(data.get('culture_nom', ''))
        row['type_culture'] = str(data.get('type_culture', ''))
        df = pd.DataFrame([row])
        header = not os.path.exists(DATA_PATH)
        df.to_csv(DATA_PATH, mode='a', header=header, index=False)
        logger.info(f"Recorded: {row['culture_nom']} {row.get('actual_quantite')} kg")

    def retrain(self) -> dict:
        if not os.path.exists(DATA_PATH):
            raise FileNotFoundError("No harvest data yet.")
        df = pd.read_csv(DATA_PATH).dropna(subset=['actual_quantite'])
        if len(df) < 10:
            raise ValueError(f"Need ≥10 records to retrain (have {len(df)}).")
        X, y = df[FEATURE_COLS], df['actual_quantite']
        self.pipeline = self._build_pipeline()
        self.pipeline.fit(X, y)
        self.is_trained = True
        self._save()
        cv  = cross_val_score(self.pipeline, X, y, cv=min(5, len(df)), scoring='r2')
        mae = mean_absolute_error(y, self.pipeline.predict(X))
        return {'n_samples': len(df), 'r2_cv': round(float(cv.mean()), 3), 'mae': round(mae, 2)}

    # ── Private ───────────────────────────────────────────────────────────────

    def _train_from_seed(self):
        logger.info("Generating 2000 synthetic training samples…")
        df = self._seed_data(2000)
        df.to_csv(DATA_PATH, index=False)
        X, y = df[FEATURE_COLS], df['actual_quantite']
        self.pipeline = self._build_pipeline()
        self.pipeline.fit(X, y)
        self.is_trained = True
        self._save()
        mae = mean_absolute_error(y, self.pipeline.predict(X))
        logger.info(f"Seed model ready. Train MAE: {mae:.2f} kg")

    def _seed_data(self, n: int) -> pd.DataFrame:
        rng  = np.random.default_rng(42)
        noms = list(BASE_YIELD.keys())
        rows = []
        for _ in range(n):
            nom    = rng.choice(noms)
            surf   = float(rng.uniform(10, 500))
            late   = int(rng.choice([0]*7+[1,2,3,5,7,10,14,21]))
            total  = int(rng.integers(10, 90))
            storm  = int(rng.poisson(0.5))
            rain   = int(rng.poisson(3))
            heat   = int(rng.poisson(2))
            frost  = int(rng.poisson(0.3))
            hi_hum = int(rng.poisson(4))
            hi_win = int(rng.poisson(1))
            t_avg  = float(rng.normal(22, 6))
            h_avg  = int(np.clip(rng.normal(60, 15), 20, 100))
            w_avg  = float(np.clip(rng.normal(20, 10), 0, 80))

            base  = BASE_YIELD[nom] * surf
            lf    = max(0.40, 1.0 - late*0.02) if late > 0 else 1.0
            n_    = max(total, 1)
            wf    = 1.0 - (storm/n_)*0.30 - (heat/n_)*0.20 - (frost/n_)*0.25 \
                        - (hi_hum/n_)*0.10 - (rain/n_)*0.05 - (hi_win/n_)*0.08
            wf    = float(np.clip(wf, 0.30, 1.0))
            qty   = float(max(0, rng.normal(base*lf*wf, base*lf*wf*0.15)))

            rows.append({
                'culture_nom':nom,'type_culture':CULTURE_TYPES[nom],
                'surface':surf,'days_late':late,'total_days':total,
                'storm_days':storm,'rain_days':rain,'heat_days':heat,
                'frost_days':frost,'high_hum_days':hi_hum,'high_wind_days':hi_win,
                'avg_temp':t_avg,'avg_humidity':h_avg,'avg_wind':w_avg,
                'actual_quantite':qty,
            })
        return pd.DataFrame(rows)

    def _build_pipeline(self) -> Pipeline:
        cat = ['culture_nom','type_culture']
        num = [c for c in FEATURE_COLS if c not in cat]
        pre = ColumnTransformer([
            ('cat', OneHotEncoder(handle_unknown='ignore', sparse_output=False), cat),
            ('num', 'passthrough', num),
        ])
        rf  = RandomForestRegressor(n_estimators=200, max_depth=12, min_samples_leaf=3,
                                    random_state=42, n_jobs=-1)
        return Pipeline([('pre', pre), ('rf', rf)])

    def _to_df(self, data: dict) -> pd.DataFrame:
        row = {col: data.get(col, 0) for col in FEATURE_COLS}
        row['culture_nom']  = str(data.get('culture_nom', ''))
        row['type_culture'] = str(data.get('type_culture', ''))
        return pd.DataFrame([row])

    def _save(self):
        with open(MODEL_PATH, 'wb') as f:
            pickle.dump(self.pipeline, f)
        logger.info(f"Model saved → {MODEL_PATH}")

    @staticmethod
    def _lateness_factor(days: int) -> float:
        return max(0.40, 1.0 - days*0.02) if days > 0 else 1.0

    @staticmethod
    def _weather_factor(d: dict) -> float:
        n = max(int(d.get('total_days', 1)), 1)
        f = 1.0 - (int(d.get('storm_days',0))/n)*0.30 \
                - (int(d.get('heat_days',0))/n)*0.20  \
                - (int(d.get('frost_days',0))/n)*0.25 \
                - (int(d.get('high_hum_days',0))/n)*0.10 \
                - (int(d.get('rain_days',0))/n)*0.05  \
                - (int(d.get('high_wind_days',0))/n)*0.08
        if int(d.get('total_days', 0)) == 0:
            return 0.85
        return float(np.clip(f, 0.30, 1.0))
