-- SQLite Database Schema for AgriSense 360
-- Created for gestion-ouvrier and equipment-management features

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    last_name TEXT NOT NULL,
    first_name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    status TEXT DEFAULT 'active',
    role_name TEXT DEFAULT 'user',
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

-- Equipments Table
CREATE TABLE IF NOT EXISTS equipments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    type TEXT NOT NULL,
    status TEXT DEFAULT 'Ready',
    purchase_date TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

-- Maintenance Table
CREATE TABLE IF NOT EXISTS maintenance (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    equipment_id INTEGER NOT NULL,
    maintenance_date TEXT NOT NULL,
    maintenance_type TEXT NOT NULL,
    cost REAL DEFAULT 0,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(equipment_id) REFERENCES equipments(id)
);

-- Affectation Travail (Worker Task Assignments)
CREATE TABLE IF NOT EXISTS affectation_travail (
    id_affectation INTEGER PRIMARY KEY AUTOINCREMENT,
    type_travail TEXT NOT NULL,
    date_debut TEXT NOT NULL,
    date_fin TEXT NOT NULL,
    zone_travail TEXT NOT NULL,
    statut TEXT DEFAULT 'En cours',
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

-- Evaluation Performance (Worker Performance Evaluations)
CREATE TABLE IF NOT EXISTS evaluation_performance (
    id_evaluation INTEGER PRIMARY KEY AUTOINCREMENT,
    affectation_id INTEGER NOT NULL,
    note REAL NOT NULL CHECK(note >= 0 AND note <= 20),
    qualite TEXT NOT NULL,
    commentaire TEXT NOT NULL,
    date_evaluation TEXT NOT NULL,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(affectation_id) REFERENCES affectation_travail(id_affectation)
);

-- Create Indexes for performance
CREATE INDEX IF NOT EXISTS idx_equipments_user_id ON equipments(user_id);
CREATE INDEX IF NOT EXISTS idx_maintenance_user_id ON maintenance(user_id);
CREATE INDEX IF NOT EXISTS idx_maintenance_equipment_id ON maintenance(equipment_id);
CREATE INDEX IF NOT EXISTS idx_affectation_date ON affectation_travail(date_debut, date_fin);
CREATE INDEX IF NOT EXISTS idx_evaluation_affectation_id ON evaluation_performance(affectation_id);
CREATE INDEX IF NOT EXISTS idx_users_email ON users(LOWER(email));

-- Insert Test Data
INSERT INTO users (last_name, first_name, email, password_hash, status, role_name) VALUES
('User', 'Test', 'user@test.com', '$2y$13$8pITMfLBMCpd2ioEe3QLCu.TJ9O5gVv1k/XLTDzEZBoX9b0tJxHpC', 'active', 'user'),
('Admin', 'Test', 'admin@test.com', '$2y$13$8pITMfLBMCpd2ioEe3QLCu.TJ9O5gVv1k/XLTDzEZBoX9b0tJxHpC', 'active', 'admin');

INSERT INTO equipments (user_id, name, type, status, purchase_date) VALUES
(1, 'Tractor A', 'Heavy Machinery', 'Ready', '2023-01-15'),
(1, 'Water Pump', 'Irrigation', 'Service', '2023-06-20');

INSERT INTO maintenance (user_id, equipment_id, maintenance_date, maintenance_type, cost) VALUES
(1, 1, '2026-01-10', 'Oil Change', 150.00),
(1, 2, '2026-02-15', 'Filter Replacement', 75.50);

INSERT INTO affectation_travail (type_travail, date_debut, date_fin, zone_travail, statut) VALUES
('Labourage', '2026-04-01', '2026-04-05', 'Champ Nord', 'Terminée'),
('Irrigation', '2026-04-06', '2026-04-10', 'Champ Sud', 'En cours');

INSERT INTO evaluation_performance (affectation_id, note, qualite, commentaire, date_evaluation) VALUES
(1, 18, 'Excellent', 'Travail très satisfaisant et efficace', '2026-04-05'),
(2, 16.5, 'Bon', 'Bonne performance avec quelques améliorations', '2026-04-06');
