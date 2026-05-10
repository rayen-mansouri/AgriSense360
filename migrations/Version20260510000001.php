<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260510000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add missing columns to user table';
    }

    public function up(Schema $schema): void
    {
        $columns = $this->connection->executeQuery(
            "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'user'"
        )->fetchFirstColumn();

        $alterParts = [];

        if (!in_array('reset_token', $columns)) {
            $alterParts[] = 'ADD COLUMN reset_token VARCHAR(255) DEFAULT NULL';
        }
        if (!in_array('reset_token_expires_at', $columns)) {
            $alterParts[] = 'ADD COLUMN reset_token_expires_at DATETIME DEFAULT NULL';
        }
        if (!in_array('first_login', $columns)) {
            $alterParts[] = 'ADD COLUMN first_login TINYINT(1) NOT NULL DEFAULT 1';
        }
        if (!in_array('created_at', $columns)) {
            $alterParts[] = 'ADD COLUMN created_at DATETIME DEFAULT NULL';
        }
        if (!in_array('updated_at', $columns)) {
            $alterParts[] = 'ADD COLUMN updated_at DATETIME DEFAULT NULL';
        }
        if (!in_array('farm_id', $columns)) {
            $alterParts[] = 'ADD COLUMN farm_id INT DEFAULT NULL';
        }
        if (!in_array('pending_notification', $columns)) {
            $alterParts[] = 'ADD COLUMN pending_notification LONGTEXT DEFAULT NULL';
        }

        if (!empty($alterParts)) {
            $this->addSql('ALTER TABLE `user` ' . implode(', ', $alterParts));
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP COLUMN IF EXISTS first_login, DROP COLUMN IF EXISTS created_at, DROP COLUMN IF EXISTS updated_at, DROP COLUMN IF EXISTS farm_id, DROP COLUMN IF EXISTS pending_notification');
    }
}
