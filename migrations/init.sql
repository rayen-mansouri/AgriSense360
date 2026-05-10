-- ============================================================
-- Agrisens 360 — Création des tables (MySQL/MariaDB)
-- Exécuter APRÈS avoir créé la base de données
-- ============================================================

CREATE TABLE IF NOT EXISTS `produit` (
    `id`              INT           NOT NULL AUTO_INCREMENT,
    `agriculteur_id`  INT           NOT NULL DEFAULT 1,
    `categorie`       VARCHAR(100)  NOT NULL,
    `nom`             VARCHAR(255)  NOT NULL,
    `description`     LONGTEXT      DEFAULT NULL,
    `prix_unitaire`   DECIMAL(10,2) NOT NULL,
    `photo_url`       VARCHAR(500)  DEFAULT NULL,
    `barcode_url`     VARCHAR(500)  DEFAULT NULL,
    `created_at`      DATETIME      NOT NULL,
    `updated_at`      DATETIME      NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `stock` (
    `id`                INT           NOT NULL AUTO_INCREMENT,
    `produit_id`        INT           NOT NULL,
    `quantite_actuelle` DECIMAL(10,2) NOT NULL,
    `seuil_alerte`      DECIMAL(10,2) DEFAULT NULL,
    `unite_mesure`      VARCHAR(50)   NOT NULL,
    `date_reception`    DATE          DEFAULT NULL,
    `date_expiration`   DATE          DEFAULT NULL,
    `emplacement`       VARCHAR(255)  DEFAULT NULL,
    `created_at`        DATETIME      NOT NULL,
    `updated_at`        DATETIME      NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_stock_produit`
        FOREIGN KEY (`produit_id`) REFERENCES `produit`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données de démonstration
INSERT INTO `produit` (`agriculteur_id`,`categorie`,`nom`,`description`,`prix_unitaire`,`created_at`,`updated_at`) VALUES
(1,'Engrais','Engrais NPK 15-15-15','Engrais complet équilibré pour toutes cultures.',125.50,NOW(),NOW()),
(1,'Semences','Semences Blé Dur Karim','Variété certifiée haute rendement, résistante à la sécheresse.',45.00,NOW(),NOW()),
(1,'Pesticides','Fongicide Mancozèbe 80%','Protection contre les maladies fongiques.',89.00,NOW(),NOW()),
(1,'Irrigation','Tuyau goutte-à-goutte 16mm','Système d''irrigation économique, débit 1.6 L/h.',12.50,NOW(),NOW()),
(1,'Engrais','Urée 46% N','Engrais azoté haute concentration.',78.00,NOW(),NOW());

INSERT INTO `stock` (`produit_id`,`quantite_actuelle`,`seuil_alerte`,`unite_mesure`,`date_reception`,`date_expiration`,`emplacement`,`created_at`,`updated_at`) VALUES
(1,350.00,50.00,'kg','2025-01-10','2026-12-31','Entrepôt A - Rayon 1',NOW(),NOW()),
(2,15.00,20.00,'sac','2025-02-01','2025-08-31','Entrepôt B - Rayon 2',NOW(),NOW()),
(3,8.00,10.00,'kg','2025-01-20','2026-06-30','Entrepôt A - Rayon 3',NOW(),NOW()),
(4,500.00,100.00,'u','2025-03-01',NULL,'Hangar Extérieur',NOW(),NOW()),
(5,0.00,30.00,'sac','2024-12-15','2026-03-31','Entrepôt C - Rayon 1',NOW(),NOW());
