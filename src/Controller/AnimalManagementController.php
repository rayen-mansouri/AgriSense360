<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalHealthRecord;
use App\Service\AiPredictionService;
use App\Service\AiTrainingService;
use App\Service\AnimalValidationService;
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
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class AnimalManagementController extends AbstractController
{
    #[Route('/', name: 'animal_management_index', methods: ['GET'])]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        EnumOptionService $enumOptionService,
        AiPredictionService $aiPredictionService,
        AiTrainingService $aiTrainingService,
        ChartBuilderInterface $chartBuilder,
    ): Response
    {
        $availableTabs = ['animaux', 'dossiers', 'options', 'predictor', 'analytics'];
        $currentTab = (string) $request->query->get('tab', 'animaux');
        if (!in_array($currentTab, $availableTabs, true)) {
            $currentTab = 'animaux';
        }
        $pageSize = 10;
        $animalSortMap = [
            'id' => 'id',
            'earTag' => 'earTag',
            'type' => 'type',
            'weight' => 'weight',
            'healthStatus' => 'healthStatus',
            'birthDate' => 'birthDate',
            'origin' => 'origin',
            'location' => 'location'
        ];
        $animalSort = (string) $request->query->get('animalSort', 'id');
        if (!array_key_exists($animalSort, $animalSortMap)) {
            $animalSort = 'id';
        }
        $animalDir = strtoupper((string) $request->query->get('animalDir', 'DESC')) === 'ASC' ? 'ASC' : 'DESC';
        $animalSearchField = (string) $request->query->get('animalSearchField', 'all');
        $animalSearchTerm = trim((string) $request->query->get('animalSearch', ''));
        $animalQb = $em->getRepository(Animal::class)->createQueryBuilder('a');
        if ($animalSearchTerm !== '') {
            $term = '%' . strtolower($animalSearchTerm) . '%';
            if ($animalSearchField === 'all') {
                $animalQb
                    ->andWhere('LOWER(CONCAT(\'\', a.id)) LIKE :term OR LOWER(CONCAT(\'\', a.earTag)) LIKE :term OR LOWER(a.type) LIKE :term OR LOWER(CONCAT(\'\', a.weight)) LIKE :term OR LOWER(a.healthStatus) LIKE :term OR LOWER(CONCAT(\'\', a.birthDate)) LIKE :term OR LOWER(a.origin) LIKE :term OR LOWER(a.location) LIKE :term')
                    ->setParameter('term', $term);
            } elseif (array_key_exists($animalSearchField, $animalSortMap)) {
                $animalQb
                    ->andWhere('LOWER(CONCAT(\'\', a.' . $animalSortMap[$animalSearchField] . ')) LIKE :term')
                    ->setParameter('term', $term);
            }
        }
        $animalTotal = (int) (clone $animalQb)->select('COUNT(a.id)')->getQuery()->getSingleScalarResult();
        $animalPage = max(1, (int) $request->query->get('animalPage', 1));
        $animalTotalPages = max(1, (int) ceil($animalTotal / $pageSize));
        if ($animalPage > $animalTotalPages) {
            $animalPage = $animalTotalPages;
        }
        $animals = $animalQb
            ->orderBy('a.' . $animalSortMap[$animalSort], $animalDir)
            ->setFirstResult(($animalPage - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery()
            ->getResult();
        $visitVisit = $request->query->get('visit') === '1';
        $visitLocationParam = trim((string) $request->query->get('visitLocation', ''));
        $visitIndex = max(0, (int) $request->query->get('visitIndex', 0));
        $visitWizard = false;
        $visitLinkParams = [];
        $visitEmptyLocation = false;
        $visitAnimal = null;
        $visitTotal = 0;
        if ($currentTab === 'dossiers' && $visitVisit && $visitLocationParam !== '') {
            $visitAnimals = $em->getRepository(Animal::class)->createQueryBuilder('a')
                ->where('LOWER(a.location) = LOWER(:loc)')
                ->setParameter('loc', $visitLocationParam)
                ->orderBy('a.id', 'ASC')
                ->getQuery()
                ->getResult();
            $visitTotal = count($visitAnimals);
            if ($visitTotal === 0) {
                $visitEmptyLocation = true;
            } elseif ($visitIndex >= $visitTotal) {
                $this->addFlash('success', sprintf('Visite terminée — %d animal(s) traité(s).', $visitTotal));

                return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers']);
            } else {
                $visitWizard = true;
                $visitAnimal = $visitAnimals[$visitIndex];
                $visitLinkParams = [
                    'visit' => 1,
                    'visitLocation' => $visitLocationParam,
                    'visitIndex' => $visitIndex,
                ];
            }
        }
        $selectedAnimalId = (int) $request->query->get('animalId', 0);
        $selectedAnimal = null;
        if ($visitWizard && $visitAnimal instanceof Animal) {
            $selectedAnimal = $visitAnimal;
        } elseif ($selectedAnimalId > 0) {
            $selectedAnimal = $em->getRepository(Animal::class)->find($selectedAnimalId);
        }
        $records = [];
        $recordPage = max(1, (int) $request->query->get('recordPage', 1));
        $recordTotalPages = 1;
        $recordTotal = 0;
        $recordSort = (string) $request->query->get('recordSort', 'recordDate');
        $recordDir = strtoupper((string) $request->query->get('recordDir', 'DESC')) === 'ASC' ? 'ASC' : 'DESC';
        $recordSearchField = (string) $request->query->get('recordSearchField', 'all');
        $recordSearchTerm = trim((string) $request->query->get('recordSearch', ''));
        $defaultVetEmail = (string) ($_ENV['VET_DEFAULT_EMAIL'] ?? $_SERVER['VET_DEFAULT_EMAIL'] ?? '');
        $analyticsState = $this->getAnalyticsState($request);
        $analyticsAnimals = $em->getRepository(Animal::class)->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
        $healthRecordCount = $aiTrainingService->getHealthRecordCount();
        $canTrainCustomModel = $healthRecordCount >= AiTrainingService::TRAIN_THRESHOLD;
        $customModelAvailable = $aiPredictionService->hasCustomModel();
        $analyticsDashboard = $currentTab === 'analytics'
            ? $this->buildAnalyticsDashboard($em, $chartBuilder)
            : $this->getEmptyAnalyticsDashboard();
        $recordSortMap = [
            'id' => 'id',
            'recordDate' => 'recordDate',
            'weight' => 'weight',
            'appetite' => 'appetite',
            'conditionStatus' => 'conditionStatus',
            'notes' => 'notes'
        ];
        if (!array_key_exists($recordSort, $recordSortMap) && $recordSort !== 'production') {
            $recordSort = 'recordDate';
        }
        if ($selectedAnimal instanceof Animal) {
            $recordQb = $em->getRepository(AnimalHealthRecord::class)->createQueryBuilder('r')
                ->andWhere('r.animal = :animal')
                ->setParameter('animal', $selectedAnimal);
            if ($recordSearchTerm !== '') {
                $term = '%' . strtolower($recordSearchTerm) . '%';
                if ($recordSearchField === 'all') {
                    $recordQb
                        ->andWhere('LOWER(CONCAT(\'\', r.id)) LIKE :rterm OR LOWER(CONCAT(\'\', r.recordDate)) LIKE :rterm OR LOWER(CONCAT(\'\', r.weight)) LIKE :rterm OR LOWER(r.appetite) LIKE :rterm OR LOWER(r.conditionStatus) LIKE :rterm OR LOWER(CONCAT(\'\', COALESCE(r.milkYield, r.woolLength, r.eggCount, 0))) LIKE :rterm OR LOWER(r.notes) LIKE :rterm')
                        ->setParameter('rterm', $term);
                } elseif ($recordSearchField === 'production') {
                    $recordQb
                        ->andWhere('LOWER(CONCAT(\'\', COALESCE(r.milkYield, r.woolLength, r.eggCount, 0))) LIKE :rterm')
                        ->setParameter('rterm', $term);
                } elseif (array_key_exists($recordSearchField, $recordSortMap)) {
                    $recordQb
                        ->andWhere('LOWER(CONCAT(\'\', r.' . $recordSortMap[$recordSearchField] . ')) LIKE :rterm')
                        ->setParameter('rterm', $term);
                }
            }
            if ($recordSort === 'production') {
                $recordQb->orderBy('COALESCE(r.milkYield, r.woolLength, r.eggCount, 0)', $recordDir);
            } else {
                $recordQb->orderBy('r.' . $recordSortMap[$recordSort], $recordDir);
            }
            $recordTotal = (int) (clone $recordQb)->select('COUNT(r.id)')->getQuery()->getSingleScalarResult();
            $recordTotalPages = max(1, (int) ceil($recordTotal / $pageSize));
            if ($recordPage > $recordTotalPages) {
                $recordPage = $recordTotalPages;
            }
            $records = $recordQb
                ->addOrderBy('r.id', 'DESC')
                ->setFirstResult(($recordPage - 1) * $pageSize)
                ->setMaxResults($pageSize)
                ->getQuery()
                ->getResult();
        }
        return $this->render('animal_management/index.html.twig', [
            'currentTab' => $currentTab,
            'animals' => $animals,
            'records' => $records,
            'selectedAnimal' => $selectedAnimal,
            'visitWizard' => $visitWizard,
            'visitVisit' => $visitVisit,
            'visitLocationQuery' => $visitLocationParam,
            'visitIndex' => $visitIndex,
            'visitTotal' => $visitTotal,
            'visitEmptyLocation' => $visitEmptyLocation,
            'visitAnimal' => $visitAnimal,
            'visitLinkParams' => $visitLinkParams,
            'types' => $enumOptionService->getTypeOptions(),
            'locations' => $enumOptionService->getLocationOptions(),
            'origins' => ['BORN_IN_FARM', 'OUTSIDE'],
            'appetites' => ['LOW', 'NORMAL', 'HIGH', 'NONE'],
            'conditions' => ['HEALTHY', 'SICK', 'INJURED', 'CRITICAL'],
            'editAnimalId' => (int) $request->query->get('editAnimalId', 0),
            'editRecordId' => (int) $request->query->get('editRecordId', 0),
            'animalSort' => $animalSort,
            'animalDir' => $animalDir,
            'animalSearchField' => $animalSearchField,
            'animalSearch' => $animalSearchTerm,
            'recordSort' => $recordSort,
            'recordDir' => $recordDir,
            'recordSearchField' => $recordSearchField,
            'recordSearch' => $recordSearchTerm,
            'defaultVetEmail' => $defaultVetEmail,
            'analyticsAnimals' => $analyticsAnimals,
            'healthRecordCount' => $healthRecordCount,
            'trainThreshold' => AiTrainingService::TRAIN_THRESHOLD,
            'canTrainCustomModel' => $canTrainCustomModel,
            'customModelAvailable' => $customModelAvailable,
            'analyticsSummary' => $analyticsDashboard['summary'],
            'analyticsHasConditionData' => $analyticsDashboard['hasConditionData'],
            'analyticsHasTypeData' => $analyticsDashboard['hasTypeData'],
            'analyticsConditionChart' => $analyticsDashboard['conditionChart'],
            'analyticsTypeChart' => $analyticsDashboard['typeChart'],
            'analyticsLocations' => $analyticsDashboard['locations'],
            'selectedAiModel' => (string) ($analyticsState['selectedModel'] ?? 'general'),
            'selectedAiAnimalId' => (int) ($analyticsState['selectedAnimalId'] ?? 0),
            'predictionResult' => $analyticsState['prediction'] ?? null,
            'batchResults' => $analyticsState['batchResults'] ?? [],
            'aiStatus' => (string) ($analyticsState['aiStatus'] ?? ''),
            'batchStatus' => (string) ($analyticsState['batchStatus'] ?? ''),
            'batchEmailStatus' => (string) ($analyticsState['batchEmailStatus'] ?? ''),
            'batchEmailSuccess' => array_key_exists('batchEmailSuccess', $analyticsState) ? $analyticsState['batchEmailSuccess'] : null,
            'batchVetEmail' => (string) ($analyticsState['batchVetEmail'] ?? $defaultVetEmail),
            'animalPage' => $animalPage,
            'animalTotalPages' => $animalTotalPages,
            'animalTotal' => $animalTotal,
            'recordPage' => $recordPage,
            'recordTotalPages' => $recordTotalPages,
            'recordTotal' => $recordTotal
        ]);
    }

    #[Route('/animals/add', name: 'animal_add', methods: ['POST'])]
    public function addAnimal(Request $request, EntityManagerInterface $em, AnimalValidationService $validationService): RedirectResponse
    {
        $errors = $validationService->validateAnimal($request->request->all());
        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('animal_management_index', ['tab' => 'animaux']);
        }
        $animal = new Animal();
        $this->hydrateAnimal($animal, $request);
        $em->persist($animal);
        $em->flush();
        $this->addFlash('success', 'Animal added successfully.');
        return $this->redirectToRoute('animal_management_index', ['tab' => 'animaux']);
    }

    #[Route('/animals/{id}/update', name: 'animal_update', methods: ['POST'])]
    public function updateAnimal(int $id, Request $request, EntityManagerInterface $em, AnimalValidationService $validationService): RedirectResponse
    {
        $animal = $em->getRepository(Animal::class)->find($id);
        if (!$animal instanceof Animal) {
            throw $this->createNotFoundException();
        }
        $errors = $validationService->validateAnimal($request->request->all());
        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('animal_management_index', ['tab' => 'animaux', 'editAnimalId' => $id]);
        }
        $this->hydrateAnimal($animal, $request);
        $em->flush();
        $this->addFlash('success', 'Animal updated.');
        return $this->redirectToRoute('animal_management_index', ['tab' => 'animaux']);
    }

    #[Route('/animals/{id}/delete', name: 'animal_delete', methods: ['POST'])]
    public function deleteAnimal(int $id, EntityManagerInterface $em): RedirectResponse
    {
        $animal = $em->getRepository(Animal::class)->find($id);
        if ($animal instanceof Animal) {
            $em->remove($animal);
            $em->flush();
            $this->addFlash('success', 'Animal deleted.');
        }
        return $this->redirectToRoute('animal_management_index', ['tab' => 'animaux']);
    }

    #[Route('/records/add', name: 'record_add', methods: ['POST'])]
    public function addRecord(Request $request, EntityManagerInterface $em, AnimalValidationService $validationService): RedirectResponse
    {
        $animal = $em->getRepository(Animal::class)->find((int) $request->request->get('animalId'));
        if (!$animal instanceof Animal) {
            $this->addFlash('error', 'Please select an animal.');
            return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers']);
        }
        $errors = $validationService->validateRecord($request->request->all());
        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers', 'animalId' => $animal->getId()]);
        }
        $record = new AnimalHealthRecord();
        $record->setAnimal($animal);
        $this->hydrateRecord($record, $request, $animal->getType());
        $em->persist($record);
        $animal->setHealthStatus(strtolower((string) $record->getConditionStatus()));
        $animal->setWeight($record->getWeight());
        $em->flush();
        $this->addFlash('success', 'Health record added.');
        return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers', 'animalId' => $animal->getId()]);
    }

    #[Route('/records/visit/save', name: 'record_visit_save', methods: ['POST'])]
    public function saveVisitRecord(Request $request, EntityManagerInterface $em, AnimalValidationService $validationService): RedirectResponse
    {
        $visitLocation = trim((string) $request->request->get('visitLocation'));
        $visitIndex = max(0, (int) $request->request->get('visitIndex'));
        $animalId = (int) $request->request->get('animalId');
        $list = $em->getRepository(Animal::class)->createQueryBuilder('a')
            ->where('LOWER(a.location) = LOWER(:loc)')
            ->setParameter('loc', $visitLocation)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
        $n = count($list);
        if ($n === 0 || $visitIndex >= $n) {
            return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers']);
        }
        $expected = $list[$visitIndex];
        if ($expected->getId() !== $animalId) {
            return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers']);
        }
        $errors = $validationService->validateRecord($request->request->all());
        if ($errors !== []) {
            $this->addFlash('errors', $errors);

            return $this->redirectToRoute('animal_management_index', [
                'tab' => 'dossiers',
                'visit' => 1,
                'visitLocation' => $visitLocation,
                'visitIndex' => $visitIndex,
            ]);
        }
        $record = new AnimalHealthRecord();
        $record->setAnimal($expected);
        $this->hydrateRecord($record, $request, $expected->getType());
        $em->persist($record);
        $expected->setHealthStatus(strtolower((string) $record->getConditionStatus()));
        $expected->setWeight($record->getWeight());
        $em->flush();
        $next = $visitIndex + 1;
        if ($next >= $n) {
            $this->addFlash('success', sprintf('Visite terminée — %d animal(s) traité(s).', $n));

            return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers']);
        }

        return $this->redirectToRoute('animal_management_index', [
            'tab' => 'dossiers',
            'visit' => 1,
            'visitLocation' => $visitLocation,
            'visitIndex' => $next,
        ]);
    }

    #[Route('/records/{id}/update', name: 'record_update', methods: ['POST'])]
    public function updateRecord(int $id, Request $request, EntityManagerInterface $em, AnimalValidationService $validationService): RedirectResponse
    {
        $record = $em->getRepository(AnimalHealthRecord::class)->find($id);
        if (!$record instanceof AnimalHealthRecord) {
            throw $this->createNotFoundException();
        }
        $animal = $record->getAnimal();
        if (!$animal instanceof Animal) {
            $this->addFlash('error', 'Record has no animal.');
            return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers']);
        }
        $errors = $validationService->validateRecord($request->request->all());
        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers', 'animalId' => $animal->getId(), 'editRecordId' => $id]);
        }
        $this->hydrateRecord($record, $request, $animal->getType());
        $animal->setHealthStatus(strtolower((string) $record->getConditionStatus()));
        $animal->setWeight($record->getWeight());
        $em->flush();
        $this->addFlash('success', 'Health record updated.');
        return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers', 'animalId' => $animal->getId()]);
    }

    #[Route('/records/{id}/delete', name: 'record_delete', methods: ['POST'])]
    public function deleteRecord(int $id, EntityManagerInterface $em): RedirectResponse
    {
        $record = $em->getRepository(AnimalHealthRecord::class)->find($id);
        $animalId = $record?->getAnimal()?->getId();
        if ($record instanceof AnimalHealthRecord) {
            $em->remove($record);
            $em->flush();
            $this->addFlash('success', 'Health record deleted.');
        }
        return $this->redirectToRoute('animal_management_index', ['tab' => 'dossiers', 'animalId' => $animalId]);
    }

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
        $subject = 'Animal Health Report — ' . (new \DateTimeImmutable('today'))->format('Y-m-d');
        $body = $reportBuilder->buildBody($atRisk, $notes);
        try {
            $brevoMail->sendTransactionalEmail($vetEmail, $subject, $body);
            $this->addFlash('success', 'Report sent successfully.');
        } catch (\Throwable $e) {
            $this->addFlash('error', 'Failed: ' . $e->getMessage());
        }

        return $this->redirectToRoute('animal_management_index', ['tab' => 'options']);
    }

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
        $state['batchStatus'] = $batchResults === [] ? 'Tous les animaux sont en bonne santé.' : '';
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
        $state['batchStatus'] = $batchResults === [] ? 'Tous les animaux sont en bonne santé.' : '';

        if ($batchResults === []) {
            $state['batchEmailStatus'] = 'Aucun résultat à envoyer.';
            $this->storeAnalyticsState($request, $state);

            return $this->redirectToRoute('animal_management_index', ['tab' => 'predictor']);
        }

        try {
            $brevoMailService->sendTransactionalEmail(
                $email,
                'Rapport de Prédiction IA — ' . (new \DateTimeImmutable('today'))->format('Y-m-d'),
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

    private function hydrateAnimal(Animal $animal, Request $request): void
    {
        $animal->setEarTag((int) $request->request->get('earTag'));
        $animal->setType(strtolower((string) $request->request->get('type')));
        $weight = trim((string) $request->request->get('weight'));
        $animal->setWeight($weight === '' ? null : (float) $weight);
        $birthDate = trim((string) $request->request->get('birthDate'));
        $entryDate = trim((string) $request->request->get('entryDate'));
        $animal->setBirthDate($birthDate === '' ? null : new \DateTimeImmutable($birthDate));
        $animal->setEntryDate($entryDate === '' ? null : new \DateTimeImmutable($entryDate));
        $animal->setOrigin((string) $request->request->get('origin'));
        $animal->setVaccinated($request->request->getBoolean('vaccinated'));
        $animal->setLocation(strtolower((string) $request->request->get('location')));
    }

    private function hydrateRecord(AnimalHealthRecord $record, Request $request, ?string $animalType): void
    {
        $record->setRecordDate(new \DateTimeImmutable((string) $request->request->get('recordDate')));
        $weight = trim((string) $request->request->get('weight'));
        $record->setWeight($weight === '' ? null : (float) $weight);
        $appetite = trim((string) $request->request->get('appetite'));
        $record->setAppetite($appetite === '' ? null : $appetite);
        $record->setConditionStatus((string) $request->request->get('conditionStatus'));
        $record->setMilkYield(null);
        $record->setEggCount(null);
        $record->setWoolLength(null);
        $production = trim((string) $request->request->get('production'));
        $type = strtolower((string) $animalType);
        if ($production !== '') {
            if (in_array($type, ['cow', 'goat'], true)) {
                $record->setMilkYield((float) $production);
            } elseif ($type === 'chicken') {
                $record->setEggCount((int) $production);
            } elseif ($type === 'sheep') {
                $record->setWoolLength((float) $production);
            }
        }
        $notes = trim((string) $request->request->get('notes'));
        $record->setNotes($notes === '' ? null : $notes);
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

    private function buildAnalyticsDashboard(EntityManagerInterface $em, ChartBuilderInterface $chartBuilder): array
    {
        $animals = $em->getRepository(Animal::class)->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
        $records = $em->getRepository(AnimalHealthRecord::class)->createQueryBuilder('r')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult();

        $totalAnimals = count($animals);
        $totalRecords = count($records);
        $vaccinatedCount = count(array_filter($animals, static fn (Animal $animal): bool => $animal->isVaccinated()));
        $vaccinationRate = $totalAnimals === 0 ? 0.0 : ($vaccinatedCount / $totalAnimals) * 100;
        $atRiskCount = count(array_filter($animals, static function (Animal $animal): bool {
            $status = strtolower((string) $animal->getHealthStatus());

            return $status !== '' && $status !== 'healthy';
        }));

        $conditionCounts = [
            'Healthy' => 0,
            'Sick' => 0,
            'Injured' => 0,
            'Critical' => 0,
        ];

        foreach ($records as $record) {
            $key = $this->formatAnalyticsLabel((string) $record->getConditionStatus());

            if (array_key_exists($key, $conditionCounts)) {
                ++$conditionCounts[$key];
            }
        }

        $conditionLabels = [];
        $conditionValues = [];
        $conditionColors = [];
        $conditionPalette = [
            'Healthy' => '#43a047',
            'Sick' => '#f57c00',
            'Injured' => '#1e88e5',
            'Critical' => '#e53935',
        ];

        foreach ($conditionCounts as $label => $value) {
            if ($value <= 0) {
                continue;
            }

            $conditionLabels[] = $label . '  ' . $value;
            $conditionValues[] = $value;
            $conditionColors[] = $conditionPalette[$label];
        }

        $typeCounts = [];
        foreach ($animals as $animal) {
            $type = trim((string) $animal->getType());
            if ($type === '') {
                continue;
            }

            $label = $this->formatAnalyticsLabel($type);
            $typeCounts[$label] = ($typeCounts[$label] ?? 0) + 1;
        }
        arsort($typeCounts);

        $locationCounts = [];
        foreach ($animals as $animal) {
            $location = trim((string) $animal->getLocation());
            if ($location === '') {
                continue;
            }

            $label = $this->formatAnalyticsLabel($location);
            $locationCounts[$label] = ($locationCounts[$label] ?? 0) + 1;
        }
        arsort($locationCounts);

        $conditionChart = $chartBuilder->createChart(Chart::TYPE_PIE);
        $conditionChart->setData([
            'labels' => $conditionLabels,
            'datasets' => [[
                'data' => $conditionValues,
                'backgroundColor' => $conditionColors,
                'borderColor' => '#ffffff',
                'borderWidth' => 2,
                'hoverOffset' => 10,
            ]],
        ]);
        $conditionChart->setOptions([
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'boxWidth' => 14,
                        'padding' => 18,
                        'color' => '#22301b',
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
            ],
        ]);

        $typeChart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $typeChart->setData([
            'labels' => array_keys($typeCounts),
            'datasets' => [[
                'label' => 'Animaux',
                'data' => array_values($typeCounts),
                'backgroundColor' => '#5a9814',
                'borderRadius' => 8,
                'maxBarThickness' => 56,
            ]],
        ]);
        $typeChart->setOptions([
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'color' => '#22301b',
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                        'color' => '#22301b',
                    ],
                    'grid' => [
                        'color' => 'rgba(34, 48, 27, 0.08)',
                    ],
                ],
            ],
        ]);

        return [
            'summary' => [
                'totalAnimals' => $totalAnimals,
                'totalRecords' => $totalRecords,
                'vaccinationRate' => round($vaccinationRate),
                'atRiskCount' => $atRiskCount,
            ],
            'hasConditionData' => $conditionValues !== [],
            'hasTypeData' => $typeCounts !== [],
            'conditionChart' => $conditionChart,
            'typeChart' => $typeChart,
            'locations' => array_map(
                static fn (string $name, int $count): array => ['name' => $name, 'count' => $count],
                array_keys($locationCounts),
                array_values($locationCounts),
            ),
        ];
    }

    private function getEmptyAnalyticsDashboard(): array
    {
        return [
            'summary' => [
                'totalAnimals' => 0,
                'totalRecords' => 0,
                'vaccinationRate' => 0,
                'atRiskCount' => 0,
            ],
            'hasConditionData' => false,
            'hasTypeData' => false,
            'conditionChart' => null,
            'typeChart' => null,
            'locations' => [],
        ];
    }

    private function formatAnalyticsLabel(string $value): string
    {
        $normalized = strtolower(trim($value));

        if ($normalized === '') {
            return '';
        }

        return ucfirst($normalized);
    }
}
