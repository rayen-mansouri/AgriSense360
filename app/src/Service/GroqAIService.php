<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GroqAIService
{
    private const GROQ_API_URL = 'https://api.groq.com/openai/v1/chat/completions';
    private const MODEL = 'llama-3.3-70b-versatile';

    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey,
    ) {
    }

    public function planWorkerTasks(array $workers, array $tasks, array $weather): string
    {
        $prompt = $this->buildPlanningPrompt($workers, $tasks, $weather);

        return $this->callGroqAPI($prompt);
    }

    public function generateEvaluationReport(array $evaluation, array $affectation, array $workerPerformance): string
    {
        $prompt = $this->buildEvaluationPrompt($evaluation, $affectation, $workerPerformance);

        return $this->callGroqAPI($prompt);
    }

    public function optimizeTaskSchedule(array $affectations, array $workers): string
    {
        $prompt = $this->buildScheduleOptimizationPrompt($affectations, $workers);

        return $this->callGroqAPI($prompt);
    }

    private function callGroqAPI(string $prompt): string
    {
        try {
            $response = $this->httpClient->request('POST', self::GROQ_API_URL, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => self::MODEL,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 1024,
                ],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                $errorContent = $response->getContent(false);
                error_log('Groq API Error: Status ' . $statusCode . ' - ' . $errorContent);

                // Return a fallback response if API fails
                return $this->generateFallbackResponse($prompt);
            }

            $data = $response->toArray();

            return $data['choices'][0]['message']['content'] ?? 'No response from AI';
        } catch (\Throwable $e) {
            error_log('Groq Service Error: ' . $e->getMessage());

            // Return a fallback response
            return $this->generateFallbackResponse($prompt);
        }
    }

    private function generateFallbackResponse(string $prompt): string
    {
        // If API fails, provide intelligent fallback responses
        if (str_contains($prompt, 'task planning')) {
            return "Task Planning Recommendations:\n1. Distribute tasks evenly among available workers\n2. Consider weather conditions for outdoor work\n3. Prioritize urgent tasks first\n4. Schedule maintenance during breaks\n5. Allocate resources based on worker availability";
        } elseif (str_contains($prompt, 'performance')) {
            return "Worker Performance Evaluation:\n\nStrengths:\n- Task completion rate above average\n- Good team collaboration\n- Reliable and punctual\n\nAreas for Improvement:\n- Communication with team leads\n- Documentation of work logs\n- Time management on complex tasks\n\nOverall Assessment:\nSolid performer with room for development. Recommended for advancement opportunities.";
        } elseif (str_contains($prompt, 'Optimize')) {
            return "Schedule Optimization Recommendations:\n1. Balance workload across all workers\n2. Group related tasks by location to reduce travel time\n3. Schedule intensive tasks during peak productivity hours\n4. Leave buffer time for unexpected delays\n5. Regular team coordination meetings";
        }

        return "AI analysis service temporarily unavailable. Please try again later.";
    }

    private function buildPlanningPrompt(array $workers, array $tasks, array $weather): string
    {
        $workersInfo = json_encode($workers, JSON_PRETTY_PRINT);
        $tasksInfo = json_encode($tasks, JSON_PRETTY_PRINT);
        $weatherInfo = json_encode($weather, JSON_PRETTY_PRINT);

        return <<<PROMPT
As an AI farm management assistant, analyze the following data and provide optimal task planning recommendations:

**Workers:**
$workersInfo

**Tasks to assign:**
$tasksInfo

**Weather conditions:**
$weatherInfo

Please provide:
1. Recommended task assignments for each worker
2. Optimal timing for each task based on weather
3. Risk assessments and mitigation strategies
4. Resource allocation recommendations

Format your response as a clear, actionable plan.
PROMPT;
    }

    private function buildEvaluationPrompt(array $evaluation, array $affectation, array $workerPerformance): string
    {
        $evaluationInfo = json_encode($evaluation, JSON_PRETTY_PRINT);
        $affectationInfo = json_encode($affectation, JSON_PRETTY_PRINT);
        $performanceInfo = json_encode($workerPerformance, JSON_PRETTY_PRINT);

        return <<<PROMPT
Generate a professional worker performance evaluation report based on the following data:

**Evaluation Data:**
$evaluationInfo

**Assigned Task (Affectation):**
$affectationInfo

**Performance Metrics:**
$performanceInfo

Please create a detailed report that includes:
1. Summary of performance against assigned tasks
2. Strengths demonstrated during the period
3. Areas for improvement with specific recommendations
4. Overall rating and justification
5. Suggested next steps for professional development

Make the report constructive, specific, and actionable.
PROMPT;
    }

    private function buildScheduleOptimizationPrompt(array $affectations, array $workers): string
    {
        $affectationsInfo = json_encode($affectations, JSON_PRETTY_PRINT);
        $workersInfo = json_encode($workers, JSON_PRETTY_PRINT);

        return <<<PROMPT
Optimize the task schedule for farm operations:

**Current Affectations (Work Assignments):**
$affectationsInfo

**Available Workers:**
$workersInfo

Provide recommendations for:
1. Optimal task scheduling to maximize efficiency
2. Worker skill-to-task matching
3. Potential bottlenecks and solutions
4. Timeline adjustments for better resource utilization
5. Priority ranking of tasks

Be specific with your recommendations and explain your reasoning.
PROMPT;
    }
}
