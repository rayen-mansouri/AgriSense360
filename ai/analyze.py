import json
import sys
import os

cv_path = sys.argv[1]
api_key = os.environ.get('GEMINI_API_KEY', '')

try:
    import google.generativeai as genai

    genai.configure(api_key=api_key)
    uploaded_file = genai.upload_file(cv_path, mime_type="application/pdf")
    model = genai.GenerativeModel('gemini-1.5-flash')

    prompt = """Analyse ce CV pour une entreprise agricole nommée AgriSense 360.

RÈGLE PRINCIPALE: Si le CV contient N'IMPORTE QUELLE connexion à l'agriculture (culture, élevage, récolte, irrigation, agronomie, horticulture, viticulture, maraîchage, zootechnie, foresterie, agroalimentaire, coopérative agricole, ferme, exploitation, etc.) → assigne ROLE_GERANT.

Classifie le candidat:
- ROLE_GERANT: toute expérience ou formation agricole, OU expérience en gestion/management/supervision
- ROLE_OUVRIER: aucune expérience agricole ET profil purement manuel/technique sans gestion

Réponds UNIQUEMENT avec un objet JSON valide (sans markdown, sans ```):
{"role": "ROLE_GERANT", "decision": "pending", "reason": "Raison brève en français max 100 caractères"}

Règles:
- Si le CV a un lien quelconque avec l'agriculture → ROLE_GERANT systématiquement
- decision est toujours "pending"
- La raison doit être en français, maximum 100 caractères
- Réponds SEULEMENT avec le JSON, rien d'autre"""

    response = model.generate_content([uploaded_file, prompt])
    text = response.text.strip()

    if '```' in text:
        for part in text.split('```'):
            part = part.strip().lstrip('json').strip()
            try:
                result = json.loads(part)
                print(json.dumps(result))
                sys.exit(0)
            except Exception:
                continue

    result = json.loads(text)
    print(json.dumps(result))

except ImportError:
    # Fallback: keyword-based analysis
    with open(cv_path, 'rb') as f:
        text = f.read(8192).decode('utf-8', errors='ignore').lower()

    agri_keywords = [
        'agriculture', 'agricole', 'ferme', 'farm', 'culture', 'récolte', 'harvest',
        'élevage', 'livestock', 'irrigation', 'agronomie', 'agronomy', 'horticulture',
        'viticulture', 'maraîchage', 'zootechnie', 'foresterie', 'agroalimentaire',
        'plantation', 'champ', 'terrain', 'semence', 'engrais', 'pesticide',
        'tracteur', 'labour', 'silo', 'coopérative', 'exploitation agricole',
        'field', 'crop', 'soil', 'seed', 'harvest', 'orchard', 'greenhouse'
    ]
    mgmt_keywords = [
        'manager', 'gestion', 'responsable', 'directeur', 'supervision',
        'chef', 'coordinateur', 'encadrement', 'management', 'team lead'
    ]

    # Any agriculture connection → GERANT
    if any(w in text for w in agri_keywords):
        result = {"role": "ROLE_GERANT", "decision": "pending", "reason": "Profil agricole détecté – recommandé comme Gérant"}
    elif any(w in text for w in mgmt_keywords):
        result = {"role": "ROLE_GERANT", "decision": "pending", "reason": "Expérience en gestion détectée"}
    else:
        result = {"role": "ROLE_OUVRIER", "decision": "pending", "reason": "Profil ouvrier – vérification manuelle recommandée"}

    print(json.dumps(result))

except Exception as e:
    print(json.dumps({
        "role": "ROLE_OUVRIER",
        "decision": "pending",
        "reason": "Analyse automatique indisponible – vérification requise"
    }))