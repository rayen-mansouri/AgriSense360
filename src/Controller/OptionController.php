<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Service\AiTrainingService;
use App\Service\BrevoMailService;
use App\Service\EnumOptionService;
use App\Service\FarmPdfReportService;
use App\Service\VeterinaryReportEmailContentBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OptionController extends AbstractController
{
    #[Route('/options/type/add', name: 'option_type_add', methods: ['POST'])]
    public function addType(Request $request, EnumOptionService $enumOptionService): RedirectResponse
    {
        try {
            $enumOptionService->addType((string) $request->request->get('value'));
            $this->addFlash('success', 'Type added.');
        } catch (\Throwable $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('animal_management_index', ['tab' => 'options']);
    }

    #[Route('/options/type/delete', name: 'option_type_delete', methods: ['POST'])]
    public function deleteType(Request $request, EnumOptionService $enumOptionService): RedirectResponse
    {
        try {
            $enumOptionService->deleteType((string) $request->request->get('value'));
            $this->addFlash('success', 'Type removed.');
        } catch (\Throwable $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('animal_management_index', ['tab' => 'options']);
    }

    #[Route('/options/location/add', name: 'option_location_add', methods: ['POST'])]
    public function addLocation(Request $request, EnumOptionService $enumOptionService): RedirectResponse
    {
        try {
            $enumOptionService->addLocation((string) $request->request->get('value'));
            $this->addFlash('success', 'Location added.');
        } catch (\Throwable $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('animal_management_index', ['tab' => 'options']);
    }

    #[Route('/options/location/delete', name: 'option_location_delete', methods: ['POST'])]
    public function deleteLocation(Request $request, EnumOptionService $enumOptionService): RedirectResponse
    {
        try {
            $enumOptionService->deleteLocation((string) $request->request->get('value'));
            $this->addFlash('success', 'Location removed.');
        } catch (\Throwable $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('animal_management_index', ['tab' => 'options']);
    }

    #[Route('/options/ai/train', name: 'ai_model_train', methods: ['POST'])]
    public function trainAiModel(AiTrainingService $aiTrainingService): RedirectResponse
    {
        try {
            $aiTrainingService->trainCustomModel();
            $this->addFlash('success', 'Modele entraine et sauvegarde. Redemarrez le serveur IA (api.py) pour l appliquer.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Echec de l entrainement : ' . $e->getMessage());
        }

        return $this->redirectToRoute('animal_management_index', ['tab' => 'options']);
    }

    #[Route('/options/vet-report/send', name: 'vet_report_send', methods: ['POST'])]
    public function sendVetReport(
        Request $request,
        EntityManagerInterface $em,
        BrevoMailService $brevoMail,
        VeterinaryReportEmailContentBuilder $reportBuilder,
    ): RedirectResponse {
        $vetEmail = trim((string) $request->request->get('vetEmail'));
        $notes = trim((string) $request->request->get('notes'));
        if ($vetEmail === '' || !filter_var($vetEmail, FILTER_VALIDATE_EMAIL)) {
            $this->addFlash('error', 'Please enter the vet email.');

            return $this->redirectToRoute('animal_management_index', ['tab' => 'options']);
        }

        $atRisk = $em->getRepository(Animal::class)->createQueryBuilder('a')
            ->where('LOWER(a.healthStatus) IN (:statuses)')
            ->setParameter('statuses', ['sick', 'injured', 'critical'])
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
        $subject = 'Animal Health Report - ' . (new \DateTimeImmutable('today'))->format('Y-m-d');
        $body = $reportBuilder->buildBody($atRisk, $notes);

        try {
            $brevoMail->sendTransactionalEmail($vetEmail, $subject, $body);
            $this->addFlash('success', 'Report sent successfully.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Failed: ' . $e->getMessage());
        }

        return $this->redirectToRoute('animal_management_index', ['tab' => 'options']);
    }

    #[Route('/options/pdf/export', name: 'farm_report_pdf_export', methods: ['POST'])]
    public function exportFarmReportPdf(Request $request, FarmPdfReportService $farmPdfReportService): Response
    {
        $includeSummary = $request->request->getBoolean('includeSummary');
        $includeAllAnimals = $request->request->getBoolean('includeAllAnimals');
        $includeAtRisk = $request->request->getBoolean('includeAtRisk');
        $includeRecentRecords = $request->request->getBoolean('includeRecentRecords');

        if (!$includeSummary && !$includeAllAnimals && !$includeAtRisk && !$includeRecentRecords) {
            $this->addFlash('error', 'Selectionnez au moins une section pour le PDF.');

            return $this->redirectToRoute('animal_management_index', ['tab' => 'options']);
        }

        return $farmPdfReportService->buildResponse(
            $includeSummary,
            $includeAllAnimals,
            $includeAtRisk,
            $includeRecentRecords,
        );
    }
}
