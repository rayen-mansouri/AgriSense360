<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ManagementController extends AbstractController
{
    #[Route('/management/animals', name: 'management_animals')]
    public function animals(): Response
    {
        return $this->render('management/animals.html.twig', [
            'active' => 'animals',
        ]);
    }

    #[Route('/management/equipments', name: 'management_equipments')]
    public function equipments(): Response
    {
        return $this->render('management/equipments.html.twig', [
            'active' => 'equipments',
        ]);
    }

    #[Route('/management/stock', name: 'management_stock')]
    public function stock(): Response
    {
        return $this->render('management/stock.html.twig', [
            'active' => 'stock',
        ]);
    }

    #[Route('/management/culture', name: 'management_culture')]
    public function culture(): Response
    {
        return $this->render('management/culture.html.twig', [
            'active' => 'culture',
        ]);
    }

    #[Route('/management/users', name: 'management_users')]
    public function users(): Response
    {
        return $this->render('management/users.html.twig', [
            'active' => 'users',
        ]);
    }

    #[Route('/management/workers', name: 'management_workers')]
    public function workers(): Response
    {
        return $this->render('management/workers.html.twig', [
            'active' => 'workers',
        ]);
    }
}
