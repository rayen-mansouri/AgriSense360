<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\AnimalHealthRecord;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AiPredictionService
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function hasCustomModel(): bool
    {
        return is_file($this->getPythonDir() . DIRECTORY_SEPARATOR . 'custom_model.pkl');
    }

    public function predictAnimal(Animal $animal, array $records, string $model): array
    {
        if ($records === []) {
            throw new \RuntimeException('Aucun dossier de sante disponible pour baser la prediction.');
        }

        $payload = $this->buildPayload($animal, $records);
        $data = $this->callApi($payload, $model);
        $condition = (string) ($data['condition'] ?? '');

        if ($condition === '') {
            throw new \RuntimeException('Reponse IA invalide.');
        }

        $probabilities = is_array($data['probabilities'] ?? null) ? $data['probabilities'] : [];
        $rawProbability = (float) ($probabilities[$condition] ?? 0);

        return [
            'animalId' => $animal->getId(),
            'condition' => $condition,
            'conditionLabel' => $this->capitalize($condition),
            'confidence' => min(0.75 + $rawProbability * 0.24, 0.99),
            'model' => $this->normalizeModel($model),
            'modelLabel' => $this->getModelLabel($model),
            'records' => array_map(fn (AnimalHealthRecord $record): array => $this->formatRecordForView($record, $animal), $records),
            'animalInfo' => 'Animal #' . ($animal->getEarTag() ?? '-') . '  |  Base sur ' . count($records) . ' dossier' . (count($records) === 1 ? '' : 's') . '  |  ' . $this->getModelLabel($model),
            'productionLabel' => $this->getProductionHeader($animal->getType()),
        ];
    }

    public function analyzeAll(array $animals, callable $recordsResolver, string $model): array
    {
        $results = [];

        foreach ($animals as $animal) {
            $records = $recordsResolver($animal);
            if ($records === []) {
                continue;
            }

            try {
                $prediction = $this->predictAnimal($animal, $records, $model);
            } catch (\Throwable) {
                continue;
            }

            if (strtolower($prediction['condition']) === 'healthy') {
                continue;
            }

            $results[] = [
                'animalId' => $animal->getId(),
                'earTag' => $animal->getEarTag(),
                'type' => $animal->getType(),
                'location' => $animal->getLocation(),
                'condition' => $prediction['condition'],
                'conditionLabel' => $prediction['conditionLabel'],
                'confidence' => $prediction['confidence'],
            ];
        }

        return $results;
    }

    public function buildBatchEmailBody(array $batchResults): string
    {
        $lines = [];
        $lines[] = 'Rapport de Prediction IA - AgriSense 360';
        $lines[] = 'Date : ' . (new \DateTimeImmutable('today'))->format('Y-m-d');
        $lines[] = '';
        $lines[] = 'Animaux necessitant attention (' . count($batchResults) . ') :';
        $lines[] = '----------------------------------------';

        foreach ($batchResults as $result) {
            $line = '  * Boucle #' . ($result['earTag'] ?? '?')
                . '  [' . $this->capitalize((string) ($result['type'] ?? '?')) . ']'
                . '  Condition : ' . ($result['conditionLabel'] ?? $this->capitalize((string) ($result['condition'] ?? '')))
                . '  Fiabilite : ' . sprintf('%.0f%%', ((float) ($result['confidence'] ?? 0)) * 100);

            if (($result['location'] ?? null) !== null && $result['location'] !== '') {
                $line .= '  Emplacement : ' . $result['location'];
            }

            $lines[] = $line;
        }

        $lines[] = '';
        $lines[] = '-- Envoye depuis AgriSense 360';

        return implode("\n", $lines);
    }

    public function getModelLabel(string $model): string
    {
        return $this->normalizeModel($model) === 'custom' ? 'Modele Personnalise' : 'Modele General';
    }

    public function normalizeModel(string $model): string
    {
        return strtolower($model) === 'custom' ? 'custom' : 'general';
    }

    private function callApi(array $payload, string $model): array
    {
        try {
            $response = $this->httpClient->request('POST', 'http://localhost:8000/predict', [
                'query' => ['model' => $this->normalizeModel($model)],
                'json' => $payload,
            ]);
        } catch (\Throwable) {
            throw new \RuntimeException('Impossible de contacter le serveur IA. Assurez-vous que api.py tourne sur le port 8000.');
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode === 404) {
            throw new \RuntimeException('Modele introuvable sur le serveur.');
        }

        if ($statusCode < 200 || $statusCode >= 300) {
            throw new \RuntimeException('Erreur du serveur IA.');
        }

        try {
            return $response->toArray(false);
        } catch (\Throwable) {
            throw new \RuntimeException('Erreur lors de l analyse de la reponse du serveur IA.');
        }
    }

    private function buildPayload(Animal $animal, array $records): array
    {
        $latest = $records[0];
        $type = strtolower((string) ($animal->getType() ?? 'cow'));
        $weight = $latest->getWeight() ?? $animal->getWeight() ?? 200.0;
        $production = 0.0;

        if ($type === 'cow' && $latest->getMilkYield() !== null) {
            $production = $latest->getMilkYield();
        } elseif (in_array($type, ['sheep', 'goat'], true) && $latest->getWoolLength() !== null) {
            $production = $latest->getWoolLength();
        } elseif ($latest->getEggCount() !== null) {
            $production = $latest->getEggCount();
        }

        return [
            'animal_type' => $type,
            'vaccinated' => $animal->isVaccinated() ? 1 : 0,
            'weight' => $weight,
            'appetite' => strtolower((string) ($latest->getAppetite() ?? 'normal')),
            'record_date' => $latest->getRecordDate()?->format('Y-m-d') ?? (new \DateTimeImmutable('today'))->format('Y-m-d'),
            'production' => $production,
        ];
    }

    private function formatRecordForView(AnimalHealthRecord $record, Animal $animal): array
    {
        $type = strtolower((string) ($animal->getType() ?? ''));
        $productionValue = 0;
        $productionText = '0';

        if ($type === 'cow' && $record->getMilkYield() !== null) {
            $productionValue = $record->getMilkYield();
            $productionText = number_format($productionValue, 1, '.', '') . ' L';
        } elseif (in_array($type, ['sheep', 'goat'], true) && $record->getWoolLength() !== null) {
            $productionValue = $record->getWoolLength();
            $productionText = number_format($productionValue, 1, '.', '') . ' cm';
        } elseif ($record->getEggCount() !== null) {
            $productionValue = $record->getEggCount();
            $productionText = number_format((float) $productionValue, 0, '.', '');
        }

        return [
            'recordDate' => $record->getRecordDate()?->format('Y-m-d') ?? 'N/A',
            'weight' => $record->getWeight() !== null ? number_format($record->getWeight(), 1, '.', '') . ' kg' : 'N/A',
            'appetite' => $record->getAppetite() !== null ? $this->capitalize($record->getAppetite()) : 'N/A',
            'production' => $productionText,
        ];
    }

    private function getProductionHeader(?string $animalType): string
    {
        $type = strtolower((string) $animalType);

        if ($type === 'cow') {
            return 'Lait (L)';
        }

        if (in_array($type, ['sheep', 'goat'], true)) {
            return 'Laine (cm)';
        }

        return 'Oeufs';
    }

    private function capitalize(string $value): string
    {
        if ($value === '') {
            return $value;
        }

        return ucfirst(strtolower($value));
    }

    private function getPythonDir(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'main' . DIRECTORY_SEPARATOR . 'python';
    }
}
