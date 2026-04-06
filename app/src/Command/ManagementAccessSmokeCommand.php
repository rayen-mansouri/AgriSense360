<?php

namespace App\Command;

use App\Kernel;
use App\Service\AnimalManagementService;
use App\Service\OracleSqlPlusCrudService;
use App\Service\WorkerManagementService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

#[AsCommand(name: 'app:management-access-smoke', description: 'Validate management accessibility for user and admin sessions.')]
class ManagementAccessSmokeCommand extends Command
{
    public function __construct(
        private readonly Kernel $kernel,
        private readonly OracleSqlPlusCrudService $crud,
        private readonly AnimalManagementService $animalService,
        private readonly WorkerManagementService $workerService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stamp = (new \DateTimeImmutable())->format('YmdHis');
        $userEmail = 'smoke.user.' . $stamp . '@example.com';
        $adminEmail = 'smoke.admin.' . $stamp . '@example.com';

        $userId = 0;
        $adminId = 0;
        $results = [];

        try {
            $this->crud->createUser([
                'lastName' => 'SmokeUser',
                'firstName' => 'Access',
                'email' => $userEmail,
                'passwordHash' => password_hash('Strong!234', PASSWORD_BCRYPT),
                'status' => 'Active',
                'roleName' => 'USER',
            ]);
            $u = $this->crud->findUserByEmail($userEmail);
            if (!$u) {
                throw new \RuntimeException('Unable to create smoke user.');
            }
            $userId = (int) $u['id'];

            $this->crud->createUser([
                'lastName' => 'SmokeAdmin',
                'firstName' => 'Access',
                'email' => $adminEmail,
                'passwordHash' => password_hash('Strong!234', PASSWORD_BCRYPT),
                'status' => 'Active',
                'roleName' => 'ADMIN',
            ]);
            $a = $this->crud->findUserByEmail($adminEmail);
            if (!$a) {
                throw new \RuntimeException('Unable to create smoke admin.');
            }
            $adminId = (int) $a['id'];

            $userSession = new Session(new MockArraySessionStorage());
            $userSession->set('auth_user_id', $userId);
            $userSession->set('auth_role', 'USER');

            $userRoutes = [
                '/home',
                '/management/animals',
                '/management/equipments',
                '/management/stock',
                '/management/culture',
                '/management/workers',
                '/management/users',
            ];
            foreach ($userRoutes as $route) {
                $response = $this->requestWithSession('GET', $route, [], $userSession);
                $results[] = 'USER ' . $route . ' => ' . $response->getStatusCode();
                if ($response->getStatusCode() >= 400) {
                    throw new \RuntimeException('User route failed: ' . $route);
                }
            }

            // user write actions
            $response = $this->requestWithSession('POST', '/management/equipments', [
                'form_type' => 'equipment',
                'name' => 'SmokeEq-' . $stamp,
                'type' => 'Tractor',
                'status' => 'Ready',
                'purchase_date' => '2026-04-06',
            ], $userSession);
            $results[] = 'USER create equipment => ' . $response->getStatusCode();

            $response = $this->requestWithSession('POST', '/management/workers/save-worker', [
                'last_name' => 'Worker',
                'first_name' => 'One',
                'position' => 'Operator',
                'salary' => '1000',
                'availability' => 'Available',
            ], $userSession);
            $results[] = 'USER create worker => ' . $response->getStatusCode();

            $this->animalService->ensureSchema();
            $types = $this->animalService->getTypeOptions();
            $locations = $this->animalService->getLocationOptions();
            $type = $types[0] ?? 'cow';
            $location = $locations[0] ?? 'barn';

            $response = $this->requestWithSession('POST', '/management/animals/save', [
                'ear_tag' => '8101',
                'type' => $type,
                'weight' => '320',
                'birth_date' => '2024-01-01',
                'entry_date' => '2024-02-01',
                'origin' => 'BORN_IN_FARM',
                'vaccinated' => '1',
                'location' => $location,
            ], $userSession);
            $results[] = 'USER create animal => ' . $response->getStatusCode();

            $adminSession = new Session(new MockArraySessionStorage());
            $adminSession->set('auth_user_id', $adminId);
            $adminSession->set('auth_role', 'ADMIN');

            $adminRoutes = [
                '/admin/home',
                '/admin/management/animals',
                '/admin/management/equipments?user_id=' . $userId,
                '/admin/management/stock',
                '/admin/management/culture',
                '/admin/management/workers?user_id=' . $userId,
                '/admin/management/users',
                '/admin/profile',
            ];
            foreach ($adminRoutes as $route) {
                $response = $this->requestWithSession('GET', $route, [], $adminSession);
                $results[] = 'ADMIN ' . $route . ' => ' . $response->getStatusCode();
                if ($response->getStatusCode() >= 400) {
                    throw new \RuntimeException('Admin route failed: ' . $route);
                }
            }

            // admin write actions
            $response = $this->requestWithSession('POST', '/admin/management/workers/save-worker', [
                'user_id' => (string) $userId,
                'last_name' => 'AWorker',
                'first_name' => 'Two',
                'position' => 'Supervisor',
                'salary' => '1200',
                'availability' => 'Available',
            ], $adminSession);
            $results[] = 'ADMIN create worker => ' . $response->getStatusCode();

            $response = $this->requestWithSession('POST', '/admin/management/equipments?user_id=' . $userId, [
                'target_user_id' => (string) $userId,
                'form_type' => 'equipment',
                'name' => 'AdminEq-' . $stamp,
                'type' => 'Seeder',
                'status' => 'Ready',
                'purchase_date' => '2026-04-06',
            ], $adminSession);
            $results[] = 'ADMIN create equipment => ' . $response->getStatusCode();

            foreach ($results as $line) {
                $output->writeln($line);
            }

            $output->writeln('RESULT: PASS');
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            foreach ($results as $line) {
                $output->writeln($line);
            }
            $output->writeln('RESULT: FAIL - ' . $e->getMessage());
            return Command::FAILURE;
        } finally {
            if ($adminId > 0) {
                try {
                    $this->crud->deleteUser($adminId);
                } catch (\Throwable) {
                }
            }
            if ($userId > 0) {
                try {
                    $this->crud->deleteUser($userId);
                } catch (\Throwable) {
                }
            }
        }
    }

    private function requestWithSession(string $method, string $uri, array $data, Session $session): Response
    {
        $request = Request::create($uri, $method, $data);
        $request->setSession($session);
        $response = $this->kernel->handle($request);
        $this->kernel->terminate($request, $response);

        return $response;
    }
}
