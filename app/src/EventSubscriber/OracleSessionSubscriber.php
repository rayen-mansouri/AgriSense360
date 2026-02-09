<?php

namespace App\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\DBAL\Event\ConnectionEventArgs;

#[AsDoctrineListener(event: 'postConnect')]
class OracleSessionSubscriber
{
    public function postConnect(ConnectionEventArgs $args): void
    {
        $connection = $args->getConnection();
        $sql = "ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS' NLS_TIMESTAMP_FORMAT = 'YYYY-MM-DD HH24:MI:SS'";
        $connection->executeStatement($sql);
    }
}
