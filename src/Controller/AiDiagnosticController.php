<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class AiDiagnosticController extends AbstractController
{
    public function __construct(
        private string $groqKey
    ) {}

    #[Route('/admin/ai-diagnostic', name: 'admin_ai_diagnostic')]
    public function index(): Response
    {
        $results = [];

        // 1. Test Groq Connection
        $results['groq'] = $this->testGroq($this->groqKey);

        // 2. Test Local ML Service (Flask)
        $results['flask'] = $this->testFlask();

        return $this->render('admin/ai_diagnostic.html.twig', [
            'results' => $results,
            'groqKey' => $this->groqKey ? 'Configurée ('.substr($this->groqKey,0,6).'...)' : 'Manquante'
        ]);
    }

    private function testGroq(string $key): array
    {
        if (!$key) return ['status' => 'error', 'message' => 'Clé API manquante dans .env'];

        $client = HttpClient::create([
            'max_duration' => 30, // Global timeout
        ]);
        try {
            $start = microtime(true);
            $response = $client->request('POST', 'https://api.groq.com/openai/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $key,
                    'Content-Type'  => 'application/json',
                ],
                'timeout' => 25, // Wait up to 25s for first byte
                'json' => [
                    'model'    => 'llama3-8b-8192',
                    'messages' => [['role' => 'user', 'content' => 'Hello, are you online? Respond with "OK"']],
                    'max_tokens' => 10
                ],
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                return [
                    'status' => 'success',
                    'message' => 'Connexion Groq établie avec succès',
                    'latency' => round((microtime(true) - $start) * 1000) . 'ms'
                ];
            }
            
            $content = $response->getContent(false);
            return [
                'status' => 'error', 
                'message' => 'Erreur API Groq (HTTP ' . $statusCode . ') : ' . substr($content, 0, 100)
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error', 
                'message' => 'Erreur de connexion : ' . $e->getMessage() . '. Vérifiez votre connexion internet.'
            ];
        }
    }

    private function testFlask(): array
    {
        $url = 'http://127.0.0.1:8001/ping';
        $client = HttpClient::create();
        try {
            $start = microtime(true);
            $response = $client->request('GET', $url, ['timeout' => 2]);
            if ($response->getStatusCode() === 200) {
                return [
                    'status' => 'success',
                    'message' => 'Service ML Python (Flask) est en ligne',
                    'latency' => round((microtime(true) - $start) * 1000) . 'ms'
                ];
            }
            return ['status' => 'error', 'message' => 'Service Flask injoignable (HTTP ' . $response->getStatusCode() . ')'];
        } catch (\Exception $e) {
            return ['status' => 'warning', 'message' => 'Service Flask hors-ligne (Vérifiez si le script Python tourne sur le port 8001)'];
        }
    }
}
