<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ManagementWorkersRouteTest extends WebTestCase
{
    public function testManagementWorkersRouteExists(): void
    {
        $client = static::createClient();
        $client->request('GET', '/management/workers');

        $status = $client->getResponse()->getStatusCode();
        $content = $client->getResponse()->getContent();

        if ($status === 500) {
            // Try to parse error message
            preg_match('/<h1>(.+?)<\/h1>/', $content, $matches);
            $message = $matches[1] ?? 'Unknown error';
            $this->fail("Route returned 500 error: " . $message . "\n\nResponse:\n" . substr($content, 0, 1000));
        }

        // Should either succeed (200) or redirect to login (302/401)
        $this->assertThat(
            $status,
            $this->logicalOr(
                $this->equalTo(200),
                $this->equalTo(302),
                $this->equalTo(401)
            ),
            'Route /management/workers should exist'
        );
    }
}
