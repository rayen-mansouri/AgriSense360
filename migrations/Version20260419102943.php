<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260419102943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD qr_code_url LONGTEXT DEFAULT NULL, DROP fournisseur, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE prix_unitaire prix_unitaire NUMERIC(10, 2) NOT NULL, CHANGE photo_url photo_url VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE barcode_url barcode_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE stock DROP INDEX uk_stock_produit, ADD INDEX IDX_4B365660F347EFB (produit_id)');
        $this->addSql('DROP INDEX idx_stock_alerte ON stock');
        $this->addSql('DROP INDEX idx_stock_quantite ON stock');
        $this->addSql('ALTER TABLE stock CHANGE quantite_actuelle quantite_actuelle NUMERIC(10, 2) NOT NULL, CHANGE unite_mesure unite_mesure VARCHAR(50) NOT NULL, CHANGE emplacement emplacement VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(255) NOT NULL, CHANGE status status VARCHAR(255) NOT NULL, CHANGE auth_provider auth_provider VARCHAR(255) NOT NULL, CHANGE profile_picture profile_picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX user_id ON user_faces');
        $this->addSql('ALTER TABLE user_faces CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user_sessions DROP FOREIGN KEY `fk_user_sessions_user`');
        $this->addSql('DROP INDEX user_id ON user_sessions');
        $this->addSql('DROP INDEX user_id_2 ON user_sessions');
        $this->addSql('DROP INDEX user_id_3 ON user_sessions');
        $this->addSql('DROP INDEX user_id_4 ON user_sessions');
        $this->addSql('ALTER TABLE user_sessions ADD id INT AUTO_INCREMENT NOT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE ip_address ip_address VARCHAR(255) DEFAULT NULL, CHANGE last_activity last_activity DATETIME NOT NULL, CHANGE expires_at expires_at DATETIME NOT NULL, CHANGE is_active is_active INT DEFAULT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD fournisseur VARCHAR(150) DEFAULT NULL, DROP qr_code_url, CHANGE nom nom VARCHAR(150) NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE prix_unitaire prix_unitaire NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, CHANGE photo_url photo_url VARCHAR(500) NOT NULL, CHANGE barcode_url barcode_url VARCHAR(500) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE stock DROP INDEX IDX_4B365660F347EFB, ADD UNIQUE INDEX uk_stock_produit (produit_id)');
        $this->addSql('ALTER TABLE stock CHANGE quantite_actuelle quantite_actuelle NUMERIC(12, 3) DEFAULT \'0.000\' NOT NULL, CHANGE unite_mesure unite_mesure VARCHAR(30) NOT NULL, CHANGE emplacement emplacement VARCHAR(150) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('CREATE INDEX idx_stock_alerte ON stock (seuil_alerte)');
        $this->addSql('CREATE INDEX idx_stock_quantite ON stock (quantite_actuelle)');
        $this->addSql('ALTER TABLE user CHANGE roles roles ENUM(\'ROLE_GERANT\', \'ROLE_OUVRIER\', \'ROLE_ADMIN\') NOT NULL, CHANGE status status VARCHAR(20) DEFAULT \'ACTIVE\' NOT NULL, CHANGE auth_provider auth_provider VARCHAR(20) DEFAULT \'LOCAL\' NOT NULL, CHANGE profile_picture profile_picture VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_faces CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('CREATE INDEX user_id ON user_faces (user_id)');
        $this->addSql('ALTER TABLE user_sessions MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE user_sessions DROP id, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE ip_address ip_address VARCHAR(45) DEFAULT NULL, CHANGE last_activity last_activity DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE expires_at expires_at DATETIME DEFAULT \'(now() + interval 7 day)\' NOT NULL, CHANGE is_active is_active TINYINT DEFAULT 1, CHANGE user_id user_id INT NOT NULL, DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_sessions ADD CONSTRAINT `fk_user_sessions_user` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX user_id ON user_sessions (user_id)');
        $this->addSql('CREATE INDEX user_id_2 ON user_sessions (user_id)');
        $this->addSql('CREATE INDEX user_id_3 ON user_sessions (user_id)');
        $this->addSql('CREATE INDEX user_id_4 ON user_sessions (user_id)');
    }
}
