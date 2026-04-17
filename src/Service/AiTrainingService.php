<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\AnimalHealthRecord;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AiTrainingService
{
    public const TRAIN_THRESHOLD = 1000;

    public function __construct(
        private readonly EntityManagerInterface $em,
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

        $commands = [
            ['python', 'train.py', '--custom'],
            ['py', '-3', 'train.py', '--custom'],
        ];

        $lastFailure = null;

        foreach ($commands as $command) {
            $process = new Process($command, $pythonDir);
            $process->setTimeout(600);

            try {
                $process->mustRun();

                return;
            } catch (\Throwable $exception) {
                $lastFailure = $exception;
            }
        }

        if ($lastFailure instanceof ProcessFailedException) {
            throw new \RuntimeException('Echec de l entrainement du modele personnalise.');
        }

        throw new \RuntimeException('Python introuvable pour lancer train.py.');
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

    private function getPythonDir(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'main' . DIRECTORY_SEPARATOR . 'python';
    }
}
