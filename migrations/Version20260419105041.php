<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260419105041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affectation_travail (id_affectation INT AUTO_INCREMENT NOT NULL, type_travail VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, zone_travail VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id_affectation)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, ear_tag INT DEFAULT NULL, type VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, health_status VARCHAR(255) DEFAULT NULL, birth_date DATE DEFAULT NULL, entry_date DATE DEFAULT NULL, origin VARCHAR(255) DEFAULT NULL, vaccinated INT DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE animalhealthrecord (id INT AUTO_INCREMENT NOT NULL, animal INT NOT NULL, record_date DATE NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, appetite VARCHAR(255) DEFAULT NULL, condition_status VARCHAR(255) DEFAULT NULL, milk_yield DOUBLE PRECISION DEFAULT NULL, egg_count INT DEFAULT NULL, wool_length DOUBLE PRECISION DEFAULT NULL, notes LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE culture (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type_culture VARCHAR(255) DEFAULT NULL, date_plantation DATE DEFAULT NULL, date_recolte DATE DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, surface DOUBLE PRECISION DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, parcelle_id INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE equipments (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, purchase_date DATE DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE evaluation_performance (id_evaluation INT AUTO_INCREMENT NOT NULL, note INT NOT NULL, qualite VARCHAR(255) DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, date_evaluation DATE DEFAULT NULL, id_affectation INT DEFAULT NULL, PRIMARY KEY (id_evaluation)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, equipment_id INT NOT NULL, maintenance_date DATE NOT NULL, maintenance_type VARCHAR(255) NOT NULL, cost NUMERIC(10, 2) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE parcelle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, surface DOUBLE PRECISION NOT NULL, localisation VARCHAR(255) DEFAULT NULL, type_sol VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, surface_restant INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE parcelle_historique (id INT AUTO_INCREMENT NOT NULL, parcelle_id INT NOT NULL, type_action VARCHAR(255) NOT NULL, culture_id INT DEFAULT NULL, culture_nom VARCHAR(255) NOT NULL, type_culture VARCHAR(255) DEFAULT NULL, surface DOUBLE PRECISION DEFAULT NULL, etat_avant VARCHAR(255) DEFAULT NULL, etat_apres VARCHAR(255) DEFAULT NULL, date_action DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, quantite_recolte DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE password_reset (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, code VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, used INT DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categorie VARCHAR(100) NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, prix_unitaire NUMERIC(10, 2) NOT NULL, photo_url VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, agriculteur_id INT NOT NULL, barcode_url LONGTEXT DEFAULT NULL, qr_code_url LONGTEXT DEFAULT NULL, sku VARCHAR(50) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, quantite_actuelle NUMERIC(10, 2) NOT NULL, seuil_alerte NUMERIC(10, 2) NOT NULL, unite_mesure VARCHAR(50) NOT NULL, date_reception DATE DEFAULT NULL, date_expiration DATE DEFAULT NULL, emplacement VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, produit_id INT NOT NULL, INDEX IDX_4B365660F347EFB (produit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone INT NOT NULL, roles VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, auth_provider VARCHAR(255) NOT NULL, google_id VARCHAR(255) DEFAULT NULL, profile_picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_faces (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, face_encoding LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_sessions (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, session_token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, ip_address VARCHAR(255) DEFAULT NULL, last_activity DATETIME NOT NULL, expires_at DATETIME NOT NULL, is_active INT DEFAULT NULL, device_info VARCHAR(255) DEFAULT NULL, user_id INT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660F347EFB');
        $this->addSql('DROP TABLE affectation_travail');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animalhealthrecord');
        $this->addSql('DROP TABLE culture');
        $this->addSql('DROP TABLE equipments');
        $this->addSql('DROP TABLE evaluation_performance');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE parcelle');
        $this->addSql('DROP TABLE parcelle_historique');
        $this->addSql('DROP TABLE password_reset');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_faces');
        $this->addSql('DROP TABLE user_sessions');
    }
}
