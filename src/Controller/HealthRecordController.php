<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalHealthRecord;
use App\Service\AnimalValidationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HealthRecordController extends AbstractController
{
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
        $count = count($list);

        if ($count === 0 || $visitIndex >= $count) {
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
        if ($next >= $count) {
            $this->addFlash('success', sprintf('Visite terminee - %d animal(s) traite(s).', $count));

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
}
