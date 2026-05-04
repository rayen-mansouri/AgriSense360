<?php
namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserOnboardingService
{
    public function process(User $user, UploadedFile $cvFile): array
    {
        $filename = uniqid().'.'.$cvFile->guessExtension();
        $cvFile->move('public/uploads', $filename);

        // 🚀 Call Python AI
        $response = shell_exec("python ai/analyze.py public/uploads/".$filename);

        $result = json_decode($response, true);

        return [
            'filename' => $filename,
            'role' => $result['role'] ?? 'ROLE_OUVRIER',
            'decision' => $result['decision'] ?? 'pending',
            'reason' => $result['reason'] ?? ''
        ];
    }
}