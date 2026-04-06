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
            $fieldErrors = $this->validateLoginInput($email, $password);

            if ($fieldErrors !== []) {
                return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'Please fix the highlighted fields.', $fieldErrors);
            }

            try {
                $user = $oracleCrud->findUserByEmail($email);
            } catch (\Throwable $e) {
                return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'Unable to access user database: ' . $e->getMessage(), []);
            }

            if (!$user || !password_verify($password, (string) ($user['passwordHash'] ?? ''))) {
                return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'Invalid credentials.', []);
            }

            if (strtolower((string) ($user['status'] ?? 'active')) !== 'active') {
                return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'Account is not active.', []);
            }

            $isAdmin = $this->isAdminRole((string) ($user['roleName'] ?? 'user'));
            if ($mode === 'admin' && !$isAdmin) {
                return $this->renderAuthForm($mode, 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'This account is not an admin account.', []);
            }

            if ($mode === 'user' && $isAdmin) {
                return $this->renderAuthForm('admin', 'login', 'Admin Login', 'User Login', 'Log In', [
                    'email' => $email,
                ], 'Use admin mode for this account.', []);
            }

            $session = $request->getSession();
            $session->set('auth_user_id', (int) $user['id']);
            $session->set('auth_role', $isAdmin ? 'admin' : 'user');
            $session->set('auth_user_name', trim((string) ($user['firstName'] . ' ' . $user['lastName'])));
            $session->set('auth_transition', true);

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
            $fieldErrors = $this->validateSignupInput($firstName, $lastName, $email, $password);

            if ($fieldErrors !== []) {
                return $this->renderAuthForm($mode, 'signup', 'Admin Sign Up', 'User Sign Up', 'Sign Up', [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                ], 'Please fix the highlighted fields.', $fieldErrors);
            }

            try {
                $existingUser = $oracleCrud->findUserByEmail($email);
                if ($existingUser) {
                    return $this->renderAuthForm($mode, 'signup', 'Admin Sign Up', 'User Sign Up', 'Sign Up', [
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'email' => $email,
                    ], 'Email already exists.', ['email' => 'Use a different email address.']);
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
                $session->set('auth_transition', true);

                return $this->redirectToRoute($isAdmin ? 'admin_home' : 'home');
            } catch (\Throwable $e) {
                return $this->renderAuthForm($mode, 'signup', 'Admin Sign Up', 'User Sign Up', 'Sign Up', [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                ], 'Unable to create account: ' . $e->getMessage(), []);
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
     * @param array<string, string> $fieldErrors
     */
    private function renderAuthForm(
        string $mode,
        string $authType,
        string $adminTitle,
        string $userTitle,
        string $submitLabel,
        array $formValues = [],
        ?string $errorMessage = null,
        array $fieldErrors = []
    ): Response {
        return $this->render('auth/form.html.twig', [
            'mode' => $mode,
            'authType' => $authType,
            'title' => $mode === 'admin' ? $adminTitle : $userTitle,
            'submitLabel' => $submitLabel,
            'formValues' => $formValues,
            'errorMessage' => $errorMessage,
            'fieldErrors' => $fieldErrors,
        ]);
    }

    /**
     * @return array<string, string>
     */
    private function validateLoginInput(string $email, string $password): array
    {
        $errors = [];

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Use a valid email format, for example name@example.com.';
        }

        if ($password === '') {
            $errors['password'] = 'Password is required.';
        }

        return $errors;
    }

    /**
     * @return array<string, string>
     */
    private function validateSignupInput(string $firstName, string $lastName, string $email, string $password): array
    {
        $errors = [];
        $namePattern = '/^[a-zA-Z][a-zA-Z\s\-\']{1,59}$/';

        if ($firstName === '' || !preg_match($namePattern, $firstName)) {
            $errors['first_name'] = 'First name must be 2-60 letters and may include spaces or hyphens.';
        }

        if ($lastName === '' || !preg_match($namePattern, $lastName)) {
            $errors['last_name'] = 'Last name must be 2-60 letters and may include spaces or hyphens.';
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 180) {
            $errors['email'] = 'Use a valid email under 180 characters.';
        }

        if (strlen($password) < 8 || strlen($password) > 72
            || !preg_match('/[A-Z]/', $password)
            || !preg_match('/[a-z]/', $password)
            || !preg_match('/\d/', $password)
            || !preg_match('/[^a-zA-Z\d]/', $password)
        ) {
            $errors['password'] = 'Password must be 8-72 chars with upper, lower, number, and symbol.';
        }

        return $errors;
    }
}