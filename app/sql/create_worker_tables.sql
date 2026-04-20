-- Create Worker/Affectation/Evaluation tables for Oracle
-- This script complements create_equipment_tables.sql
-- Run this after the equipment tables are created

-- AFFECTATION_TRAVAIL table (task assignments for workers)
CREATE TABLE AFFECTATION_TRAVAIL (
    ID_AFFECTATION NUMBER(10) PRIMARY KEY,
    TYPE_TRAVAIL VARCHAR2(100) NOT NULL,      -- Min 2, Max 100 chars (Récolte, Labour, Plantage, etc.)
    DATE_DEBUT DATE NOT NULL,
    DATE_FIN DATE NOT NULL,                    -- Must be >= DATE_DEBUT
    ZONE_TRAVAIL VARCHAR2(100) NOT NULL,      -- Max 100 chars (Champ Nord, Verger Est, etc.)
    STATUT VARCHAR2(50) NOT NULL,             -- Values: En attente, En cours, Complété, Suspendu, Annulé
    CREATED_AT DATE DEFAULT SYSDATE NOT NULL
);

-- EVALUATION_PERFORMANCE table (performance ratings for completed affectations)
CREATE TABLE EVALUATION_PERFORMANCE (
    ID_EVALUATION NUMBER(10) PRIMARY KEY,
    ID_AFFECTATION NUMBER(10) NOT NULL,
    NOTE NUMBER(2) NOT NULL CHECK (NOTE >= 0 AND NOTE <= 20),  -- Integer 0-20
    QUALITE VARCHAR2(50) NOT NULL,            -- Values: Excellent, Très bon, Bon, Acceptable, Insuffisant
    COMMENTAIRE VARCHAR2(500) NOT NULL,       -- Max 500 chars
    DATE_EVALUATION DATE NOT NULL,            -- Cannot be in future (validated in controller)
    CREATED_AT DATE DEFAULT SYSDATE NOT NULL,
    FOREIGN KEY (ID_AFFECTATION) REFERENCES AFFECTATION_TRAVAIL(ID_AFFECTATION) ON DELETE CASCADE
);

-- Create sequences for auto-increment behavior
CREATE SEQUENCE AFFECTATION_TRAVAIL_SEQ
    START WITH 1
    INCREMENT BY 1
    NOCYCLE;

CREATE SEQUENCE EVALUATION_PERFORMANCE_SEQ
    START WITH 1
    INCREMENT BY 1
    NOCYCLE;

-- Create indexes for common queries
CREATE INDEX IDX_AFFECTATION_DATE_DEBUT ON AFFECTATION_TRAVAIL(DATE_DEBUT);
CREATE INDEX IDX_AFFECTATION_STATUT ON AFFECTATION_TRAVAIL(STATUT);
CREATE INDEX IDX_EVALUATION_AFFECTATION ON EVALUATION_PERFORMANCE(ID_AFFECTATION);

-- Add synonyms for easier reference (optional)
-- CREATE SYNONYM AFFECTATION FOR AFFECTATION_TRAVAIL;
-- CREATE SYNONYM EVALUATION FOR EVALUATION_PERFORMANCE;

COMMIT;
