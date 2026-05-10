<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260420200000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add cv/ai columns to user if missing, create farm table';
    }

    public function up(Schema $schema): void
    {
        // Check and add missing user columns dynamically
        $columns = $this->connection->executeQuery(
            "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'user'"
        )->fetchFirstColumn();

        $alterParts = [];

        if (!in_array('cv_file', $columns)) {
            $alterParts[] = 'ADD COLUMN cv_file VARCHAR(255) DEFAULT NULL';
        }
        if (!in_array('ai_suggested_role', $columns)) {
            $alterParts[] = 'ADD COLUMN ai_suggested_role VARCHAR(255) DEFAULT NULL';
        }
        if (!in_array('decision_reason', $columns)) {
            $alterParts[] = 'ADD COLUMN decision_reason TEXT DEFAULT NULL';
        }
        if (!in_array('approved_by', $columns)) {
            $alterParts[] = 'ADD COLUMN approved_by INT DEFAULT NULL';
        }
        if (!in_array('auth_provider', $columns)) {
            $alterParts[] = 'ADD COLUMN auth_provider VARCHAR(50) DEFAULT NULL';
        }
        if (!in_array('google_id', $columns)) {
            $alterParts[] = 'ADD COLUMN google_id VARCHAR(255) DEFAULT NULL';
        }
        if (!in_array('profile_picture', $columns)) {
            $alterParts[] = 'ADD COLUMN profile_picture VARCHAR(255) DEFAULT NULL';
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

        if (!empty($alterParts)) {
            $this->addSql('ALTER TABLE `user` ' . implode(', ', $alterParts));
        }

        // Create farm table (only if not exists)
        $tables = $this->connection->executeQuery(
            "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'farm'"
        )->fetchFirstColumn();

        if (empty($tables)) {
            $this->addSql("CREATE TABLE farm (
                id INT AUTO_INCREMENT NOT NULL,
                farm_id VARCHAR(20) NOT NULL,
                name VARCHAR(255) NOT NULL,
                location VARCHAR(255) DEFAULT NULL,
                surface DOUBLE PRECISION DEFAULT NULL,
                owner_id INT DEFAULT NULL,
                created_at DATETIME DEFAULT NULL,
                UNIQUE INDEX UNIQ_FARM_ID (farm_id),
                UNIQUE INDEX UNIQ_FARM_OWNER (owner_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 ENGINE=InnoDB");

            $this->addSql('ALTER TABLE farm ADD CONSTRAINT FK_FARM_OWNER FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE farm DROP FOREIGN KEY FK_FARM_OWNER');
        $this->addSql('DROP TABLE IF EXISTS farm');
    }
}
