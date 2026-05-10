<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\AnimalHealthRecord;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AiPredictionService
{
    private const API_BASE_URL = 'http://127.0.0.1:8001';

    public function __construct(private readonly HttpClientInterface $httpClient)
    {
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
            'records' => array_map(fn (AnimalHealthRecord $record): array => $this->formatRecordForView($record, $animal), $records),
            'animalInfo' => 'Animal ID ' . $animal->getId() . ' (#' . ($animal->getEarTag() ?? '-') . ') | Base sur ' . count($records) . ' dossier(s)',
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
        $lines = ['Rapport de Prediction IA - AgriSense 360', 'Date : ' . (new \DateTimeImmutable('today'))->format('Y-m-d'), ''];
        foreach ($batchResults as $result) {
            $lines[] = '* Boucle #' . ($result['earTag'] ?? '?') . ' - ' . ($result['conditionLabel'] ?? '');
        }

        return implode("\n", $lines);
    }

    public function normalizeModel(string $model): string
    {
        return strtolower($model) === 'custom' ? 'custom' : 'general';
    }

    private function callApi(array $payload, string $model): array
    {
        try {
            $response = $this->httpClient->request('POST', self::API_BASE_URL . '/predict', [
                'query' => ['model' => $this->normalizeModel($model)],
                'json' => $payload,
            ]);
            return $response->toArray(false);
        } catch (\Throwable) {
            throw new \RuntimeException('Impossible de contacter le serveur IA sur 127.0.0.1:8001.');
        }
    }

    private function buildPayload(Animal $animal, array $records): array
    {
        /** @var AnimalHealthRecord $latest */
        $latest = $records[0];
        $type = strtolower((string) ($animal->getType() ?? 'cow'));
        $weight = $latest->getWeight() ?? $animal->getWeight() ?? 200.0;
        $production = (float) ($latest->getMilkYield() ?? $latest->getWoolLength() ?? $latest->getEggCount() ?? 0.0);

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
        return [
            'recordDate' => $record->getRecordDate()?->format('Y-m-d') ?? 'N/A',
            'weight' => $record->getWeight() !== null ? number_format($record->getWeight(), 1, '.', '') . ' kg' : 'N/A',
            'appetite' => $record->getAppetite() !== null ? $this->capitalize($record->getAppetite()) : 'N/A',
            'production' => (string) ($record->getMilkYield() ?? $record->getWoolLength() ?? $record->getEggCount() ?? 0),
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
        return $value === '' ? $value : ucfirst(strtolower($value));
    }

    private function getPythonDir(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'main' . DIRECTORY_SEPARATOR . 'python';
    }
}
