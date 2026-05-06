<?php

namespace App\Controller;

use App\Repository\FarmRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ouvrier')]
class WorkerController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private FarmRepository $farmRepository,
        private UserRepository $userRepository,
    ) {}

    // ── Farm Browser ───────────────────────────────────────────────────────
    #[Route('/farms', name: 'ouvrier_farms', methods: ['GET'])]
    public function farms(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $worker      = $this->getUser();
        $allFarms    = $this->farmRepository->findAll();
        $appliedFarm = $worker->getFarm();

        // Fetch and clear any pending notification (shown once)
        $notification = $worker->getPendingNotification();
        if ($notification) {
            $worker->setPendingNotification(null);
            $this->em->flush();
        }

        return $this->render('ouvrier/farms.html.twig', [
            'farms'        => $allFarms,
            'worker'       => $worker,
            'appliedFarm'  => $appliedFarm,
            'notification' => $notification,
        ]);
    }

    // ── Apply to Farm — AJAX POST ──────────────────────────────────────────
    // Returns JSON always, even on failure, so the browser never gets an HTML redirect
    #[Route('/apply/{id}', name: 'ouvrier_apply', methods: ['POST'])]
    public function apply(int $id, Request $request): JsonResponse
    {
        try {
            $worker = $this->getUser();
            if (!$worker) {
                return new JsonResponse(['success' => false, 'message' => 'Non authentifié. Reconnectez-vous.'], 401);
            }

            if ($worker->getFarm() !== null) {
                return new JsonResponse(['success' => false, 'message' => 'Vous avez déjà postulé à une ferme. Retirez votre candidature d\'abord.']);
            }

            $farm = $this->farmRepository->find($id);
            if (!$farm) {
                return new JsonResponse(['success' => false, 'message' => 'Ferme introuvable (ID: ' . $id . ').']);
            }

            // ── CV File validation ─────────────────────────────────────────
            $cvFile = $request->files->get('cv');
            if (!$cvFile) {
                return new JsonResponse(['success' => false, 'message' => 'Aucun CV reçu. Sélectionnez un fichier PDF.']);
            }

            $mime = $cvFile->getMimeType();
            $allowedMimes = ['application/pdf', 'application/x-pdf', 'application/octet-stream'];
            $ext = strtolower($cvFile->getClientOriginalExtension());
            if (!in_array($mime, $allowedMimes) && $ext !== 'pdf') {
                return new JsonResponse(['success' => false, 'message' => 'Format invalide: ' . $mime . '. PDF uniquement.']);
            }

            if ($cvFile->getSize() > 5 * 1024 * 1024) {
                return new JsonResponse(['success' => false, 'message' => 'Le CV ne doit pas dépasser 5 Mo.']);
            }

            // ── Save CV ────────────────────────────────────────────────────
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = 'cv_' . $worker->getId() . '_' . uniqid() . '.pdf';
            $cvFile->move($uploadDir, $filename);
            $cvPath = $uploadDir . $filename;

            // ── Gemini AI (optional — never blocks submission) ────────────
            $aiRole = 'ROLE_OUVRIER';
            $reason = 'Analyse en attente de vérification manuelle';

            try {
                $geminiKey  = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY') ?? '';
                $projectDir = $this->getParameter('kernel.project_dir');

                if (!empty($geminiKey) && function_exists('shell_exec')) {
                    putenv("GEMINI_API_KEY={$geminiKey}");
                    $pyScript  = $projectDir . '/ai/analyze.py';
                    $pyPathArg = escapeshellarg($cvPath);

                    // Try python3 first, then python
                    $rawOutput = shell_exec("python3 {$pyScript} {$pyPathArg} 2>&1");
                    if (empty(trim($rawOutput ?? ''))) {
                        $rawOutput = shell_exec("python {$pyScript} {$pyPathArg} 2>&1");
                    }

                    if (!empty($rawOutput)) {
                        $cleaned = preg_replace('/```(?:json)?|```/', '', $rawOutput);
                        $data    = @json_decode(trim($cleaned), true);
                        if (is_array($data) && isset($data['role'])) {
                            $aiRole = in_array($data['role'], ['ROLE_GERANT', 'ROLE_OUVRIER'])
                                ? $data['role'] : 'ROLE_OUVRIER';
                            $reason = $data['reason'] ?? $reason;
                        }
                    }
                }
            } catch (\Throwable $aiErr) {
                // AI failed — proceed with default role, don't block submission
            }

            // ── Persist ────────────────────────────────────────────────────
            $worker->setFarm($farm);
            $worker->setStatus('pending');
            $worker->setCvFile($filename);
            $worker->setAiSuggestedRole($aiRole);
            $worker->setDecisionReason($reason);
            $worker->setUpdatedAt(new \DateTime());
            $this->em->flush();

            $aiLabel = $aiRole === 'ROLE_GERANT' ? 'Gérant' : 'Ouvrier';

            return new JsonResponse([
                'success'  => true,
                'message'  => "Candidature envoyée à « {$farm->getName()} » ! L'IA vous recommande comme {$aiLabel}. Le propriétaire vous contactera.",
                'aiRole'   => $aiLabel,
                'farmName' => $farm->getName(),
            ]);

        } catch (\Throwable $e) {
            // Catch everything — always return JSON
            return new JsonResponse([
                'success' => false,
                'message' => 'Erreur serveur: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ── Withdraw Application ───────────────────────────────────────────────
    #[Route('/withdraw', name: 'ouvrier_withdraw', methods: ['POST'])]
    public function withdraw(): Response
    {
        $worker = $this->getUser();
        if (!$worker) return $this->redirectToRoute('app_login');

        if ($worker->getStatus() === 'pending' && $worker->getFarm() !== null) {
            $worker->setFarm(null);
            $worker->setCvFile(null);
            $worker->setAiSuggestedRole(null);
            $worker->setDecisionReason(null);
            $this->em->flush();
            $this->addFlash('info', 'Candidature retirée. Vous pouvez postuler à une autre ferme.');
        }

        return $this->redirectToRoute('ouvrier_farms');
    }
}
