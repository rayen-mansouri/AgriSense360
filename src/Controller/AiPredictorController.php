<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalHealthRecord;
use App\Service\AiPredictionService;
use App\Service\BrevoMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AiPredictorController extends AbstractController
{
    #[Route('/analytics/predict', name: 'analytics_predict', methods: ['POST'])]
    public function predictAnalytics(
        Request $request,
        EntityManagerInterface $em,
        AiPredictionService $aiPredictionService,
    ): RedirectResponse {
        $model = $aiPredictionService->normalizeModel((string) $request->request->get('model', 'general'));
        $animalId = (int) $request->request->get('animalId');
        $state = $this->getAnalyticsState($request);
        $state['selectedModel'] = $model;
        $state['selectedAnimalId'] = $animalId;
        $state['aiStatus'] = '';

        $animal = $em->getRepository(Animal::class)->find($animalId);
        if (!$animal instanceof Animal) {
            $state['prediction'] = null;
            $state['aiStatus'] = 'Veuillez selectionner un animal.';
            $this->storeAnalyticsState($request, $state);

            return $this->redirectToRoute('animal_management_index', ['tab' => 'predictor']);
        }

        $records = $this->getAnalyticsRecords($em, $animal);

        try {
            $state['prediction'] = $aiPredictionService->predictAnimal($animal, $records, $model);
        } catch (\Throwable $e) {
            $state['prediction'] = null;
            $state['aiStatus'] = $e->getMessage();
        }

        $this->storeAnalyticsState($request, $state);

        return $this->redirectToRoute('animal_management_index', ['tab' => 'predictor']);
    }

    #[Route('/analytics/predict-all', name: 'analytics_predict_all', methods: ['POST'])]
    public function predictAllAnalytics(
        Request $request,
        EntityManagerInterface $em,
        AiPredictionService $aiPredictionService,
    ): RedirectResponse {
        $model = $aiPredictionService->normalizeModel((string) $request->request->get('model', 'general'));
        $state = $this->getAnalyticsState($request);
        $state['selectedModel'] = $model;
        $state['batchEmailStatus'] = '';
        $state['batchEmailSuccess'] = null;
        $animals = $em->getRepository(Animal::class)->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();

        $batchResults = $aiPredictionService->analyzeAll(
            $animals,
            fn (Animal $animal): array => $this->getAnalyticsRecords($em, $animal),
            $model,
        );

        $state['batchResults'] = $batchResults;
        $state['batchStatus'] = $batchResults === [] ? 'Tous les animaux sont en bonne sante.' : '';
        $this->storeAnalyticsState($request, $state);

        return $this->redirectToRoute('animal_management_index', ['tab' => 'predictor']);
    }

    #[Route('/analytics/send-vet-report', name: 'analytics_send_vet_report', methods: ['POST'])]
    public function sendAnalyticsVetReport(
        Request $request,
        EntityManagerInterface $em,
        AiPredictionService $aiPredictionService,
        BrevoMailService $brevoMailService,
    ): RedirectResponse {
        $model = $aiPredictionService->normalizeModel((string) $request->request->get('model', 'general'));
        $email = trim((string) $request->request->get('vetEmail'));
        $state = $this->getAnalyticsState($request);
        $state['selectedModel'] = $model;
        $state['batchVetEmail'] = $email;
        $state['batchEmailSuccess'] = null;

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $state['batchEmailStatus'] = 'Veuillez entrer l email du veterinaire.';
            $this->storeAnalyticsState($request, $state);

            return $this->redirectToRoute('animal_management_index', ['tab' => 'predictor']);
        }

        $animals = $em->getRepository(Animal::class)->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
        $batchResults = $aiPredictionService->analyzeAll(
            $animals,
            fn (Animal $animal): array => $this->getAnalyticsRecords($em, $animal),
            $model,
        );
        $state['batchResults'] = $batchResults;
        $state['batchStatus'] = $batchResults === [] ? 'Tous les animaux sont en bonne sante.' : '';

        if ($batchResults === []) {
            $state['batchEmailStatus'] = 'Aucun resultat a envoyer.';
            $this->storeAnalyticsState($request, $state);

            return $this->redirectToRoute('animal_management_index', ['tab' => 'predictor']);
        }

        try {
            $brevoMailService->sendTransactionalEmail(
                $email,
                'Rapport de Prediction IA - ' . (new \DateTimeImmutable('today'))->format('Y-m-d'),
                $aiPredictionService->buildBatchEmailBody($batchResults),
            );
            $state['batchEmailStatus'] = 'Rapport envoye avec succes.';
            $state['batchEmailSuccess'] = true;
        } catch (\Throwable $e) {
            $state['batchEmailStatus'] = 'Echec : ' . $e->getMessage();
            $state['batchEmailSuccess'] = false;
        }

        $this->storeAnalyticsState($request, $state);

        return $this->redirectToRoute('animal_management_index', ['tab' => 'predictor']);
    }

    private function getAnalyticsState(Request $request): array
    {
        if (!$request->hasSession()) {
            return [];
        }

        $state = $request->getSession()->get('analytics_state');

        return is_array($state) ? $state : [];
    }

    private function storeAnalyticsState(Request $request, array $state): void
    {
        if (!$request->hasSession()) {
            return;
        }

        $request->getSession()->set('analytics_state', $state);
    }

    private function getAnalyticsRecords(EntityManagerInterface $em, Animal $animal): array
    {
        return $em->getRepository(AnimalHealthRecord::class)->createQueryBuilder('r')
            ->andWhere('r.animal = :animal')
            ->setParameter('animal', $animal)
            ->orderBy('r.recordDate', 'DESC')
            ->addOrderBy('r.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
