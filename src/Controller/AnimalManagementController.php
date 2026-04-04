<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalHealthRecord;
use App\Service\AnimalValidationService;
use App\Service\EnumOptionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnimalManagementController extends AbstractController
{
    #[Route('/', name: 'animal_management_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em, EnumOptionService $enumOptionService): Response
    {
        $mode = $this->normalizeMode((string) $request->query->get('mode', 'admin'));
        $availableTabs = $mode === 'admin' ? ['animaux', 'dossiers', 'options', 'analytics'] : ['animaux', 'dossiers'];
        $currentTab = (string) $request->query->get('tab', 'animaux');
        if (!in_array($currentTab, $availableTabs, true)) {
            $currentTab = 'animaux';
        }
        $accessDenied = $mode === 'other_worker';
        if ($accessDenied) {
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
        $selectedAnimalId = (int) $request->query->get('animalId', 0);
        $selectedAnimal = $selectedAnimalId > 0 ? $em->getRepository(Animal::class)->find($selectedAnimalId) : null;
        $records = [];
        $recordPage = max(1, (int) $request->query->get('recordPage', 1));
        $recordTotalPages = 1;
        $recordTotal = 0;
        $recordSort = (string) $request->query->get('recordSort', 'recordDate');
        $recordDir = strtoupper((string) $request->query->get('recordDir', 'DESC')) === 'ASC' ? 'ASC' : 'DESC';
        $recordSearchField = (string) $request->query->get('recordSearchField', 'all');
        $recordSearchTerm = trim((string) $request->query->get('recordSearch', ''));
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
            'mode' => $mode,
            'availableTabs' => $availableTabs,
            'accessDenied' => $accessDenied,
            'currentTab' => $currentTab,
            'animals' => $animals,
            'records' => $records,
            'selectedAnimal' => $selectedAnimal,
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
        $mode = $this->normalizeMode((string) $request->request->get('mode', 'admin'));
        if ($mode === 'other_worker') {
            $this->addFlash('error', 'Not related to your role. Access denied.');
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux']);
        }
        $errors = $validationService->validateAnimal($request->request->all());
        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux']);
        }
        $animal = new Animal();
        $this->hydrateAnimal($animal, $request);
        $em->persist($animal);
        $em->flush();
        $this->addFlash('success', 'Animal added successfully.');
        return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux']);
    }

    #[Route('/animals/{id}/update', name: 'animal_update', methods: ['POST'])]
    public function updateAnimal(int $id, Request $request, EntityManagerInterface $em, AnimalValidationService $validationService): RedirectResponse
    {
        $mode = $this->normalizeMode((string) $request->request->get('mode', 'admin'));
        if ($mode === 'other_worker') {
            $this->addFlash('error', 'Not related to your role. Access denied.');
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux']);
        }
        $animal = $em->getRepository(Animal::class)->find($id);
        if (!$animal instanceof Animal) {
            throw $this->createNotFoundException();
        }
        $errors = $validationService->validateAnimal($request->request->all());
        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux', 'editAnimalId' => $id]);
        }
        $this->hydrateAnimal($animal, $request);
        $em->flush();
        $this->addFlash('success', 'Animal updated.');
        return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux']);
    }

    #[Route('/animals/{id}/delete', name: 'animal_delete', methods: ['POST'])]
    public function deleteAnimal(int $id, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $mode = $this->normalizeMode((string) $request->request->get('mode', 'admin'));
        if ($mode === 'other_worker') {
            $this->addFlash('error', 'Not related to your role. Access denied.');
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux']);
        }
        $animal = $em->getRepository(Animal::class)->find($id);
        if ($animal instanceof Animal) {
            $em->remove($animal);
            $em->flush();
            $this->addFlash('success', 'Animal deleted.');
        }
        return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux']);
    }

    #[Route('/records/add', name: 'record_add', methods: ['POST'])]
    public function addRecord(Request $request, EntityManagerInterface $em, AnimalValidationService $validationService): RedirectResponse
    {
        $mode = $this->normalizeMode((string) $request->request->get('mode', 'admin'));
        if ($mode === 'other_worker') {
            $this->addFlash('error', 'Not related to your role. Access denied.');
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux']);
        }
        $animal = $em->getRepository(Animal::class)->find((int) $request->request->get('animalId'));
        if (!$animal instanceof Animal) {
            $this->addFlash('error', 'Please select an animal.');
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'dossiers']);
        }
        $errors = $validationService->validateRecord($request->request->all());
        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'dossiers', 'animalId' => $animal->getId()]);
        }
        $record = new AnimalHealthRecord();
        $record->setAnimal($animal);
        $this->hydrateRecord($record, $request, $animal->getType());
        $em->persist($record);
        $animal->setHealthStatus(strtolower((string) $record->getConditionStatus()));
        $animal->setWeight($record->getWeight());
        $em->flush();
        $this->addFlash('success', 'Health record added.');
        return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'dossiers', 'animalId' => $animal->getId()]);
    }

    #[Route('/records/{id}/update', name: 'record_update', methods: ['POST'])]
    public function updateRecord(int $id, Request $request, EntityManagerInterface $em, AnimalValidationService $validationService): RedirectResponse
    {
        $mode = $this->normalizeMode((string) $request->request->get('mode', 'admin'));
        if ($mode === 'other_worker') {
            $this->addFlash('error', 'Not related to your role. Access denied.');
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux']);
        }
        $record = $em->getRepository(AnimalHealthRecord::class)->find($id);
        if (!$record instanceof AnimalHealthRecord) {
            throw $this->createNotFoundException();
        }
        $animal = $record->getAnimal();
        if (!$animal instanceof Animal) {
            $this->addFlash('error', 'Record has no animal.');
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'dossiers']);
        }
        $errors = $validationService->validateRecord($request->request->all());
        if ($errors !== []) {
            $this->addFlash('errors', $errors);
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'dossiers', 'animalId' => $animal->getId(), 'editRecordId' => $id]);
        }
        $this->hydrateRecord($record, $request, $animal->getType());
        $animal->setHealthStatus(strtolower((string) $record->getConditionStatus()));
        $animal->setWeight($record->getWeight());
        $em->flush();
        $this->addFlash('success', 'Health record updated.');
        return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'dossiers', 'animalId' => $animal->getId()]);
    }

    #[Route('/records/{id}/delete', name: 'record_delete', methods: ['POST'])]
    public function deleteRecord(int $id, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $mode = $this->normalizeMode((string) $request->request->get('mode', 'admin'));
        if ($mode === 'other_worker') {
            $this->addFlash('error', 'Not related to your role. Access denied.');
            return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'animaux']);
        }
        $record = $em->getRepository(AnimalHealthRecord::class)->find($id);
        $animalId = $record?->getAnimal()?->getId();
        if ($record instanceof AnimalHealthRecord) {
            $em->remove($record);
            $em->flush();
            $this->addFlash('success', 'Health record deleted.');
        }
        return $this->redirectToRoute('animal_management_index', ['mode' => $mode, 'tab' => 'dossiers', 'animalId' => $animalId]);
  