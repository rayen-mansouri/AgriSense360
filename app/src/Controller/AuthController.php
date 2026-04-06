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
                return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'Email and password are required.');
            }

            try {
                $user = $oracleCrud->findUserByEmail($email);
            } catch (\Throwable $e) {
                return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'Unable to access user database: ' . $e->getMessage());
            }

            if (!$user || !password_verify($password, (string) ($user['passwordHash'] ?? ''))) {
                return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'Invalid credentials.');
            }

            if (strtolower((string) ($user['status'] ?? 'active')) !== 'active') {
                return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'Account is not active.');
            }

            $isAdmin = $this->isAdminRole((string) ($user['roleName'] ?? 'user'));
            if ($mode === 'admin' && !$isAdmin) {
                return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'This account is not an admin account.');
            }

            if ($mode === 'user' && $isAdmin) {
                return $this->renderAuthForm('admin', 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'Use admin mode for this account.');
            }

            $session = $request->getSession();
            $session->set('auth_user_id', (int) $user['id']);
            $session->set('auth_role', $isAdmin ? 'admin' : 'user');
            $session->set('auth_user_name', trim((string) ($user['firstName'] . ' ' . $user['lastName'])));

            return $this->redirectToRoute($isAdmin ? 'admin_home' : 'home');
        }

        return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In');
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
                return $this->renderAuthForm($mode, 'signup', 'Admin Sign Up', 'User Sign Up', 'Sign Up', [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                ], 'All fields are required.');
            }

            try {
                $existingUser = $oracleCrud->findUserByEmail($email);
                if ($existingUser) {
                    return $this->renderAuthForm($mode, 'signup', 'Admin Sign Up', 'User Sign Up', 'Sign Up', [
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'email' => $email,
                    ], 'Email already exists.');
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
                return $this->renderAuthForm($mode, 'signup', 'Admin Sign Up', 'User Sign Up', 'Sign Up', [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                ], 'Unable to create account: ' . $e->getMessage());
            }
        }

        return $this->renderAuthForm($mode, 'signup', 'Admin Sign Up', 'User Sign Up', 'Sign Up');
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

    /**
     * @param array{firstName?:string,lastName?:string,email?:string} $formValues
     */
    private function renderAuthForm(
        string $mode,
        string $authType,
        string $adminTitle,
        string $userTitle,
        string $submitLabel,
        array $formValues = [],
        ?string $errorMessage = null
    ): Response {
        return $this->render('auth/form.html.twig', [
            'mode' => $mode,
            'authType' => $authType,
            'title' => $mode === 'admin' ? $adminTitle : $userTitle,
            'submitLabel' => $submitLabel,
            'formValues' => $formValues,
            'errorMessage' => $errorMessage,
        ]);
    }
}