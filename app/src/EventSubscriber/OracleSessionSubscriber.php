<?php

namespace App\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;

#[AsDoctrineListener(event: 'postConnect')]
class OracleSessionSubscriber
{
    public function postConnect(object $args): void
    {
        if (!method_exists($args, 'getConnection')) {
            return;
        }

        $connection = $args->getConnection();

        if ($connection->getDatabasePlatform()->getName() !== 'oracle') {
            return;
        }

        $sql = "ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS' NLS_TIMESTAMP_FORMAT = 'YYYY-MM-DD HH24:MI:SS'";
        $connection->executeStatement($sql);
    }
}
