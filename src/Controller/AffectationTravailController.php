<?php

namespace App\Controller;

use App\Entity\AffectationTravail;
use App\Form\AffectationTravailType;
use App\Repository\AffectationTravailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gestion-ouvrier/affectation')]
class AffectationTravailController extends AbstractController
{
    #[Route('', name: 'affectation_travail_index', methods: ['GET'])]
    public function index(AffectationTravailRepository $repository): Response
    {
        $affectations = $repository->findAll();

        return $this->render('affectation_travail/index.html.twig', [
            'affectations' => $affectations,
            'active_tab' => 'affectation',
        ]);
    }

    #[Route('/new', name: 'affectation_travail_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $affectation = new AffectationTravail();
        $form = $this->createForm(AffectationTravailType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($affectation);
            $entityManager->flush();

            $this->addFlash('success', 'Assignation créée avec succès.');
            return $this->redirectToRoute('affectation_travail_index');
        }

        return $this->render('affectation_travail/new.html.twig', [
            'form' => $form,
            'active_tab' => 'affectation',
        ]);
    }

    #[Route('/{id_affectation}', name: 'affectation_travail_show', methods: ['GET'])]
    public function show(AffectationTravail $affectation): Response
    {
        return $this->render('affectation_travail/show.html.twig', [
            'affectation' => $affectation,
            'active_tab' => 'affectation',
        ]);
    }

    #[Route('/{id_affectation}/edit', name: 'affectation_travail_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AffectationTravail $affectation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AffectationTravailType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Assignation mise à jour avec succès.');
            return $this->redirectToRoute('affectation_travail_show', ['id_affectation' => $affectation->getId_affectation()]);
        }

        return $this->render('affectation_travail/edit.html.twig', [
            'affectation' => $affectation,
            'form' => $form,
            'active_tab' => 'affectation',
        ]);
    }

    #[Route('/{id_affectation}', name: 'affectation_travail_delete', methods: ['POST'])]
    public function delete(Request $request, AffectationTravail $affectation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $affectation->getId_affectation(), $request->request->get('_token'))) {
            $entityManager->remove($affectation);
            $entityManager->flush();

            $this->addFlash('success', 'Assignation supprimée avec succès.');
        }

        return $this->redirectToRoute('affectation_travail_index');
    }
}
