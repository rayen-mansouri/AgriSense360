<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260420203951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE farm DROP INDEX UNIQ_FARM_OWNER, ADD INDEX IDX_5816D0457E3C61F9 (owner_id)');
        $this->addSql('ALTER TABLE farm DROP FOREIGN KEY `FK_FARM_OWNER`');
        $this->addSql('ALTER TABLE farm ADD CONSTRAINT FK_5816D0457E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('DROP INDEX uniq_farm_id ON farm');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5816D04565FCFA0D ON farm (farm_id)');
        $this->addSql('ALTER TABLE user ADD farm_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE ai_suggested_role ai_suggested_role VARCHAR(255) DEFAULT NULL, CHANGE decision_reason decision_reason LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64965FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_8D93D64965FCFA0D ON user (farm_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE farm DROP INDEX IDX_5816D0457E3C61F9, ADD UNIQUE INDEX UNIQ_FARM_OWNER (owner_id)');
        $this->addSql('ALTER TABLE farm DROP FOREIGN KEY FK_5816D0457E3C61F9');
        $this->addSql('ALTER TABLE farm ADD CONSTRAINT `FK_FARM_OWNER` FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('DROP INDEX uniq_5816d04565fcfa0d ON farm');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FARM_ID ON farm (farm_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64965FCFA0D');
        $this->addSql('DROP INDEX IDX_8D93D64965FCFA0D ON user');
        $this->addSql('ALTER TABLE user DROP farm_id, CHANGE roles roles VARCHAR(255) NOT NULL, CHANGE ai_suggested_role ai_suggested_role VARCHAR(50) DEFAULT NULL, CHANGE decision_reason decision_reason TEXT DEFAULT NULL');
    }
}
