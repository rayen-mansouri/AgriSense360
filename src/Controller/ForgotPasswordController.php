<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ForgotPasswordController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
    ) {}

    // ── ÉTAPE 1 : Formulaire email ─────────────────────────────────────────
    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function forgotPassword(Request $request, MailerInterface $mailer): Response
    {
        $error   = null;
        $success = null;

        if ($request->isMethod('POST')) {
            // CSRF check
            if (!$this->isCsrfTokenValid('forgot_password', $request->request->get('_token'))) {
                $error = $this->translator->trans('reset_password.error.invalid_token');
            } else {
                $emailInput = trim($request->request->get('email', ''));
                $user = $this->em->getRepository(User::class)->findOneBy(['email' => $emailInput]);

                if ($user) {
                    $code = (string) random_int(100000, 999999);
                    $user->setResetToken($code);
                    $user->setResetTokenExpiresAt(new \DateTime('+15 minutes'));
                    $this->em->flush();

                    $emailMessage = (new Email())
                        ->from('ahoudadouda@gmail.com')
                        ->to($user->getEmail())
                        ->subject($this->translator->trans('reset_password.email.subject'))
                        ->html($this->renderView('forgot_password/email.html.twig', [
                            'code'     => $code,
                            'userName' => $user->getName(),
                        ]));

                    $mailer->send($emailMessage);
                    $request->getSession()->set('reset_email', $emailInput);
                }

                $success = $this->translator->trans('reset_password.success.request_sent');
            }
        }

        return $this->render('forgot_password/request.html.twig', [
            'error'   => $error,
            'success' => $success,
        ]);
    }

    // ── ÉTAPE 2 : Vérifier le code ─────────────────────────────────────────
    #[Route('/verify-code', name: 'app_verify_code')]
    public function verifyCode(Request $request): Response
    {
        $error        = null;
        $sessionEmail = $request->getSession()->get('reset_email');

        if (!$sessionEmail) {
            return $this->redirectToRoute('app_forgot_password');
        }

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('verify_code', $request->request->get('_token'))) {
                $error = $this->translator->trans('reset_password.error.invalid_token');
            } else {
                $codeInput = trim($request->request->get('code', ''));
                $user = $this->em->getRepository(User::class)->findOneBy(['email' => $sessionEmail]);

                if (!$user || $user->getResetToken() === null) {
                    $error = $this->translator->trans('reset_password.error.invalid_code');
                } elseif ($user->getResetTokenExpiresAt() < new \DateTime()) {
                    $error = $this->translator->trans('reset_password.error.expired_code');
                } elseif ($user->getResetToken() !== $codeInput) {
                    $error = $this->translator->trans('reset_password.error.incorrect_code');
                } else {
                    $request->getSession()->set('reset_verified', true);
                    return $this->redirectToRoute('app_reset_password_new');
                }
            }
        }

        return $this->render('forgot_password/verify.html.twig', [
            'error' => $error,
        ]);
    }

    // ── ÉTAPE 3 : Nouveau mot de passe ────────────────────────────────────
    #[Route('/reset-password-new', name: 'app_reset_password_new')]
    public function resetPasswordNew(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $sessionEmail = $request->getSession()->get('reset_email');
        $verified     = $request->getSession()->get('reset_verified');

        if (!$sessionEmail || !$verified) {
            return $this->redirectToRoute('app_forgot_password');
        }

        $error = null;

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('reset_password', $request->request->get('_token'))) {
                $error = $this->translator->trans('reset_password.error.invalid_token');
            } else {
                $password = $request->request->get('password', '');
                $confirm  = $request->request->get('confirm', '');

                if (strlen($password) < 8) {
                    $error = $this->translator->trans('reset_password.error.password_length');
                } elseif ($password !== $confirm) {
                    $error = $this->translator->trans('profile.password_mismatch');
                } else {
                    $user = $this->em->getRepository(User::class)->findOneBy(['email' => $sessionEmail]);

                    if ($user) {
                        $user->setPassword($hasher->hashPassword($user, $password));
                        $user->setResetToken(null);
                        $user->setResetTokenExpiresAt(null);
                        $this->em->flush();

                        $request->getSession()->remove('reset_email');
                        $request->getSession()->remove('reset_verified');

                        $this->addFlash('success', $this->translator->trans('reset_password.success.reset_complete'));
                        return $this->redirectToRoute('app_login');
                    }
                }
            }
        }

        return $this->render('forgot_password/reset.html.twig', [
            'error' => $error,
        ]);
    }
}