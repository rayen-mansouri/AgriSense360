"""
IA Harvest — Flask Microservice
================================
Run:  python app.py
Port: 5001 (change with FLASK_PORT env var)

Endpoints:
  GET  /health    — check if service is alive
  POST /predict   — get IA yield prediction
  POST /record    — save a confirmed harvest (for future retraining)
  POST /retrain   — retrain model on accumulated real data
"""

import os
import logging
from flask import Flask, request, jsonify
from model import HarvestModel

logging.basicConfig(level=logging.INFO, format='%(asctime)s %(levelname)s %(message)s')
logger = logging.getLogger(__name__)

app = Flask(__name__)

# Load or train the model on startup
model = HarvestModel()
model.load_or_train()


@app.route('/health', methods=['GET'])
def health():
    return jsonify({'status': 'ok', 'model_trained': model.is_trained})


@app.route('/predict', methods=['POST'])
def predict():
    """
    Symfony calls this with culture + weather summary data.
    Returns: quantite_kg, ia_score, lateness_factor, weather_factor, source
    """
    try:
        data = request.get_json(force=True)
        if not data:
            return jsonify({'error': 'No JSON body'}), 400
        result = model.predict(data)
        logger.info(f"Predict: {data.get('culture_nom')} → {result['quantite_kg']} kg | score {result['ia_score']}%")
        return jsonify(result)
    except Exception as e:
        logger.error(f"Predict error: {e}", exc_info=True)
        return jsonify({'error': str(e)}), 500


@app.route('/record', methods=['POST'])
def record():
    """
    Called after a harvest is confirmed. Saves the result to CSV
    so the model can be retrained with real data later.
    """
    try:
        data = request.get_json(force=True)
        model.record_harvest(data)
        return jsonify({'status': 'recorded'})
    except Exception as e:
        logger.error(f"Record error: {e}", exc_info=True)
        return jsonify({'error': str(e)}), 500


@app.route('/retrain', methods=['POST'])
def retrain():
    """
    Retrain the model using all data accumulated in data/harvest_history.csv.
    Call this once you have 50+ real harvests recorded.
    """
    try:
        metrics = model.retrain()
        return jsonify({'status': 'retrained', 'metrics': metrics})
    except Exception as e:
        logger.error(f"Retrain error: {e}", exc_info=True)
        return jsonify({'error': str(e)}), 500


if __name__ == '__main__':
    port  = int(os.environ.get('FLASK_PORT', 5001))
    debug = os.environ.get('FLASK_DEBUG', 'false').lower() == 'true'
    logger.info(f"Starting IA Harvest service on port {port}")
    app.run(host='0.0.0.0', port=port, debug=debug)
