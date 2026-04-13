<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ComingSoonController
 *
 * WHY THIS EXISTS:
 * The original base.html.twig used path('coming_soon', {module:'Animals', icon:'🐄'})
 * which caused the RouteNotFoundException that crashed the entire app.
 *
 * The fix: we remove all path('coming_soon') calls from base.html.twig and
 * instead render the teammates' modules as non-clickable "Bientôt" badges.
 * This controller is kept as a FALLBACK in case any old link still appears.
 *
 * ROUTE: GET /coming-soon?module=Animals+Management&icon=🐄
 */
#[Route('/coming-soon', name: 'coming_soon', methods: ['GET'])]
class ComingSoonController extends AbstractController
{
    public function index(): Response
    {
        return new Response(
            '<!DOCTYPE html><html><head><title>Bientôt disponible</title>
            <style>body{font-family:sans-serif;display:flex;align-items:center;
            justify-content:center;height:100vh;background:#f0f5f1;margin:0;}
            .box{text-align:center;padding:40px;background:#fff;border-radius:16px;}
            h2{color:#1e3d2f;}p{color:#8fa898;}</style></head>
            <body><div class="box">
            <div style="font-size:3rem">🚧</div>
            <h2>Module en cours d\'intégration</h2>
            <p>Ce module sera disponible prochainement.</p>
            <a href="/" style="color:#3a7252;">← Retour au tableau de bord</a>
            </div></body></html>',
            200
        );
    }
}