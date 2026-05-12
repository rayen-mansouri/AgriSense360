<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260505015654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE culture_weather_log (id INT AUTO_INCREMENT NOT NULL, culture_id INT NOT NULL, log_date DATE NOT NULL, temp_min DOUBLE PRECISION NOT NULL, temp_max DOUBLE PRECISION NOT NULL, temp_moy DOUBLE PRECISION NOT NULL, humidity INT NOT NULL, wind_kmh DOUBLE PRECISION NOT NULL, weather_id INT NOT NULL, description VARCHAR(150) DEFAULT NULL, rainfall DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX uniq_culture_date (culture_id, log_date), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE culture ADD quantite_recolte DOUBLE PRECISION DEFAULT NULL, ADD ia_score DOUBLE PRECISION DEFAULT NULL, CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE type_culture type_Culture VARCHAR(80) DEFAULT NULL, CHANGE etat etat VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE culture ADD CONSTRAINT FK_B6A99CEBD1B7C9C4 FOREIGN KEY (parcelle_Id) REFERENCES parcelle (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_B6A99CEBD1B7C9C4 ON culture (parcelle_Id)');
        $this->addSql('ALTER TABLE farm ADD CONSTRAINT FK_5816D0457E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE parcelle CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE localisation localisation VARCHAR(150) DEFAULT NULL, CHANGE type_sol type_sol VARCHAR(80) DEFAULT NULL, CHANGE statut statut VARCHAR(50) DEFAULT NULL, CHANGE surface_restant surface_restant DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE parcelle_historique CHANGE type_action type_action VARCHAR(50) NOT NULL, CHANGE culture_nom culture_nom VARCHAR(100) DEFAULT NULL, CHANGE type_culture type_culture VARCHAR(50) DEFAULT NULL, CHANGE etat_avant etat_avant VARCHAR(50) DEFAULT NULL, CHANGE etat_apres etat_apres VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE culture_weather_log');
        $this->addSql('ALTER TABLE culture DROP FOREIGN KEY FK_B6A99CEBD1B7C9C4');
        $this->addSql('DROP INDEX IDX_B6A99CEBD1B7C9C4 ON culture');
        $this->addSql('ALTER TABLE culture DROP quantite_recolte, DROP ia_score, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE type_Culture type_culture VARCHAR(255) DEFAULT NULL, CHANGE etat etat VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE farm DROP FOREIGN KEY FK_5816D0457E3C61F9');
        $this->addSql('ALTER TABLE parcelle CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE surface_restant surface_restant INT NOT NULL, CHANGE localisation localisation VARCHAR(255) DEFAULT NULL, CHANGE type_sol type_sol VARCHAR(255) DEFAULT NULL, CHANGE statut statut VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE parcelle_historique CHANGE type_action type_action VARCHAR(255) NOT NULL, CHANGE culture_nom culture_nom VARCHAR(255) NOT NULL, CHANGE type_culture type_culture VARCHAR(255) DEFAULT NULL, CHANGE etat_avant etat_avant VARCHAR(255) DEFAULT NULL, CHANGE etat_apres etat_apres VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
