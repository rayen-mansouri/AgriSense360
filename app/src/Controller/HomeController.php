<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'dashboardMode' => 'user',
            'switchTarget' => 'admin_home',
            'switchLabel' => 'Open Admin',
        ]);
    }

    #[Route('/admin', name: 'admin_home')]
    public function admin(): Response
    {
        return $this->render('home/index.html.twig', [
            'dashboardMode' => 'admin',
            'switchTarget' => 'home',
            'switchLabel' => 'Open User',
        ]);
    }
}
