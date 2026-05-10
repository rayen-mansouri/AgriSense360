<?php

namespace App\Service;

use App\Entity\Animal;
use App\Entity\AnimalHealthRecord;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Twig\Environment;

class FarmPdfReportService
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly Environment $twig)
    {
    }

    public function buildResponse(bool $includeSummary, bool $includeAllAnimals, bool $includeAtRisk, bool $includeRecentRecords): Response
    {
        $animals = $this->em->getRepository(Animal::class)->createQueryBuilder('a')->orderBy('a.id', 'ASC')->getQuery()->getResult();
        $recentRecords = $includeRecentRecords ? $this->em->getRepository(AnimalHealthRecord::class)->createQueryBuilder('r')->orderBy('r.record_date', 'DESC')->setMaxResults(20)->getQuery()->getResult() : [];

        $summary = ['totalAnimals' => count($animals), 'vaccinated' => count(array_filter($animals, fn (Animal $a) => $a->isVaccinated())), 'vaccinatedPercent' => count($animals) > 0 ? round(count(array_filter($animals, fn (Animal $a) => $a->isVaccinated())) * 100 / count($animals)) : 0, 'atRisk' => 0, 'healthy' => 0, 'sick' => 0, 'injured' => 0, 'critical' => 0, 'recordsCount' => count($recentRecords)];

        $animalRows = array_map(function (Animal $animal): array {
            $status = strtolower((string) $animal->getHealthStatus());
            return ['earTag' => $animal->getEarTag() !== null ? '#' . $animal->getEarTag() : '-', 'type' => (string) ($animal->getType() ?? '-'), 'weight' => $animal->getWeight() !== null ? number_format($animal->getWeight(), 1) : '-', 'healthStatus' => (string) ($animal->getHealthStatus() ?? '-'), 'location' => (string) ($animal->getLocation() ?? '-'), 'vaccinated' => $animal->isVaccinated() ? 'Oui' : 'Non', 'isAtRisk' => in_array($status, ['sick', 'injured', 'critical'], true)];
        }, $animals);
        $atRiskRows = array_values(array_filter($animalRows, static fn (array $row): bool => $row['isAtRisk']));

        $recentRecordRows = array_map(function (AnimalHealthRecord $record): array {
            $animal = $record->getAnimal();
            return ['earTag' => $animal?->getEarTag() !== null ? '#' . $animal->getEarTag() : '-', 'type' => (string) ($animal?->getType() ?? '-'), 'recordDate' => $record->getRecordDate()?->format('Y-m-d') ?? '-', 'weight' => $record->getWeight() !== null ? number_format($record->getWeight(), 1) : '-', 'appetite' => (string) ($record->getAppetite() ?? '-'), 'condition' => (string) ($record->getConditionStatus() ?? '-'), 'production' => (string) ($record->getMilkYield() ?? $record->getEggCount() ?? $record->getWoolLength() ?? '-'), 'notes' => (string) ($record->getNotes() ?? '-')];
        }, $recentRecords);

        $generatedAt = new \DateTimeImmutable('today');
        $html = $this->twig->render('animal_management/farm_report.pdf.twig', ['generatedAt' => $generatedAt, 'includeSummary' => $includeSummary, 'includeAllAnimals' => $includeAllAnimals, 'includeAtRisk' => $includeAtRisk, 'includeRecentRecords' => $includeRecentRecords, 'summary' => $summary, 'animalRows' => $animalRows, 'atRiskRows' => $atRiskRows, 'recentRecordRows' => $recentRecordRows]);

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);
        $pdfBinary = $mpdf->Output('', 'S');

        $filename = 'rapport_ferme_' . $generatedAt->format('Y-m-d') . '.pdf';
        $response = new Response($pdfBinary);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename));

        return $response;
    }
}
