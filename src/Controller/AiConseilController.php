<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Proxies Groq AI requests server-side so the API key is never exposed to the browser.
 *
 * Usage: POST /ai-conseil
 * Body (JSON): { "prompt": "..." }
 * Returns: { "content": "..." }  (the AI text)
 *
 * Set the key in .env:  GROQ_API_KEY=gsk_...
 */
class AiConseilController extends AbstractController
{
    #[Route('/ai-conseil', name: 'ai_conseil', methods: ['POST'])]
    public function conseil(Request $request): JsonResponse
    {
        $groqKey = $_ENV['GROQ_API_KEY'] ?? '';
        if (!$groqKey) {
            return $this->json(['error' => 'Clé Groq non configurée (GROQ_API_KEY manquant dans .env)'], 500);
        }

        $body   = json_decode($request->getContent(), true);
        $prompt = trim($body['prompt'] ?? '');

        if (!$prompt) {
            return $this->json(['error' => 'Prompt manquant'], 400);
        }

        $client = HttpClient::create();
        try {
            $response = $client->request('POST', 'https://api.groq.com/openai/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $groqKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model'       => 'llama-3.3-70b-versatile',
                    'max_tokens'  => 600,
                    'temperature' => 0.7,
                    'messages'    => [['role' => 'user', 'content' => $prompt]],
                ],
            ]);

            $data    = $response->toArray();
            $content = $data['choices'][0]['message']['content'] ?? 'Aucune réponse.';
            return $this->json(['content' => $content]);

        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, '401')) return $this->json(['error' => 'Clé Groq invalide ou expirée'], 401);
            if (str_contains($msg, '429')) return $this->json(['error' => 'Trop de requêtes — réessayez dans 30s'], 429);
            return $this->json(['error' => $msg], 500);
        }
    }
}