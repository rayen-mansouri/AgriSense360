<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\AnimalHealthRecord;
use Doctrine\ORM\EntityManagerInterface;
use Nucleos\DompdfBundle\Factory\DompdfFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Twig\Environment;

class FarmPdfReportService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly Environment $twig,
        private readonly DompdfFactoryInterface $dompdfFactory,
    ) {
    }

    public function buildResponse(
        bool $includeSummary,
        bool $includeAllAnimals,
        bool $includeAtRisk,
        bool $includeRecentRecords,
    ): Response {
        if (!$includeSummary && !$includeAllAnimals && !$includeAtRisk && !$includeRecentRecords) {
            throw new \InvalidArgumentException('Selectionnez au moins une section.');
        }

        $animals = $this->em->getRepository(Animal::class)
            ->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();

        $recentRecords = [];
        if ($includeRecentRecords) {
            $recentRecords = $this->em->getRepository(AnimalHealthRecord::class)
                ->createQueryBuilder('r')
                ->andWhere('r.recordDate IS NOT NULL')
                ->orderBy('r.recordDate', 'DESC')
                ->addOrderBy('r.id', 'DESC')
                ->setMaxResults(20)
                ->getQuery()
                ->getResult();
        }

        $summary = $this->buildSummary($animals, $recentRecords);
        $animalRows = $this->buildAnimalRows($animals);
        $atRiskRows = array_values(array_filter(
            $animalRows,
            static fn (array $row): bool => $row['isAtRisk'],
        ));
        $animalMap = [];
        foreach ($animals as $animal) {
            $animalMap[$animal->getId() ?? 0] = $animal;
        }
        $recentRecordRows = $this->buildRecentRecordRows($recentRecords, $animalMap);
        $generatedAt = new \DateTimeImmutable('today');
        $html = $this->twig->render('animal_management/farm_report.pdf.twig', [
            'generatedAt' => $generatedAt,
            'includeSummary' => $includeSummary,
            'includeAllAnimals' => $includeAllAnimals,
            'includeAtRisk' => $includeAtRisk,
            'includeRecentRecords' => $includeRecentRecords,
            'summary' => $summary,
            'animalRows' => $animalRows,
            'atRiskRows' => $atRiskRows,
            'recentRecordRows' => $recentRecordRows,
        ]);

        $dompdf = $this->dompdfFactory->create();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();

        $filename = 'rapport_ferme_' . $generatedAt->format('Y-m-d') . '.pdf';
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set(
            'Content-Disposition',
            $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename),
        );

        return $response;
    }

    private function buildSummary(array $animals, array $recentRecords): array
    {
        $vaccinated = 0;
        $healthy = 0;
        $sick = 0;
        $injured = 0;
        $critical = 0;

        foreach ($animals as $animal) {
            if ($animal->isVaccinated()) {
                ++$vaccinated;
            }

            $status = strtolower((string) $animal->getHealthStatus());
            if ($status === 'healthy') {
                ++$healthy;
            } elseif ($status === 'sick') {
                ++$sick;
            } elseif ($status === 'injured') {
                ++$injured;
            } elseif ($status === 'critical') {
                ++$critical;
            }
        }

        $totalAnimals = count($animals);
        $atRisk = $sick + $injured + $critical;

        return [
            'totalAnimals' => $totalAnimals,
            'vaccinated' => $vaccinated,
            'vaccinatedPercent' => $totalAnimals > 0 ? round(($vaccinated * 100) / $totalAnimals) : 0,
            'atRisk' => $atRisk,
            'healthy' => $healthy,
            'sick' => $sick,
            'injured' => $injured,
            'critical' => $critical,
            'recordsCount' => count($recentRecords),
        ];
    }

    private function buildAnimalRows(array $animals): array
    {
        $rows = [];

        foreach ($animals as $animal) {
            $status = $animal->getHealthStatus();
            $normalizedStatus = strtolower((string) $status);
            $rows[] = [
                'earTag' => $animal->getEarTag() !== null ? '#' . $animal->getEarTag() : '-',
                'type' => $this->capitalize($animal->getType()),
                'weight' => $animal->getWeight() !== null ? number_format($animal->getWeight(), 1, '.', '') : '-',
                'healthStatus' => $status !== null && $status !== '' ? $this->capitalize($status) : '-',
                'location' => $this->capitalize($animal->getLocation()),
                'vaccinated' => $animal->isVaccinated() ? 'Oui' : 'Non',
                'isAtRisk' => in_array($normalizedStatus, ['sick', 'injured', 'critical'], true),
            ];
        }

        return $rows;
    }

    private function buildRecentRecordRows(array $recentRecords, array $animalMap): array
    {
        $rows = [];

        foreach ($recentRecords as $record) {
            $animal = $animalMap[$record->getAnimal()?->getId() ?? 0] ?? null;
            $rows[] = [
                'earTag' => $animal?->getEarTag() !== null ? '#' . $animal->getEarTag() : '-',
                'type' => $this->capitalize($animal?->getType()),
                'recordDate' => $record->getRecordDate()?->format('Y-m-d') ?? '-',
                'weight' => $record->getWeight() !== null ? number_format($record->getWeight(), 1, '.', '') : '-',
                'appetite' => $record->getAppetite() !== null ? $this->capitalize($record->getAppetite()) : '-',
                'condition' => $record->getConditionStatus() !== null ? $this->capitalize($record->getConditionStatus()) : '-',
                'production' => $this->formatProduction($record),
                'notes' => $this->truncate($record->getNotes(), 18),
            ];
        }

        return $rows;
    }

    private function formatProduction(AnimalHealthRecord $record): string
    {
        if ($record->getMilkYield() !== null) {
            return number_format($record->getMilkYield(), 1, '.', '') . 'L';
        }

        if ($record->getEggCount() !== null) {
            return $record->getEggCount() . ' oeufs';
        }

        if ($record->getWoolLength() !== null) {
            return number_format($record->getWoolLength(), 1, '.', '') . 'cm';
        }

        return '-';
    }

    private function capitalize(?string $value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return ucfirst(strtolower($value));
    }

    private function truncate(?string $value, int $max): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        if (strlen($value) <= $max) {
            return $value;
        }

        return substr($value, 0, $max - 1) . '...';
    }
}
