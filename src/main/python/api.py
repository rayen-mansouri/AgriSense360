from pathlib import Path
from datetime import date
from typing import Optional

import joblib
import numpy as np
import pandas as pd
from fastapi import FastAPI, HTTPException, Query
from pydantic import BaseModel, field_validator
from train import train_model

BASE = Path(__file__).parent
GENERAL_MODEL_PATH = BASE / "condition_model.pkl"
CUSTOM_MODEL_PATH = BASE / "custom_model.pkl"

app = FastAPI(title="AgriSense Condition Predictor", version="1.0.0")

general_bundle = joblib.load(GENERAL_MODEL_PATH) if GENERAL_MODEL_PATH.exists() else None
custom_bundle: Optional[dict] = joblib.load(CUSTOM_MODEL_PATH) if CUSTOM_MODEL_PATH.exists() else None


def reload_custom_bundle() -> None:
    global custom_bundle
    custom_bundle = joblib.load(CUSTOM_MODEL_PATH) if CUSTOM_MODEL_PATH.exists() else None


def get_bundle(model_name: str) -> dict:
    if model_name == "custom":
        if custom_bundle is None:
            raise HTTPException(status_code=404, detail="Custom model not found. Train one first.")
        return custom_bundle
    if general_bundle is None:
        return {}
    return general_bundle


class PredictionRequest(BaseModel):
    animal_type: str
    vaccinated: int
    weight: float
    appetite: str
    record_date: date
    production: float

    @field_validator("appetite")
    @classmethod
    def validate_appetite(cls, v):
        allowed = ["high", "normal", "low", "none"]
        if v.lower() not in allowed:
            raise ValueError(f"appetite must be one of {allowed}")
        return v.lower()

    @field_validator("vaccinated")
    @classmethod
    def validate_vaccinated(cls, v):
        if v not in (0, 1):
            raise ValueError("vaccinated must be 0 or 1")
        return v

    @field_validator("animal_type")
    @classmethod
    def normalize_type(cls, v):
        return v.lower()


@app.post("/predict")
def predict(req: PredictionRequest, model: str = Query(default="general")):
    bundle = get_bundle(model)
    if not bundle:
        # Fallback heuristic when no trained model file is available.
        risk_score = 0
        if req.appetite in ("none", "low"):
            risk_score += 2
        if req.weight < 200:
            risk_score += 1
        if req.production <= 0:
            risk_score += 1

        if risk_score >= 3:
            condition = "critical"
            probs = {"critical": 0.78, "sick": 0.17, "healthy": 0.05}
        elif risk_score >= 2:
            condition = "sick"
            probs = {"sick": 0.66, "healthy": 0.24, "critical": 0.10}
        else:
            condition = "healthy"
            probs = {"healthy": 0.82, "sick": 0.12, "critical": 0.06}
        return {"condition": condition, "probabilities": probs}

    mdl = bundle["model"]
    le_type = bundle["le_type"]
    le_appetite = bundle["le_appetite"]
    le_condition = bundle["le_condition"]
    try:
        type_enc = le_type.transform([req.animal_type])[0]
        appetite_enc = le_appetite.transform([req.appetite])[0]
    except ValueError as e:
        raise HTTPException(status_code=422, detail=str(e))
    ts = pd.Timestamp(req.record_date)
    X = np.array([[type_enc, req.vaccinated, req.weight, appetite_enc, ts.month, ts.dayofyear, req.production]])
    pred_enc = mdl.predict(X)[0]
    proba = mdl.predict_proba(X)[0]
    condition = le_condition.inverse_transform([pred_enc])[0]
    prob_dict = {le_condition.classes_[i]: round(float(proba[i]), 4) for i in range(len(le_condition.classes_))}
    return {"condition": condition, "probabilities": prob_dict}


@app.post("/train-custom")
def train_custom():
    try:
        result = train_model(custom=True)
        reload_custom_bundle()
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))
    return {"status": "ok", **result}
