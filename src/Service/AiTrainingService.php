<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\AnimalHealthRecord;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AiTrainingService
{
    public const TRAIN_THRESHOLD = 1000;
    private const API_BASE_URL = 'http://127.0.0.1:8001';

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function getHealthRecordCount(): int
    {
        return (int) $this->em->getRepository(AnimalHealthRecord::class)
            ->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function canTrainCustomModel(): bool
    {
        return $this->getHealthRecordCount() >= self::TRAIN_THRESHOLD;
    }

    public function trainCustomModel(): void
    {
        if (!$this->canTrainCustomModel()) {
            throw new \RuntimeException('Vous avez besoin d au moins 1000 dossiers de sante pour entrainer un modele personnalise.');
        }

        $animals = $this->em->getRepository(Animal::class)
            ->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();

        $records = $this->em->getRepository(AnimalHealthRecord::class)
            ->createQueryBuilder('r')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();

        $pythonDir = $this->getPythonDir();
        $this->exportAnimalCsv($pythonDir, $animals);
        $this->exportHealthRecordCsv($pythonDir, $records, $animals);
        $this->requestCustomTraining();
    }

    private function exportAnimalCsv(string $pythonDir, array $animals): void
    {
        $content = "id,type,vaccinated,weight\n";

        foreach ($animals as $index => $animal) {
            $content .= ($index + 1) . ','
                . strtolower((string) $animal->getType()) . ','
                . ($animal->isVaccinated() ? 1 : 0) . ','
                . ($animal->getWeight() ?? 200.0) . "\n";
        }

        file_put_contents($pythonDir . DIRECTORY_SEPARATOR . 'animal.csv', $content);
    }

    private function exportHealthRecordCsv(string $pythonDir, array $records, array $animals): void
    {
        $animalIdMap = [];

        foreach ($animals as $index => $animal) {
            $animalIdMap[$animal->getId() ?? 0] = $index + 1;
        }

        $content = "id,animal,recordDate,weight,appetite,conditionStatus,milkYield,eggCount,woolLength\n";

        foreach ($records as $record) {
            $animal = $record->getAnimal();
            $animalId = $animal?->getId();

            if ($animalId === null || !isset($animalIdMap[$animalId])) {
                continue;
            }

            $content .= ($record->getId() ?? '') . ','
                . $animalIdMap[$animalId] . ','
                . ($record->getRecordDate()?->format('Y-m-d') ?? '') . ','
                . ($record->getWeight() ?? '') . ','
                . strtolower((string) ($record->getAppetite() ?? '')) . ','
                . strtolower((string) ($record->getConditionStatus() ?? '')) . ','
                . ($record->getMilkYield() ?? '') . ','
                . ($record->getEggCount() ?? '') . ','
                . ($record->getWoolLength() ?? '') . "\n";
        }

        file_put_contents($pythonDir . DIRECTORY_SEPARATOR . 'healthRecord.csv', $content);
    }

    private function requestCustomTraining(): void
    {
        try {
            $response = $this->httpClient->request('POST', self::API_BASE_URL . '/train-custom', [
                'timeout' => 600,
            ]);
        } catch (\Throwable) {
            throw new \RuntimeException('Impossible de contacter le serveur IA. Assurez-vous que api.py tourne sur 127.0.0.1:8001.');
        }

        $statusCode = $response->getStatusCode();
        $body = $response->getContent(false);

        if ($statusCode === 404) {
            throw new \RuntimeException('Le serveur IA actif sur 127.0.0.1:8001 ne contient pas la route /train-custom. Redemarrez uvicorn depuis C:/Users/aminp/Documents/GitHub/AgriSense360/src/main/python.');
        }

        if ($statusCode < 200 || $statusCode >= 300) {
            $detail = 'Erreur du serveur IA.';
            $data = json_decode($body, true);

            if (is_array($data) && isset($data['detail']) && is_string($data['detail']) && trim($data['detail']) !== '') {
                $detail = trim($data['detail']);
            } elseif (trim($body) !== '') {
                $detail = trim($body);
            }

            throw new \RuntimeException('Echec de l entrainement du modele personnalise. ' . $detail);
        }
    }

    private function getPythonDir(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'main' . DIRECTORY_SEPARATOR . 'python';
    }
}
