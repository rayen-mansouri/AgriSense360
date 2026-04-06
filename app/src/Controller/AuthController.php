<?php

namespace App\Controller;

use App\Service\OracleSqlPlusCrudService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AuthController extends AbstractController
{
    #[Route('/', name: 'intro', methods: ['GET'])]
    public function intro(Request $request): Response
    {
        $mode = $this->normalizeMode((string) $request->query->get('mode', 'user'));

        return $this->render('intro/index.html.twig', [
            'mode' => $mode,
            'switchTargetMode' => $mode === 'admin' ? 'user' : 'admin',
            'switchLabel' => $mode === 'admin' ? 'Switch to User' : 'Switch to Admin',
        ]);
    }

    #[Route('/auth/login', name: 'auth_login', methods: ['GET', 'POST'])]
    public function login(Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $mode = $this->normalizeMode((string) $request->query->get('mode', 'user'));

        if ($request->isMethod('POST')) {
            $email = trim((string) $request->request->get('email'));
            $password = (string) $request->request->get('password');

            if ($email === '' || $password === '') {
                $this->addFlash('error', 'Email and password are required.');

                return $this->redirectToRoute('auth_login', ['mode' => $mode]);
            }

            try {
                $user = $oracleCrud->findUserByEmail($email);
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to access user database: ' . $e->getMessage());

                return $this->redirectToRoute('auth_login', ['mode' => $mode]);
            }

            if (!$user || !password_verify($password, (string) ($user['passwordHash'] ?? ''))) {
                $this->addFlash('error', 'Invalid credentials.');

                return $this->redirectToRoute('auth_login', ['mode' => $mode]);
            }

            if (strtolower((string) ($user['status'] ?? 'active')) !== 'active') {
                $this->addFlash('error', 'Account is not active.');

                return $this->redirectToRoute('auth_login', ['mode' => $mode]);
            }

            $isAdmin = $this->isAdminRole((string) ($user['roleName'] ?? 'user'));
            if ($mode === 'admin' && !$isAdmin) {
                $this->addFlash('error', 'This account is not an admin account.');

                return $this->redirectToRoute('auth_login', ['mode' => $mode]);
            }

            if ($mode === 'user' && $isAdmin) {
                $this->addFlash('error', 'Use admin mode for this account.');

                return $this->redirectToRoute('auth_login', ['mode' => 'admin']);
            }

            $session = $request->getSession();
            $session->set('auth_user_id', (int) $user['id']);
            $session->set('auth_role', $isAdmin ? 'admin' : 'user');
            $session->set('auth_user_name', trim((string) ($user['firstName'] . ' ' . $user['lastName'])));

            return $this->redirectToRoute($isAdmin ? 'admin_home' : 'home');
        }

        return $this->render('auth/form.html.twig', [
            'mode' => $mode,
            'authType' => 'login',
            'title' => $mode === 'admin' ? 'Admin Login' : 'User Login',
            'submitLabel' => 'Log In',
        ]);
    }

    #[Route('/auth/signup', name: 'auth_signup', methods: ['GET', 'POST'])]
    public function signup(Request $request, OracleSqlPlusCrudService $oracleCrud): Response
    {
        $mode = $this->normalizeMode((string) $request->query->get('mode', 'user'));

        if ($request->isMethod('POST')) {
            $firstName = trim((string) $request->request->get('first_name'));
            $lastName = trim((string) $request->request->get('last_name'));
            $email = trim((string) $request->request->get('email'));
            $password = (string) $request->request->get('password');

            if ($firstName === '' || $lastName === '' || $email === '' || $password === '') {
                $this->addFlash('error', 'All fields are required.');

                return $this->redirectToRoute('auth_signup', ['mode' => $mode]);
            }

            try {
                $existingUser = $oracleCrud->findUserByEmail($email);
                if ($existingUser) {
                    $this->addFlash('error', 'Email already exists.');

                    return $this->redirectToRoute('auth_signup', ['mode' => $mode]);
                }

                $roleName = $mode === 'admin' ? 'ADMIN' : 'USER';
                $oracleCrud->createUser([
                    'lastName' => $lastName,
                    'firstName' => $firstName,
                    'email' => $email,
                    'passwordHash' => password_hash($password, PASSWORD_BCRYPT),
                    'status' => 'Active',
                    'roleName' => $roleName,
                ]);

                $newUser = $oracleCrud->findUserByEmail($email);
                if (!$newUser) {
                    throw new \RuntimeException('Unable to load newly created account.');
                }

                $isAdmin = $this->isAdminRole((string) ($newUser['roleName'] ?? $roleName));
                $session = $request->getSession();
                $session->set('auth_user_id', (int) $newUser['id']);
                $session->set('auth_role', $isAdmin ? 'admin' : 'user');
                $session->set('auth_user_name', trim((string) ($newUser['firstName'] . ' ' . $newUser['lastName'])));

                return $this->redirectToRoute($isAdmin ? 'admin_home' : 'home');
            } catch (\Throwable $e) {
                $this->addFlash('error', 'Unable to create account: ' . $e->getMessage());

                return $this->redirectToRoute('auth_signup', ['mode' => $mode]);
            }
        }

        return $this->render('auth/form.html.twig', [
            'mode' => $mode,
            'authType' => 'signup',
            'title' => $mode === 'admin' ? 'Admin Sign Up' : 'User Sign Up',
            'submitLabel' => 'Sign Up',
        ]);
    }

    #[Route('/logout', name: 'auth_logout', methods: ['GET'])]
    public function logout(Request $request): RedirectResponse
    {
        $request->getSession()->clear();

        return $this->redirectToRoute('intro');
    }

    private function normalizeMode(string $mode): string
    {
        return strtolower($mode) === 'admin' ? 'admin' : 'user';
    }

    private function isAdminRole(string $roleName): bool
    {
        return str_contains(strtoupper($roleName), 'ADMIN');
    }
}