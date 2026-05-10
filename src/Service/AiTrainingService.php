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

    public function __construct(private readonly EntityManagerInterface $em, private readonly HttpClientInterface $httpClient)
    {
    }

    public function getHealthRecordCount(): int
    {
        return (int) $this->em->getRepository(AnimalHealthRecord::class)
            ->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function trainCustomModel(): void
    {
        if ($this->getHealthRecordCount() < self::TRAIN_THRESHOLD) {
            throw new \RuntimeException('Vous avez besoin d au moins 1000 dossiers.');
        }
        $animals = $this->em->getRepository(Animal::class)->createQueryBuilder('a')->orderBy('a.id', 'ASC')->getQuery()->getResult();
        $records = $this->em->getRepository(AnimalHealthRecord::class)->createQueryBuilder('r')->orderBy('r.id', 'ASC')->getQuery()->getResult();
        $pythonDir = $this->getPythonDir();
        $this->exportAnimalCsv($pythonDir, $animals);
        $this->exportHealthRecordCsv($pythonDir, $records, $animals);
        try {
            $response = $this->httpClient->request('POST', self::API_BASE_URL . '/train-custom', ['timeout' => 600]);
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                throw new \RuntimeException('Echec de l entrainement distant.');
            }
        } catch (\Throwable) {
            throw new \RuntimeException('Impossible de contacter le serveur IA. Assurez-vous que api.py tourne sur 127.0.0.1:8001.');
        }
    }

    private function exportAnimalCsv(string $pythonDir, array $animals): void
    {
        $content = "id,type,vaccinated,weight\n";
        foreach ($animals as $index => $animal) {
            $content .= ($index + 1) . ',' . strtolower((string) $animal->getType()) . ',' . ($animal->isVaccinated() ? 1 : 0) . ',' . ($animal->getWeight() ?? 200.0) . "\n";
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
            $content .= ($record->getId() ?? '') . ',' . $animalIdMap[$animalId] . ',' . ($record->getRecordDate()?->format('Y-m-d') ?? '') . ',' . ($record->getWeight() ?? '') . ',' . strtolower((string) ($record->getAppetite() ?? '')) . ',' . strtolower((string) ($record->getConditionStatus() ?? '')) . ',' . ($record->getMilkYield() ?? '') . ',' . ($record->getEggCount() ?? '') . ',' . ($record->getWoolLength() ?? '') . "\n";
        }
        file_put_contents($pythonDir . DIRECTORY_SEPARATOR . 'healthRecord.csv', $content);
    }

    private function getPythonDir(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'main' . DIRECTORY_SEPARATOR . 'python';
    }
}
