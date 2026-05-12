<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Service\AnimalValidationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AnimalCrudController extends AbstractController
{
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

    private function hydrateAnimal(Animal $animal, Request $request): void
    {
        $animal->setEarTag((int) $request->request->get('earTag'));
        $animal->setType(strtolower((string) $request->request->get('type')));
        $weight = trim((string) $request->request->get('weight'));
        $animal->setWeight($weight === '' ? null : (float) $weight);
        $birthDate = trim((string) $request->request->get('birthDate'));
        $entryDate = trim((string) $request->request->get('entryDate'));
        $animal->setBirthDate($birthDate === '' ? null : new \DateTime($birthDate));
        $animal->setEntryDate($entryDate === '' ? null : new \DateTime($entryDate));
        $animal->setOrigin((string) $request->request->get('origin'));
        $animal->setVaccinated($request->request->getBoolean('vaccinated') ? 1 : 0);
        $animal->setLocation(strtolower((string) $request->request->get('location')));
    }
}
