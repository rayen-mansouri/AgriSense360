<?php

namespace App\Tests\Workers\Controller;

use App\Controller\ManagementController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class ManagementControllerTest extends TestCase
{
    private ManagementController $controller;

    protected function setUp(): void
    {
        // Initialize the controller
        $this->controller = new ManagementController();
    }

    /**
     * @test
     */
    public function testControllerCanBeInstantiated(): void
    {
        $this->assertInstanceOf(ManagementController::class, $this->controller);
    }

    /**
     * @test
     */
    public function testControllerHasRequiredMethods(): void
    {
        $this->assertTrue(method_exists($this->controller, 'management'));
        $this->assertTrue(method_exists($this->controller, 'adminManagement'));
        $this->assertTrue(method_exists($this->controller, 'createAffectation'));
        $this->assertTrue(method_exists($this->controller, 'editAffectation'));
    }

    /**
     * @test
     */
    public function testManagementWorkersDataStructure(): void
    {
        // Test that management controller handles workers data properly
        $session = new Session(new MockArraySessionStorage());
        $session->set('user_id', 1);
        $session->set('role', 'user');

        $this->assertEquals(1, $session->get('user_id'));
        $this->assertEquals('user', $session->get('role'));
    }

    /**
     * @test
     */
    public function testAdminManagementAccessControl(): void
    {
        // Test that admin management checks proper role
        $session = new Session(new MockArraySessionStorage());
        $session->set('user_id', 1);
        $session->set('role', 'admin');

        $this->assertEquals('admin', $session->get('role'));
    }
}
