<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PendingController extends AbstractController
{
    #[Route('/pending', name: 'app_pending')]
    public function index(): Response
    {
        return $this->render('user/pending.html.twig');
    }
}