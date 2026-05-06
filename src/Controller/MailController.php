<?php
// src/Controller/MailController.php
namespace App\Controller;

use App\Service\CultureService;
use App\Service\MailService;
use App\Service\ParcelleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mail', name: 'mail_')]
class MailController extends AbstractController
{
    public function __construct(
        private MailService     $mailService,
        private CultureService  $cultureService,
        private ParcelleService $parcelleService,
    ) {}

    // ── Test connection ───────────────────────────────────────────────
    #[Route('/test', name: 'test', methods: ['GET'])]
    public function test(): JsonResponse
    {
        $ok = $this->mailService->sendTestEmail();
        return $this->json([
            'success' => $ok,
            'message' => $ok ? '✅ E-mail de test envoyé avec succès !' : '❌ Échec de l\'envoi',
        ]);
    }

    // ── Alert for one culture ─────────────────────────────────────────
    #[Route('/culture/{id}/alert', name: 'culture_alert', methods: ['POST'])]
    public function cultureAlert(int $id): JsonResponse
    {
        $culture = $this->cultureService->getCultureById($id);
        if (!$culture) {
            return $this->json(['success' => false, 'message' => 'Culture introuvable'], Response::HTTP_NOT_FOUND);
        }

        $ok = $this->mailService->sendCultureAlert($culture);
        return $this->json([
            'success' => $ok,
            'message' => $ok ? '✅ Alerte culture envoyée !' : '❌ Échec de l\'envoi',
        ]);
    }

    // ── Alert for one parcelle ────────────────────────────────────────
    #[Route('/parcelle/{id}/alert', name: 'parcelle_alert', methods: ['POST'])]
    public function parcelleAlert(int $id): JsonResponse
    {
        $parcelle = $this->parcelleService->getParcelleById($id);
        if (!$parcelle) {
            return $this->json(['success' => false, 'message' => 'Parcelle introuvable'], Response::HTTP_NOT_FOUND);
        }

        $reason = $parcelle->getStatut() === 'Occupée'
            ? 'Surface totalement occupée'
            : 'Mise à jour de la parcelle';

        $ok = $this->mailService->sendParcelleAlert($parcelle, $reason);
        return $this->json([
            'success' => $ok,
            'message' => $ok ? '✅ Alerte parcelle envoyée !' : '❌ Échec de l\'envoi',
        ]);
    }

    // ── Daily digest ──────────────────────────────────────────────────
    #[Route('/digest', name: 'digest', methods: ['GET', 'POST'])]
    public function digest(): JsonResponse
    {
        $cultures = $this->cultureService->getAllCultures();
        $ok = $this->mailService->sendDailyDigest($cultures);
        return $this->json([
            'success' => $ok,
            'message' => $ok
                ? sprintf('✅ Rapport quotidien envoyé (%d cultures)', count($cultures))
                : '❌ Échec de l\'envoi',
        ]);
    }

    // ── Harvests scheduled for today ──────────────────────────────────
    #[Route('/harvests/today', name: 'harvests_today', methods: ['GET'])]
    public function harvestsToday(): JsonResponse
    {
        $cultures = $this->cultureService->getCulturesHarvestingToday();
        if (count($cultures) === 0) {
            return $this->json([
                'success' => false,
                'message' => 'ℹ️ Aucune culture à récolter aujourd\'hui',
                'count'   => 0,
            ]);
        }

        $ok = $this->mailService->sendTodayHarvestDigest($cultures);
        return $this->json([
            'success' => $ok,
            'message' => $ok
                ? sprintf('✅ Email de récoltes du jour envoyé (%d cultures)', count($cultures))
                : '❌ Échec de l\'envoi',
            'count' => count($cultures),
        ]);
    }

    // ── Alerts for ALL cultures in retard / récolte prévue ───────────
    #[Route('/cultures/alerts', name: 'cultures_alerts', methods: ['POST'])]
    public function culturesAlerts(): JsonResponse
    {
        $cultures = $this->cultureService->getAllCultures();
        $alertStates = ['Récolte en Retard', 'Récolte Prévue', 'Maturité'];

        $sent = 0;
        $failed = 0;
        foreach ($cultures as $c) {
            if (in_array($c->getEtat(), $alertStates, true)) {
                $this->mailService->sendCultureAlert($c) ? $sent++ : $failed++;
            }
        }

        return $this->json([
            'success' => $failed === 0,
            'message' => "✅ {$sent} alerte(s) envoyée(s)" . ($failed ? ", ❌ {$failed} échec(s)" : ''),
            'sent'    => $sent,
            'failed'  => $failed,
        ]);
    }
}
