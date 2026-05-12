<?php

namespace App\Controller;

use App\Entity\EvaluationPerformance;
use App\Form\EvaluationPerformanceType;
use App\Repository\EvaluationPerformanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gestion-ouvrier/evaluation')]
class EvaluationPerformanceController extends AbstractController
{
    #[Route('', name: 'evaluation_performance_index', methods: ['GET'])]
    public function index(EvaluationPerformanceRepository $repository): Response
    {
        return $this->render('evaluation_performance/index.html.twig', [
            'evaluations' => $repository->findAll(),
            'active_tab' => 'evaluation',
        ]);
    }

    #[Route('/new', name: 'evaluation_performance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evaluation = new EvaluationPerformance();
        $form = $this->createForm(EvaluationPerformanceType::class, $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evaluation);
            $entityManager->flush();

            $this->addFlash('success', 'Évaluation créée avec succès.');

            return $this->redirectToRoute('evaluation_performance_index');
        }

        return $this->render('evaluation_performance/new.html.twig', [
            'form' => $form,
            'active_tab' => 'evaluation',
        ]);
    }

    #[Route('/{id_evaluation}', name: 'evaluation_performance_show', methods: ['GET'])]
    public function show(#[MapEntity(id: 'id_evaluation')] EvaluationPerformance $evaluation): Response
    {
        return $this->render('evaluation_performance/show.html.twig', [
            'evaluation' => $evaluation,
            'active_tab' => 'evaluation',
        ]);
    }

    #[Route('/{id_evaluation}/edit', name: 'evaluation_performance_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        #[MapEntity(id: 'id_evaluation')] EvaluationPerformance $evaluation,
        EntityManagerInterface $entityManager,
    ): Response {
        $form = $this->createForm(EvaluationPerformanceType::class, $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Évaluation mise à jour avec succès.');

            return $this->redirectToRoute('evaluation_performance_show', ['id_evaluation' => $evaluation->getIdEvaluation()]);
        }

        return $this->render('evaluation_performance/edit.html.twig', [
            'evaluation' => $evaluation,
            'form' => $form,
            'active_tab' => 'evaluation',
        ]);
    }

    #[Route('/{id_evaluation}', name: 'evaluation_performance_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        #[MapEntity(id: 'id_evaluation')] EvaluationPerformance $evaluation,
        EntityManagerInterface $entityManager,
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $evaluation->getIdEvaluation(), (string) $request->request->get('_token'))) {
            $entityManager->remove($evaluation);
            $entityManager->flush();

            $this->addFlash('success', 'Évaluation supprimée avec succès.');
        }

        return $this->redirectToRoute('evaluation_performance_index');
    }
}
