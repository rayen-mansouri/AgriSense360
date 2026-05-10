<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class AnimalManagementService
{
    private bool $schemaInitialized = false;

    public function __construct(private readonly Connection $connection)
    {
    }

    public function ensureSchema(): void
    {
        if ($this->schemaInitialized) {
            return;
        }

        $platform = strtolower(get_class($this->connection->getDatabasePlatform()));

        if (str_contains($platform, 'sqlite')) {
            $this->connection->executeStatement('PRAGMA foreign_keys = ON');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS ANIMAL_TYPE_OPTIONS (
                value TEXT PRIMARY KEY
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS ANIMAL_LOCATION_OPTIONS (
                value TEXT PRIMARY KEY
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS ANIMALS (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                ear_tag INTEGER NOT NULL,
                type TEXT NOT NULL,
                weight REAL DEFAULT NULL,
                health_status TEXT DEFAULT NULL,
                birth_date TEXT DEFAULT NULL,
                entry_date TEXT DEFAULT NULL,
                origin TEXT DEFAULT NULL,
                vaccinated INTEGER NOT NULL DEFAULT 0,
                location TEXT DEFAULT NULL,
                FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS ANIMAL_HEALTH_RECORDS (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                animal_id INTEGER NOT NULL,
                record_date TEXT DEFAULT NULL,
                weight REAL DEFAULT NULL,
                appetite TEXT DEFAULT NULL,
                condition_status TEXT DEFAULT NULL,
                milk_yield REAL DEFAULT NULL,
                egg_count INTEGER DEFAULT NULL,
                wool_length REAL DEFAULT NULL,
                notes TEXT DEFAULT NULL,
                FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE,
                FOREIGN KEY (animal_id) REFERENCES ANIMALS(id) ON DELETE CASCADE
            )');

            $this->seedDefaultOptions();
            $this->schemaInitialized = true;

            return;
        }

        if (str_contains($platform, 'mysql')) {
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS ANIMAL_TYPE_OPTIONS (
                value VARCHAR(80) NOT NULL PRIMARY KEY
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS ANIMAL_LOCATION_OPTIONS (
                value VARCHAR(80) NOT NULL PRIMARY KEY
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS ANIMALS (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                ear_tag INT NOT NULL,
                type VARCHAR(80) NOT NULL,
                weight DECIMAL(10, 2) NULL,
                health_status VARCHAR(80) NULL,
                birth_date DATE NULL,
                entry_date DATE NULL,
                origin VARCHAR(80) NULL,
                vaccinated TINYINT(1) NOT NULL DEFAULT 0,
                location VARCHAR(120) NULL,
                CONSTRAINT fk_animals_user FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS ANIMAL_HEALTH_RECORDS (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                animal_id INT NOT NULL,
                record_date DATE NULL,
                weight DECIMAL(10, 2) NULL,
                appetite VARCHAR(80) NULL,
                condition_status VARCHAR(80) NULL,
                milk_yield DECIMAL(10, 2) NULL,
                egg_count INT NULL,
                wool_length DECIMAL(10, 2) NULL,
                notes TEXT NULL,
                CONSTRAINT fk_animal_records_user FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE,
                CONSTRAINT fk_animal_records_animal FOREIGN KEY (animal_id) REFERENCES ANIMALS(id) ON DELETE CASCADE
            )');

            $this->seedDefaultOptions();
            $this->schemaInitialized = true;

            return;
        }

        if (str_contains($platform, 'oracle')) {
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE SEQUENCE ANIMAL_SEQ START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 AND SQLCODE != -2289 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE SEQUENCE ANIMAL_RECORD_SEQ START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 AND SQLCODE != -2289 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE TABLE ANIMAL_TYPE_OPTIONS (
        VALUE VARCHAR2(80) NOT NULL,
        CONSTRAINT PK_ANIMAL_TYPE_OPTIONS PRIMARY KEY (VALUE)
    )';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE TABLE ANIMAL_LOCATION_OPTIONS (
        VALUE VARCHAR2(80) NOT NULL,
        CONSTRAINT PK_ANIMAL_LOCATION_OPTIONS PRIMARY KEY (VALUE)
    )';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE TABLE ANIMALS (
        ID NUMBER(10) NOT NULL,
        USER_ID NUMBER(10) NOT NULL,
        EAR_TAG NUMBER(10) NOT NULL,
        TYPE VARCHAR2(80) NOT NULL,
        WEIGHT NUMBER(10, 2),
        HEALTH_STATUS VARCHAR2(80),
        BIRTH_DATE DATE,
        ENTRY_DATE DATE,
        ORIGIN VARCHAR2(80),
        VACCINATED NUMBER(1) DEFAULT 0 NOT NULL,
        LOCATION VARCHAR2(120),
        CONSTRAINT PK_ANIMALS PRIMARY KEY (ID),
        CONSTRAINT FK_ANIMALS_USER FOREIGN KEY (USER_ID) REFERENCES USERS(ID) ON DELETE CASCADE
    )';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE TABLE ANIMAL_HEALTH_RECORDS (
        ID NUMBER(10) NOT NULL,
        USER_ID NUMBER(10) NOT NULL,
        ANIMAL_ID NUMBER(10) NOT NULL,
        RECORD_DATE DATE,
        WEIGHT NUMBER(10, 2),
        APPETITE VARCHAR2(80),
        CONDITION_STATUS VARCHAR2(80),
        MILK_YIELD NUMBER(10, 2),
        EGG_COUNT NUMBER(10),
        WOOL_LENGTH NUMBER(10, 2),
        NOTES CLOB,
        CONSTRAINT PK_ANIMAL_HEALTH_RECORDS PRIMARY KEY (ID),
        CONSTRAINT FK_ANIMAL_RECORDS_USER FOREIGN KEY (USER_ID) REFERENCES USERS(ID) ON DELETE CASCADE,
        CONSTRAINT FK_ANIMAL_RECORDS_ANIMAL FOREIGN KEY (ANIMAL_ID) REFERENCES ANIMALS(ID) ON DELETE CASCADE
    )';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 THEN
            RAISE;
        END IF;
END;
SQL);

            $this->seedDefaultOptions();
            $this->schemaInitialized = true;

            return;
        }

        throw new \RuntimeException('Unsupported database platform: ' . $platform);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listAnimals(?int $ownerUserId = null): array
    {
        $this->ensureSchema();

        $sql = 'SELECT id, user_id, ear_tag, type, weight, health_status, birth_date, entry_date, origin, vaccinated, location FROM ANIMALS';
        $params = [];
        if ($ownerUserId !== null) {
            $sql .= ' WHERE user_id = :ownerUserId';
            $params['ownerUserId'] = $ownerUserId;
        }
        $sql .= ' ORDER BY id DESC';

        $rows = $this->connection->fetchAllAssociative($sql, $params);

        return array_map(function (array $row): array {
            $birthDate = $this->toDateTime($row['birth_date'] ?? null);

            return [
                'id' => (int) ($row['id'] ?? 0),
                'userId' => (int) ($row['user_id'] ?? 0),
                'earTag' => (int) ($row['ear_tag'] ?? 0),
                'type' => (string) ($row['type'] ?? ''),
                'weight' => $row['weight'] !== null && $row['weight'] !== '' ? (float) $row['weight'] : null,
                'healthStatus' => (string) ($row['health_status'] ?? ''),
                'birthDate' => $birthDate,
                'entryDate' => $this->toDateTime($row['entry_date'] ?? null),
                'origin' => (string) ($row['origin'] ?? ''),
                'vaccinated' => (bool) (int) ($row['vaccinated'] ?? 0),
                'location' => (string) ($row['location'] ?? ''),
                'age' => $birthDate instanceof \DateTimeInterface ? (int) $birthDate->diff(new \DateTimeImmutable('today'))->y : null,
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findAnimal(int $id, ?int $ownerUserId = null): ?array
    {
        $this->ensureSchema();

        $sql = 'SELECT id, user_id, ear_tag, type, weight, health_status, birth_date, entry_date, origin, vaccinated, location FROM ANIMALS WHERE id = :id';
        $params = ['id' => $id];
        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = :ownerUserId';
            $params['ownerUserId'] = $ownerUserId;
        }

        $rows = $this->connection->fetchAllAssociative($sql, $params);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];
        $birthDate = $this->toDateTime($row['birth_date'] ?? null);

        return [
            'id' => (int) ($row['id'] ?? 0),
            'userId' => (int) ($row['user_id'] ?? 0),
            'earTag' => (int) ($row['ear_tag'] ?? 0),
            'type' => (string) ($row['type'] ?? ''),
            'weight' => $row['weight'] !== null && $row['weight'] !== '' ? (float) $row['weight'] : null,
            'healthStatus' => (string) ($row['health_status'] ?? ''),
            'birthDate' => $birthDate,
            'entryDate' => $this->toDateTime($row['entry_date'] ?? null),
            'origin' => (string) ($row['origin'] ?? ''),
            'vaccinated' => (bool) (int) ($row['vaccinated'] ?? 0),
            'location' => (string) ($row['location'] ?? ''),
            'age' => $birthDate instanceof \DateTimeInterface ? (int) $birthDate->diff(new \DateTimeImmutable('today'))->y : null,
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    public function createAnimal(array $data, int $ownerUserId): int
    {
        $this->ensureSchema();

        $payload = [
            'user_id' => $ownerUserId,
            'ear_tag' => (int) ($data['earTag'] ?? 0),
            'type' => $this->normalizeText((string) ($data['type'] ?? '')),
            'weight' => $this->nullableFloat($data['weight'] ?? null),
            'health_status' => $this->normalizeText((string) ($data['healthStatus'] ?? '')),
            'birth_date' => $this->toDateString($data['birthDate'] ?? null),
            'entry_date' => $this->toDateString($data['entryDate'] ?? null),
            'origin' => $this->normalizeUppercase((string) ($data['origin'] ?? '')),
            'vaccinated' => $this->boolToInt($data['vaccinated'] ?? false),
            'location' => $this->normalizeText((string) ($data['location'] ?? '')),
        ];

        if ($this->isOraclePlatform()) {
            $this->connection->executeStatement(
                "INSERT INTO ANIMALS (ID, USER_ID, EAR_TAG, TYPE, WEIGHT, HEALTH_STATUS, BIRTH_DATE, ENTRY_DATE, ORIGIN, VACCINATED, LOCATION) VALUES (ANIMAL_SEQ.NEXTVAL, :user_id, :ear_tag, :type, :weight, :health_status, TO_DATE(:birth_date, 'YYYY-MM-DD'), TO_DATE(:entry_date, 'YYYY-MM-DD'), :origin, :vaccinated, :location)",
                $this->oracleAnimalPayload($payload)
            );

            return 0;
        }

        $this->connection->insert('ANIMALS', $payload);

        return $this->lastInsertedId();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updateAnimal(int $id, array $data, ?int $ownerUserId = null): void
    {
        $this->ensureSchema();

        $fields = [
            'ear_tag' => (int) ($data['earTag'] ?? 0),
            'type' => $this->normalizeText((string) ($data['type'] ?? '')),
            'weight' => $this->nullableFloat($data['weight'] ?? null),
            'health_status' => $this->normalizeText((string) ($data['healthStatus'] ?? '')),
            'birth_date' => $this->toDateString($data['birthDate'] ?? null),
            'entry_date' => $this->toDateString($data['entryDate'] ?? null),
            'origin' => $this->normalizeUppercase((string) ($data['origin'] ?? '')),
            'vaccinated' => $this->boolToInt($data['vaccinated'] ?? false),
            'location' => $this->normalizeText((string) ($data['location'] ?? '')),
        ];

        $sql = 'UPDATE ANIMALS SET ear_tag = :ear_tag, type = :type, weight = :weight, health_status = :health_status, birth_date = :birth_date, entry_date = :entry_date, origin = :origin, vaccinated = :vaccinated, location = :location WHERE id = :id';
        $params = $fields + ['id' => $id];

        if ($this->isOraclePlatform()) {
            $sql = "UPDATE ANIMALS SET ear_tag = :ear_tag, type = :type, weight = :weight, health_status = :health_status, birth_date = TO_DATE(:birth_date, 'YYYY-MM-DD'), entry_date = TO_DATE(:entry_date, 'YYYY-MM-DD'), origin = :origin, vaccinated = :vaccinated, location = :location WHERE id = :id";
            $params = $this->oracleAnimalPayload($params);
        }

        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = :ownerUserId';
            $params['ownerUserId'] = $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
    }

    public function deleteAnimal(int $id, ?int $ownerUserId = null): void
    {
        $this->ensureSchema();

        $sql = 'DELETE FROM ANIMALS WHERE id = :id';
        $params = ['id' => $id];
        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = :ownerUserId';
            $params['ownerUserId'] = $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listRecords(?int $animalId = null, ?int $ownerUserId = null): array
    {
        $this->ensureSchema();

        $sql = 'SELECT r.id, r.user_id, r.animal_id, a.ear_tag, a.type, r.record_date, r.weight, r.appetite, r.condition_status, r.milk_yield, r.egg_count, r.wool_length, r.notes FROM ANIMAL_HEALTH_RECORDS r LEFT JOIN ANIMALS a ON a.id = r.animal_id';
        $conditions = [];
        $params = [];

        if ($ownerUserId !== null) {
            $conditions[] = 'r.user_id = :ownerUserId';
            $params['ownerUserId'] = $ownerUserId;
        }

        if ($animalId !== null) {
            $conditions[] = 'r.animal_id = :animalId';
            $params['animalId'] = $animalId;
        }

        if ($conditions !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $sql .= ' ORDER BY r.id DESC';

        $rows = $this->connection->fetchAllAssociative($sql, $params);

        return array_map(function (array $row): array {
            $recordDate = $this->toDateTime($row['record_date'] ?? null);

            return [
                'id' => (int) ($row['id'] ?? 0),
                'userId' => (int) ($row['user_id'] ?? 0),
                'animal' => [
                    'id' => (int) ($row['animal_id'] ?? 0),
                    'earTag' => (int) ($row['ear_tag'] ?? 0),
                    'type' => (string) ($row['type'] ?? ''),
                ],
                'recordDate' => $recordDate,
                'weight' => $row['weight'] !== null && $row['weight'] !== '' ? (float) $row['weight'] : null,
                'appetite' => (string) ($row['appetite'] ?? ''),
                'conditionStatus' => (string) ($row['condition_status'] ?? ''),
                'milkYield' => $row['milk_yield'] !== null && $row['milk_yield'] !== '' ? (float) $row['milk_yield'] : null,
                'eggCount' => $row['egg_count'] !== null && $row['egg_count'] !== '' ? (int) $row['egg_count'] : null,
                'woolLength' => $row['wool_length'] !== null && $row['wool_length'] !== '' ? (float) $row['wool_length'] : null,
                'notes' => (string) ($row['notes'] ?? ''),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findRecord(int $id, ?int $ownerUserId = null): ?array
    {
        $this->ensureSchema();

        $sql = 'SELECT r.id, r.user_id, r.animal_id, a.ear_tag, a.type, r.record_date, r.weight, r.appetite, r.condition_status, r.milk_yield, r.egg_count, r.wool_length, r.notes FROM ANIMAL_HEALTH_RECORDS r LEFT JOIN ANIMALS a ON a.id = r.animal_id WHERE r.id = :id';
        $params = ['id' => $id];
        if ($ownerUserId !== null) {
            $sql .= ' AND r.user_id = :ownerUserId';
            $params['ownerUserId'] = $ownerUserId;
        }

        $rows = $this->connection->fetchAllAssociative($sql, $params);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];
        $recordDate = $this->toDateTime($row['record_date'] ?? null);

        return [
            'id' => (int) ($row['id'] ?? 0),
            'userId' => (int) ($row['user_id'] ?? 0),
            'animal' => [
                'id' => (int) ($row['animal_id'] ?? 0),
                'earTag' => (int) ($row['ear_tag'] ?? 0),
                'type' => (string) ($row['type'] ?? ''),
            ],
            'recordDate' => $recordDate,
            'weight' => $row['weight'] !== null && $row['weight'] !== '' ? (float) $row['weight'] : null,
            'appetite' => (string) ($row['appetite'] ?? ''),
            'conditionStatus' => (string) ($row['condition_status'] ?? ''),
            'milkYield' => $row['milk_yield'] !== null && $row['milk_yield'] !== '' ? (float) $row['milk_yield'] : null,
            'eggCount' => $row['egg_count'] !== null && $row['egg_count'] !== '' ? (int) $row['egg_count'] : null,
            'woolLength' => $row['wool_length'] !== null && $row['wool_length'] !== '' ? (float) $row['wool_length'] : null,
            'notes' => (string) ($row['notes'] ?? ''),
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    public function createRecord(array $data, int $ownerUserId): int
    {
        $this->ensureSchema();

        $animalId = (int) ($data['animalId'] ?? 0);
        $animal = $this->findAnimal($animalId, $ownerUserId);
        if ($animal === null) {
            throw new \RuntimeException('Selected animal does not belong to this user.');
        }

        $payload = $this->buildRecordPayload($data, $animal['type'], $ownerUserId, $animalId);

        if ($this->isOraclePlatform()) {
            $this->connection->executeStatement(
                "INSERT INTO ANIMAL_HEALTH_RECORDS (ID, USER_ID, ANIMAL_ID, RECORD_DATE, WEIGHT, APPETITE, CONDITION_STATUS, MILK_YIELD, EGG_COUNT, WOOL_LENGTH, NOTES) VALUES (ANIMAL_RECORD_SEQ.NEXTVAL, :user_id, :animal_id, TO_DATE(:record_date, 'YYYY-MM-DD'), :weight, :appetite, :condition_status, :milk_yield, :egg_count, :wool_length, :notes)",
                $this->oracleRecordPayload($payload)
            );
            $this->syncAnimalFromRecord($animalId, $ownerUserId, $payload);

            return 0;
        } else {
            $this->connection->insert('ANIMAL_HEALTH_RECORDS', $payload);
        }

        $this->syncAnimalFromRecord($animalId, $ownerUserId, $payload);

        return $this->lastInsertedId();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function updateRecord(int $id, array $data, ?int $ownerUserId = null): void
    {
        $this->ensureSchema();

        $record = $this->findRecord($id, $ownerUserId);
        if ($record === null) {
            throw new \RuntimeException('Record not found.');
        }

        $animalId = (int) ($record['animal']['id'] ?? 0);
        $animal = $this->findAnimal($animalId, $ownerUserId);
        if ($animal === null) {
            throw new \RuntimeException('Selected animal does not belong to this user.');
        }

        $payload = $this->buildRecordPayload($data, $animal['type'], $ownerUserId ?? (int) ($record['userId'] ?? 0), $animalId);

        $sql = 'UPDATE ANIMAL_HEALTH_RECORDS SET animal_id = :animal_id, record_date = :record_date, weight = :weight, appetite = :appetite, condition_status = :condition_status, milk_yield = :milk_yield, egg_count = :egg_count, wool_length = :wool_length, notes = :notes WHERE id = :id';
        $params = $payload + ['id' => $id];

        if ($this->isOraclePlatform()) {
            $sql = "UPDATE ANIMAL_HEALTH_RECORDS SET animal_id = :animal_id, record_date = TO_DATE(:record_date, 'YYYY-MM-DD'), weight = :weight, appetite = :appetite, condition_status = :condition_status, milk_yield = :milk_yield, egg_count = :egg_count, wool_length = :wool_length, notes = :notes WHERE id = :id";
            $params = $this->oracleRecordPayload($params);
        }

        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = :ownerUserId';
            $params['ownerUserId'] = $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
        $this->syncAnimalFromRecord($animalId, $ownerUserId ?? (int) ($record['userId'] ?? 0), $payload);
    }

    public function deleteRecord(int $id, ?int $ownerUserId = null): void
    {
        $this->ensureSchema();

        $sql = 'DELETE FROM ANIMAL_HEALTH_RECORDS WHERE id = :id';
        $params = ['id' => $id];
        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = :ownerUserId';
            $params['ownerUserId'] = $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
    }

    /**
     * @return array<int, string>
     */
    public function getTypeOptions(): array
    {
        return $this->listOptionValues('ANIMAL_TYPE_OPTIONS');
    }

    public function addType(string $value): void
    {
        $this->addOption('ANIMAL_TYPE_OPTIONS', $value, 'Type');
    }

    public function deleteType(string $value): void
    {
        $this->deleteOption('ANIMAL_TYPE_OPTIONS', 'type', $value, 'Type');
    }

    /**
     * @return array<int, string>
     */
    public function getLocationOptions(): array
    {
        return $this->listOptionValues('ANIMAL_LOCATION_OPTIONS');
    }

    public function addLocation(string $value): void
    {
        $this->addOption('ANIMAL_LOCATION_OPTIONS', $value, 'Location');
    }

    public function deleteLocation(string $value): void
    {
        $this->deleteOption('ANIMAL_LOCATION_OPTIONS', 'location', $value, 'Location');
    }

    public function countAnimals(?int $ownerUserId = null): int
    {
        $this->ensureSchema();

        $sql = 'SELECT COUNT(*) FROM ANIMALS';
        $params = [];
        if ($ownerUserId !== null) {
            $sql .= ' WHERE user_id = :ownerUserId';
            $params['ownerUserId'] = $ownerUserId;
        }

        return (int) $this->connection->fetchOne($sql, $params);
    }

    public function countRecords(?int $ownerUserId = null): int
    {
        $this->ensureSchema();

        $sql = 'SELECT COUNT(*) FROM ANIMAL_HEALTH_RECORDS';
        $params = [];
        if ($ownerUserId !== null) {
            $sql .= ' WHERE user_id = :ownerUserId';
            $params['ownerUserId'] = $ownerUserId;
        }

        return (int) $this->connection->fetchOne($sql, $params);
    }

    private function seedDefaultOptions(): void
    {
        foreach (['cow', 'goat', 'chicken', 'sheep'] as $type) {
            $this->insertOptionIfMissing('ANIMAL_TYPE_OPTIONS', $type);
        }

        foreach (['barn', 'pasture', 'coop', 'pen'] as $location) {
            $this->insertOptionIfMissing('ANIMAL_LOCATION_OPTIONS', $location);
        }
    }

    private function insertOptionIfMissing(string $table, string $value): void
    {
        $normalized = $this->normalizeText($value);
        if ($normalized === '') {
            return;
        }

        $existing = (int) $this->connection->fetchOne('SELECT COUNT(*) FROM ' . $table . ' WHERE value = :value', ['value' => $normalized]);
        if ($existing > 0) {
            return;
        }

        $this->connection->insert($table, ['value' => $normalized]);
    }

    /**
     * @return array<int, string>
     */
    private function listOptionValues(string $table): array
    {
        $this->ensureSchema();

        $values = $this->connection->fetchFirstColumn('SELECT value FROM ' . $table . ' ORDER BY value');
        return array_values(array_map(static fn ($value): string => (string) $value, $values));
    }

    private function addOption(string $table, string $value, string $label): void
    {
        $normalized = $this->normalizeText($value);
        if ($normalized === '') {
            throw new \RuntimeException($label . ' cannot be empty.');
        }

        $existing = (int) $this->connection->fetchOne('SELECT COUNT(*) FROM ' . $table . ' WHERE value = :value', ['value' => $normalized]);
        if ($existing > 0) {
            throw new \RuntimeException($label . ' already exists.');
        }

        $this->connection->insert($table, ['value' => $normalized]);
    }

    private function deleteOption(string $table, string $column, string $value, string $label): void
    {
        $normalized = $this->normalizeText($value);
        if ($normalized === '') {
            throw new \RuntimeException($label . ' cannot be empty.');
        }

        $usageCount = (int) $this->connection->fetchOne('SELECT COUNT(*) FROM ANIMALS WHERE ' . $column . ' = :value', ['value' => $normalized]);
        if ($usageCount > 0) {
            throw new \RuntimeException('Cannot delete ' . strtolower($label) . ' used by animals.');
        }

        $remaining = (int) $this->connection->fetchOne('SELECT COUNT(*) FROM ' . $table);
        if ($remaining <= 1) {
            throw new \RuntimeException('At least one ' . strtolower($label) . ' option is required.');
        }

        $this->connection->delete($table, ['value' => $normalized]);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function buildRecordPayload(array $data, string $animalType, int $ownerUserId, int $animalId): array
    {
        $payload = [
            'user_id' => $ownerUserId,
            'animal_id' => $animalId,
            'record_date' => $this->toDateString($data['recordDate'] ?? null),
            'weight' => $this->nullableFloat($data['weight'] ?? null),
            'appetite' => $this->normalizeUppercase((string) ($data['appetite'] ?? '')),
            'condition_status' => $this->normalizeUppercase((string) ($data['conditionStatus'] ?? '')),
            'milk_yield' => null,
            'egg_count' => null,
            'wool_length' => null,
            'notes' => $this->trimToNull((string) ($data['notes'] ?? '')),
        ];

        $production = trim((string) ($data['production'] ?? ''));
        $type = strtolower($animalType);

        if ($production !== '') {
            if (in_array($type, ['cow', 'goat'], true)) {
                $payload['milk_yield'] = $this->nullableFloat($production);
            } elseif ($type === 'chicken') {
                $payload['egg_count'] = (int) $production;
            } elseif ($type === 'sheep') {
                $payload['wool_length'] = $this->nullableFloat($production);
            }
        }

        return $payload;
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function syncAnimalFromRecord(int $animalId, int $ownerUserId, array $payload): void
    {
        $animal = $this->findAnimal($animalId, $ownerUserId);
        if ($animal === null) {
            return;
        }

        $this->connection->update('ANIMALS', [
            'health_status' => strtolower((string) ($payload['condition_status'] ?? '')),
            'weight' => $payload['weight'] ?? null,
        ], [
            'id' => $animalId,
            'user_id' => $ownerUserId,
        ]);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    private function oracleAnimalPayload(array $payload): array
    {
        return [
            'id' => isset($payload['id']) ? (int) $payload['id'] : null,
            'user_id' => (int) ($payload['user_id'] ?? 0),
            'ear_tag' => (int) ($payload['ear_tag'] ?? 0),
            'type' => $payload['type'] ?? null,
            'weight' => $payload['weight'] ?? null,
            'health_status' => $payload['health_status'] ?? null,
            'birth_date' => $payload['birth_date'] ?? null,
            'entry_date' => $payload['entry_date'] ?? null,
            'origin' => $payload['origin'] ?? null,
            'vaccinated' => (int) ($payload['vaccinated'] ?? 0),
            'location' => $payload['location'] ?? null,
        ];
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    private function oracleRecordPayload(array $payload): array
    {
        return [
            'id' => isset($payload['id']) ? (int) $payload['id'] : null,
            'user_id' => (int) ($payload['user_id'] ?? 0),
            'animal_id' => (int) ($payload['animal_id'] ?? 0),
            'record_date' => $payload['record_date'] ?? null,
            'weight' => $payload['weight'] ?? null,
            'appetite' => $payload['appetite'] ?? null,
            'condition_status' => $payload['condition_status'] ?? null,
            'milk_yield' => $payload['milk_yield'] ?? null,
            'egg_count' => $payload['egg_count'] ?? null,
            'wool_length' => $payload['wool_length'] ?? null,
            'notes' => $payload['notes'] ?? null,
        ];
    }

    private function boolToInt(mixed $value): int
    {
        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        $normalized = strtolower(trim((string) $value));
        return in_array($normalized, ['1', 'true', 'on', 'yes'], true) ? 1 : 0;
    }

    private function normalizeText(string $value): string
    {
        return strtolower(trim($value));
    }

    private function normalizeUppercase(string $value): string
    {
        return strtoupper(trim($value));
    }

    private function trimToNull(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim($value);
        return $trimmed === '' ? null : $trimmed;
    }

    private function nullableFloat(mixed $value): ?float
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        $normalized = str_replace(',', '.', trim((string) $value));
        return is_numeric($normalized) ? (float) $normalized : null;
    }

    private function toDateString(mixed $value): ?string
    {
        $trimmed = trim((string) $value);
        if ($trimmed === '') {
            return null;
        }

        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $trimmed);
        return $date instanceof \DateTimeImmutable ? $date->format('Y-m-d') : null;
    }

    private function toDateTime(mixed $value): ?\DateTimeImmutable
    {
        if ($value instanceof \DateTimeInterface) {
            return \DateTimeImmutable::createFromInterface($value);
        }

        $trimmed = trim((string) $value);
        if ($trimmed === '') {
            return null;
        }

        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $trimmed);
        return $date instanceof \DateTimeImmutable ? $date : null;
    }

    private function isOraclePlatform(): bool
    {
        return str_contains(strtolower(get_class($this->connection->getDatabasePlatform())), 'oracle');
    }

    private function lastInsertedId(): int
    {
        $lastId = $this->connection->lastInsertId();
        if ($lastId === '' || $lastId === false) {
            return 0;
        }

        return (int) $lastId;
    }
}