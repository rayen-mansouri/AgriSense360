-- SQLite schema for AgriSense360
-- Create all tables and indexes

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    last_name TEXT NOT NULL,
    first_name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    status TEXT NOT NULL,
    role_name TEXT NOT NULL,
    created_at DATE DEFAULT CURRENT_DATE NOT NULL
);

-- Equipments table
CREATE TABLE IF NOT EXISTS equipments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    type TEXT NOT NULL,
    status TEXT NOT NULL,
    purchase_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Maintenance table
CREATE TABLE IF NOT EXISTS maintenance (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    equipment_id INTEGER NOT NULL,
    maintenance_date DATE NOT NULL,
    maintenance_type TEXT NOT NULL,
    cost REAL NOT NULL,
    FOREIGN KEY (equipment_id) REFERENCES equipments(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Affectation Travail table (task assignments)
CREATE TABLE IF NOT EXISTS affectation_travail (
    id_affectation INTEGER PRIMARY KEY AUTOINCREMENT,
    type_travail TEXT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    zone_travail TEXT NOT NULL,
    statut TEXT NOT NULL
);

-- Evaluation Performance table (performance ratings)
CREATE TABLE IF NOT EXISTS evaluation_performance (
    id_evaluation INTEGER PRIMARY KEY AUTOINCREMENT,
    id_affectation INTEGER NOT NULL,
    note INTEGER NOT NULL CHECK (note >= 0 AND note <= 20),
    qualite TEXT NOT NULL,
    commentaire TEXT NOT NULL,
    date_evaluation DATE NOT NULL,
    FOREIGN KEY (id_affectation) REFERENCES affectation_travail(id_affectation) ON DELETE CASCADE
);

-- Create indexes for common queries
CREATE INDEX IF NOT EXISTS idx_equipments_user_id ON equipments(user_id);
CREATE INDEX IF NOT EXISTS idx_maintenance_equipment_id ON maintenance(equipment_id);
CREATE INDEX IF NOT EXISTS idx_maintenance_user_id ON maintenance(user_id);
CREATE INDEX IF NOT EXISTS idx_affectation_date_debut ON affectation_travail(date_debut);
CREATE INDEX IF NOT EXISTS idx_affectation_statut ON affectation_travail(statut);
CREATE INDEX IF NOT EXISTS idx_evaluation_affectation ON evaluation_performance(id_affectation);

-- Insert test data
INSERT OR IGNORE INTO users (id, last_name, first_name, email, password_hash, status, role_name) VALUES
(1, 'Admin', 'Test', 'admin@test.com', '$2y$10$GxPvJKLqz7Hm8.I8jk5Q.eJ4rJ2z4V7zY5z5z5z5z5z5z5z5z5z5z', 'Active', 'ADMIN'),
(2, 'User', 'Test', 'user@test.com', '$2y$10$GxPvJKLqz7Hm8.I8jk5Q.eJ4rJ2z4V7zY5z5z5z5z5z5z5z5z5z5z', 'Active', 'USER');

-- Insert sample equipments
INSERT OR IGNORE INTO equipments (id, user_id, name, type, status, purchase_date) VALUES
(1, 2, 'Tractor A', 'Tractor', 'Ready', '2025-01-15'),
(2, 2, 'Irrigation System', 'Pump', 'Service', '2024-06-20');

-- Insert sample maintenance
INSERT OR IGNORE INTO maintenance (id, user_id, equipment_id, maintenance_date, maintenance_type, cost) VALUES
(1, 2, 1, '2026-03-01', 'Oil Change', 150.00),
(2, 2, 2, '2026-02-15', 'Filter Replacement', 75.50);

-- Insert sample affectations
INSERT OR IGNORE INTO affectation_travail (id_affectation, type_travail, date_debut, date_fin, zone_travail, statut) VALUES
(1, 'Récolte', '2026-04-01', '2026-04-15', 'Champ Nord', 'En attente'),
(2, 'Labour', '2026-03-15', '2026-03-25', 'Champ Est', 'En cours');

-- Insert sample evaluations
INSERT OR IGNORE INTO evaluation_performance (id_evaluation, id_affectation, note, qualite, commentaire, date_evaluation) VALUES
(1, 1, 18, 'Très bon', 'Travail de bonne qualité', '2026-04-16'),
(2, 2, 15, 'Bon', 'Travail acceptable mais quelques améliorations possibles', '2026-03-26');
