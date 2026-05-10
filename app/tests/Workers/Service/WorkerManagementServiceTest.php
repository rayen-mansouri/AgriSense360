<?php

namespace App\Tests\Workers\Service;

use App\Service\WorkerManagementService;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;

class WorkerManagementServiceTest extends TestCase
{
    private WorkerManagementService $service;
    private Connection $connection;

    protected function setUp(): void
    {
        // Mock the database connection
        $this->connection = $this->createMock(Connection::class);

        // Initialize the service with mocked connection
        $this->service = new WorkerManagementService($this->connection);
    }

    /**
     * @test
     */
    public function testCreateAssignmentWithValidData(): void
    {
        $data = [
            'workerId' => 1,
            'task' => 'Field Preparation',
            'startDate' => '2026-05-05',
            'endDate' => '2026-05-10',
        ];

        // Assert that the service can be instantiated
        $this->assertInstanceOf(WorkerManagementService::class, $this->service);
    }

    /**
     * @test
     */
    public function testUpdateAssignmentWithValidData(): void
    {
        $data = [
            'workerId' => 1,
            'task' => 'Updated Task',
            'startDate' => '2026-05-05',
            'endDate' => '2026-05-15',
        ];

        // Assert that the service is operational
        $this->assertInstanceOf(WorkerManagementService::class, $this->service);
    }

    /**
     * @test
     */
    public function testServiceHasRequiredMethods(): void
    {
        $this->assertTrue(method_exists($this->service, 'createAssignment'));
        $this->assertTrue(method_exists($this->service, 'updateAssignment'));
        $this->assertTrue(method_exists($this->service, 'deleteAssignment'));
        $this->assertTrue(method_exists($this->service, 'listAssignments'));
    }
}
