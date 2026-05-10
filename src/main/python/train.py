from pathlib import Path
import sys
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import accuracy_score
import joblib

BASE = Path(__file__).parent
FEATURES = ["type_enc", "vaccinated", "weight", "appetite_enc", "record_month", "record_dayofyear", "production"]


def pick_production(row):
    t = row["type"]
    if t == "cow":
        return row["milkYield"]
    if t in ("sheep", "goat"):
        return row["woolLength"]
    return row["eggCount"]


def train_model(custom=False):
    animals = pd.read_csv(BASE / "animal.csv")
    records = pd.read_csv(BASE / "healthRecord.csv")
    animals_sel = animals[["id", "type", "vaccinated"]].copy()
    animals_sel["id"] = range(1, len(animals_sel) + 1)
    records_sel = records[["animal", "weight", "appetite", "conditionStatus", "recordDate", "milkYield", "eggCount", "woolLength"]]
    df = records_sel.merge(animals_sel, left_on="animal", right_on="id")
    df["production"] = df.apply(pick_production, axis=1)
    df["recordDate"] = pd.to_datetime(df["recordDate"])
    df["record_month"] = df["recordDate"].dt.month
    df["record_dayofyear"] = df["recordDate"].dt.dayofyear
    le_type = LabelEncoder()
    le_appetite = LabelEncoder()
    le_condition = LabelEncoder()
    df["type_enc"] = le_type.fit_transform(df["type"])
    df["appetite_enc"] = le_appetite.fit_transform(df["appetite"])
    df["condition_enc"] = le_condition.fit_transform(df["conditionStatus"])
    X = df[FEATURES].values
    y = df["condition_enc"].values
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42, stratify=y)
    clf = RandomForestClassifier(n_estimators=200, max_depth=12, random_state=42, n_jobs=-1, class_weight="balanced")
    clf.fit(X_train, y_train)
    accuracy = float(accuracy_score(y_test, clf.predict(X_test)))
    bundle = {"model": clf, "le_type": le_type, "le_appetite": le_appetite, "le_condition": le_condition, "feature_names": FEATURES}
    model_path = BASE / ("custom_model.pkl" if custom else "condition_model.pkl")
    joblib.dump(bundle, model_path)
    return {"accuracy": round(accuracy, 4), "model_path": str(model_path), "record_count": int(len(records)), "animal_count": int(len(animals))}


if __name__ == "__main__":
    train_model("--custom" in sys.argv)
