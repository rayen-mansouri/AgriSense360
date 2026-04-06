<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class OracleSqlPlusCrudService
{
    private bool $schemaInitialized = false;

    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listEquipments(?int $ownerUserId = null): array
    {
        $this->ensureSchema();

        $sql = 'SELECT id, user_id, name, type, status, purchase_date FROM EQUIPMENTS';
        $params = [];
        if ($ownerUserId !== null) {
            $sql .= ' WHERE user_id = :ownerUserId';
            $params['ownerUserId'] = (int) $ownerUserId;
        }
        $sql .= ' ORDER BY id DESC';

        $rows = $this->connection->fetchAllAssociative($sql, $params);

        return array_map(function (array $row): array {
            return [
                'id' => (int) ($row['id'] ?? 0),
                'userId' => (int) ($row['user_id'] ?? 0),
                'name' => (string) ($row['name'] ?? ''),
                'type' => (string) ($row['type'] ?? ''),
                'status' => (string) ($row['status'] ?? ''),
                'purchaseDate' => $this->toDateTime((string) ($row['purchase_date'] ?? '')),
            ];
        }, $rows);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listMaintenances(?int $ownerUserId = null): array
    {
        $this->ensureSchema();

        $sql = "SELECT m.id, m.user_id, m.equipment_id, COALESCE(e.name, '') AS equipment_name, m.maintenance_date, m.maintenance_type, m.cost FROM MAINTENANCE m LEFT JOIN EQUIPMENTS e ON e.id = m.equipment_id";
        $params = [];
        if ($ownerUserId !== null) {
            $sql .= ' WHERE m.user_id = :ownerUserId';
            $params['ownerUserId'] = (int) $ownerUserId;
        }
        $sql .= ' ORDER BY m.id DESC';

        $rows = $this->connection->fetchAllAssociative($sql, $params);

        return array_map(function (array $row): array {
            return [
                'id' => (int) ($row['id'] ?? 0),
                'userId' => (int) ($row['user_id'] ?? 0),
                'equipment' => [
                    'id' => (int) ($row['equipment_id'] ?? 0),
                    'name' => (string) ($row['equipment_name'] ?? ''),
                ],
                'maintenanceDate' => $this->toDateTime((string) ($row['maintenance_date'] ?? '')),
                'maintenanceType' => (string) ($row['maintenance_type'] ?? ''),
                'cost' => (string) ($row['cost'] ?? '0'),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findEquipment(int $id, ?int $ownerUserId = null): ?array
    {
        $this->ensureSchema();

        $sql = 'SELECT id, user_id, name, type, status, purchase_date FROM EQUIPMENTS WHERE id = :id';
        $params = ['id' => $id];
        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = :ownerUserId';
            $params['ownerUserId'] = (int) $ownerUserId;
        }

        $rows = $this->connection->fetchAllAssociative($sql, $params);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) ($row['id'] ?? 0),
            'userId' => (int) ($row['user_id'] ?? 0),
            'name' => (string) ($row['name'] ?? ''),
            'type' => (string) ($row['type'] ?? ''),
            'status' => (string) ($row['status'] ?? ''),
            'purchaseDate' => $this->toDateTime((string) ($row['purchase_date'] ?? '')),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findMaintenance(int $id, ?int $ownerUserId = null): ?array
    {
        $this->ensureSchema();

        $sql = "SELECT m.id, m.user_id, m.equipment_id, COALESCE(e.name, '') AS equipment_name, m.maintenance_date, m.maintenance_type, m.cost FROM MAINTENANCE m LEFT JOIN EQUIPMENTS e ON e.id = m.equipment_id WHERE m.id = :id";
        $params = ['id' => $id];
        if ($ownerUserId !== null) {
            $sql .= ' AND m.user_id = :ownerUserId';
            $params['ownerUserId'] = (int) $ownerUserId;
        }

        $rows = $this->connection->fetchAllAssociative($sql, $params);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) ($row['id'] ?? 0),
            'userId' => (int) ($row['user_id'] ?? 0),
            'equipment' => [
                'id' => (int) ($row['equipment_id'] ?? 0),
                'name' => (string) ($row['equipment_name'] ?? ''),
            ],
            'maintenanceDate' => $this->toDateTime((string) ($row['maintenance_date'] ?? '')),
            'maintenanceType' => (string) ($row['maintenance_type'] ?? ''),
            'cost' => (string) ($row['cost'] ?? '0'),
        ];
    }

    /**
     * @param array{name:?string,type:?string,status:?string,purchaseDate:?string} $data
     */
    public function createEquipment(array $data, int $ownerUserId): void
    {
        $this->ensureSchema();

        $payload = [
            'user_id' => (int) $ownerUserId,
            'name' => $this->trimToNull($data['name']),
            'type' => $this->trimToNull($data['type']),
            'status' => $this->trimToNull($data['status']) ?? 'Ready',
            'purchase_date' => $this->toDateString($data['purchaseDate']),
        ];

        if ($this->isOraclePlatform()) {
            $this->connection->executeStatement(
                "INSERT INTO EQUIPMENTS (ID, USER_ID, NAME, TYPE, STATUS, PURCHASE_DATE) VALUES (EQUIPMENT_SEQ.NEXTVAL, :user_id, :name, :type, :status, TO_DATE(:purchase_date, 'YYYY-MM-DD'))",
                $payload
            );

            return;
        }

        $this->connection->insert('EQUIPMENTS', $payload);
    }

    /**
     * @param array{name:?string,type:?string,status:?string,purchaseDate:?string} $data
     */
    public function updateEquipment(int $id, array $data, ?int $ownerUserId = null): void
    {
        $this->ensureSchema();

        $sql = 'UPDATE EQUIPMENTS SET name = :name, type = :type, status = :status, purchase_date = :purchaseDate WHERE id = :id';
        $params = [
            'name' => $this->trimToNull($data['name']),
            'type' => $this->trimToNull($data['type']),
            'status' => $this->trimToNull($data['status']) ?? 'Ready',
            'purchaseDate' => $this->toDateString($data['purchaseDate']),
            'id' => $id,
        ];

        if ($this->isOraclePlatform()) {
            $sql = "UPDATE EQUIPMENTS SET name = :name, type = :type, status = :status, purchase_date = TO_DATE(:purchaseDate, 'YYYY-MM-DD') WHERE id = :id";
        }

        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = :ownerUserId';
            $params['ownerUserId'] = (int) $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
    }

    public function deleteEquipment(int $id, ?int $ownerUserId = null): void
    {
        $this->ensureSchema();

        $this->connection->beginTransaction();
        try {
            $maintenanceSql = 'DELETE FROM MAINTENANCE WHERE equipment_id = :id';
            $equipmentSql = 'DELETE FROM EQUIPMENTS WHERE id = :id';
            $params = ['id' => $id];
            if ($ownerUserId !== null) {
                $maintenanceSql .= ' AND user_id = :ownerUserId';
                $equipmentSql .= ' AND user_id = :ownerUserId';
                $params['ownerUserId'] = (int) $ownerUserId;
            }

            $this->connection->executeStatement($maintenanceSql, $params);
            $this->connection->executeStatement($equipmentSql, $params);

            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    /**
     * @param array{equipmentId:int,maintenanceDate:?string,maintenanceType:?string,cost:?string} $data
     */
    public function createMaintenance(array $data, int $ownerUserId): void
    {
        $this->ensureSchema();

        $equipmentId = (int) $data['equipmentId'];
        $maintenanceDate = $this->toDateString($data['maintenanceDate']);
        $maintenanceType = $this->trimToNull($data['maintenanceType']);
        $cost = $this->numericOrZero($data['cost']);
        $safeOwnerId = (int) $ownerUserId;

        $ownedEquipment = $this->findEquipment($equipmentId, $safeOwnerId);
        if ($ownedEquipment === null) {
            throw new \RuntimeException('Selected equipment does not belong to this user.');
        }

        if ($this->isOraclePlatform()) {
            $this->connection->executeStatement(
                "INSERT INTO MAINTENANCE (ID, USER_ID, EQUIPMENT_ID, MAINTENANCE_DATE, MAINTENANCE_TYPE, COST) VALUES (MAINTENANCE_SEQ.NEXTVAL, :user_id, :equipment_id, TO_DATE(:maintenance_date, 'YYYY-MM-DD'), :maintenance_type, :cost)",
                [
                    'user_id' => $safeOwnerId,
                    'equipment_id' => $equipmentId,
                    'maintenance_date' => $maintenanceDate,
                    'maintenance_type' => $maintenanceType,
                    'cost' => $cost,
                ]
            );

            return;
        }

        $this->connection->insert('MAINTENANCE', [
            'user_id' => $safeOwnerId,
            'equipment_id' => $equipmentId,
            'maintenance_date' => $maintenanceDate,
            'maintenance_type' => $maintenanceType,
            'cost' => $cost,
        ]);
    }

    /**
     * @param array{equipmentId:int,maintenanceDate:?string,maintenanceType:?string,cost:?string} $data
     */
    public function updateMaintenance(int $id, array $data, ?int $ownerUserId = null): void
    {
        $this->ensureSchema();

        $equipmentId = (int) $data['equipmentId'];
        $maintenanceDate = $this->toDateString($data['maintenanceDate']);
        $maintenanceType = $this->trimToNull($data['maintenanceType']);
        $cost = $this->numericOrZero($data['cost']);

        $sql = 'UPDATE MAINTENANCE SET equipment_id = :equipmentId, maintenance_date = :maintenanceDate, maintenance_type = :maintenanceType, cost = :cost WHERE id = :id';
        $params = [
            'equipmentId' => $equipmentId,
            'maintenanceDate' => $maintenanceDate,
            'maintenanceType' => $maintenanceType,
            'cost' => $cost,
            'id' => $id,
        ];
        if ($this->isOraclePlatform()) {
            $sql = "UPDATE MAINTENANCE SET equipment_id = :equipmentId, maintenance_date = TO_DATE(:maintenanceDate, 'YYYY-MM-DD'), maintenance_type = :maintenanceType, cost = :cost WHERE id = :id";
        }
        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = :ownerUserId';
            $params['ownerUserId'] = (int) $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
    }

    public function deleteMaintenance(int $id, ?int $ownerUserId = null): void
    {
        $this->ensureSchema();

        $sql = 'DELETE FROM MAINTENANCE WHERE id = :id';
        $params = ['id' => $id];
        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = :ownerUserId';
            $params['ownerUserId'] = (int) $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listUsers(): array
    {
        $this->ensureSchema();

        $rows = $this->connection->fetchAllAssociative(
            'SELECT id, last_name, first_name, email, password_hash, status, role_name, created_at FROM USERS ORDER BY id DESC'
        );

        return array_map(function (array $row): array {
            return [
                'id' => (int) ($row['id'] ?? 0),
                'lastName' => (string) ($row['last_name'] ?? ''),
                'firstName' => (string) ($row['first_name'] ?? ''),
                'email' => (string) ($row['email'] ?? ''),
                'passwordHash' => (string) ($row['password_hash'] ?? ''),
                'status' => (string) ($row['status'] ?? ''),
                'roleName' => (string) ($row['role_name'] ?? ''),
                'createdAt' => $this->toDateTime((string) ($row['created_at'] ?? '')),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findUser(int $id): ?array
    {
        $this->ensureSchema();

        $rows = $this->connection->fetchAllAssociative(
            'SELECT id, last_name, first_name, email, password_hash, status, role_name, created_at FROM USERS WHERE id = :id',
            ['id' => $id]
        );
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) ($row['id'] ?? 0),
            'lastName' => (string) ($row['last_name'] ?? ''),
            'firstName' => (string) ($row['first_name'] ?? ''),
            'email' => (string) ($row['email'] ?? ''),
            'passwordHash' => (string) ($row['password_hash'] ?? ''),
            'status' => (string) ($row['status'] ?? ''),
            'roleName' => (string) ($row['role_name'] ?? ''),
            'createdAt' => $this->toDateTime((string) ($row['created_at'] ?? '')),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findUserByEmail(string $email): ?array
    {
        $this->ensureSchema();

        $rows = $this->connection->fetchAllAssociative(
            'SELECT id, last_name, first_name, email, password_hash, status, role_name, created_at FROM USERS WHERE LOWER(email) = LOWER(:email)',
            ['email' => trim($email)]
        );
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) ($row['id'] ?? 0),
            'lastName' => (string) ($row['last_name'] ?? ''),
            'firstName' => (string) ($row['first_name'] ?? ''),
            'email' => (string) ($row['email'] ?? ''),
            'passwordHash' => (string) ($row['password_hash'] ?? ''),
            'status' => (string) ($row['status'] ?? ''),
            'roleName' => (string) ($row['role_name'] ?? ''),
            'createdAt' => $this->toDateTime((string) ($row['created_at'] ?? '')),
        ];
    }

    /**
     * @param array{lastName:?string,firstName:?string,email:?string,passwordHash:?string,status:?string,roleName:?string} $data
     */
    public function createUser(array $data): void
    {
        $this->ensureSchema();

        if ($this->isOraclePlatform()) {
            $this->connection->executeStatement(
                'INSERT INTO USERS (ID, LAST_NAME, FIRST_NAME, EMAIL, PASSWORD_HASH, STATUS, ROLE_NAME, CREATED_AT) VALUES (USER_SEQ.NEXTVAL, :last_name, :first_name, :email, :password_hash, :status, :role_name, SYSDATE)',
                [
                    'last_name' => $this->trimToNull($data['lastName']),
                    'first_name' => $this->trimToNull($data['firstName']),
                    'email' => $this->trimToNull($data['email']),
                    'password_hash' => $this->trimToNull($data['passwordHash']),
                    'status' => $this->trimToNull($data['status']) ?? 'Active',
                    'role_name' => $this->trimToNull($data['roleName']) ?? 'USER',
                ]
            );

            return;
        }

        $this->connection->insert('USERS', [
            'last_name' => $this->trimToNull($data['lastName']),
            'first_name' => $this->trimToNull($data['firstName']),
            'email' => $this->trimToNull($data['email']),
            'password_hash' => $this->trimToNull($data['passwordHash']),
            'status' => $this->trimToNull($data['status']) ?? 'Active',
            'role_name' => $this->trimToNull($data['roleName']) ?? 'USER',
            'created_at' => (new \DateTimeImmutable())->format('Y-m-d'),
        ]);
    }

    /**
     * @param array{lastName:?string,firstName:?string,email:?string,passwordHash:?string,status:?string,roleName:?string} $data
     */
    public function updateUser(int $id, array $data): void
    {
        $this->ensureSchema();

        $fields = [
            'last_name' => $this->trimToNull($data['lastName']),
            'first_name' => $this->trimToNull($data['firstName']),
            'email' => $this->trimToNull($data['email']),
            'status' => $this->trimToNull($data['status']),
            'role_name' => $this->trimToNull($data['roleName']),
        ];

        if (($data['passwordHash'] ?? null) !== null && trim((string) $data['passwordHash']) !== '') {
            $fields['password_hash'] = trim((string) $data['passwordHash']);
        }

        $this->connection->update('USERS', $fields, ['id' => $id]);
    }

    public function deleteUser(int $id): void
    {
        $this->ensureSchema();
        $this->connection->executeStatement('DELETE FROM USERS WHERE id = :id', ['id' => $id]);
    }

    private function ensureSchema(): void
    {
        if ($this->schemaInitialized) {
            return;
        }

        $platform = strtolower(get_class($this->connection->getDatabasePlatform()));

        if (str_contains($platform, 'sqlite')) {
            $this->connection->executeStatement('PRAGMA foreign_keys = ON');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS USERS (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                last_name TEXT NOT NULL,
                first_name TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                status TEXT NOT NULL,
                role_name TEXT NOT NULL,
                created_at TEXT NOT NULL
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS EQUIPMENTS (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                name TEXT NOT NULL,
                type TEXT NOT NULL,
                status TEXT NOT NULL,
                purchase_date TEXT DEFAULT NULL,
                FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS MAINTENANCE (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                equipment_id INTEGER NOT NULL,
                maintenance_date TEXT DEFAULT NULL,
                maintenance_type TEXT NOT NULL,
                cost REAL NOT NULL DEFAULT 0,
                FOREIGN KEY (equipment_id) REFERENCES EQUIPMENTS(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
            )');
            $this->schemaInitialized = true;

            return;
        }

        if (str_contains($platform, 'mysql')) {
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS USERS (
                id INT AUTO_INCREMENT PRIMARY KEY,
                last_name VARCHAR(120) NOT NULL,
                first_name VARCHAR(120) NOT NULL,
                email VARCHAR(180) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                status VARCHAR(30) NOT NULL,
                role_name VARCHAR(80) NOT NULL,
                created_at DATE NOT NULL
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS EQUIPMENTS (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                name VARCHAR(120) NOT NULL,
                type VARCHAR(80) NOT NULL,
                status VARCHAR(30) NOT NULL,
                purchase_date DATE NULL,
                CONSTRAINT fk_equipments_user FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS MAINTENANCE (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                equipment_id INT NOT NULL,
                maintenance_date DATE NULL,
                maintenance_type VARCHAR(80) NOT NULL,
                cost DECIMAL(10,2) NOT NULL DEFAULT 0,
                CONSTRAINT fk_maintenance_equipment FOREIGN KEY (equipment_id) REFERENCES EQUIPMENTS(id) ON DELETE CASCADE,
                CONSTRAINT fk_maintenance_user FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
            )');

            $this->schemaInitialized = true;

            return;
        }

        if (str_contains($platform, 'oracle')) {
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE SEQUENCE USER_SEQ START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 AND SQLCODE != -2289 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE SEQUENCE EQUIPMENT_SEQ START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 AND SQLCODE != -2289 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE SEQUENCE MAINTENANCE_SEQ START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 AND SQLCODE != -2289 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE TABLE USERS (
        ID NUMBER(10) NOT NULL,
        LAST_NAME VARCHAR2(120) NOT NULL,
        FIRST_NAME VARCHAR2(120) NOT NULL,
        EMAIL VARCHAR2(180) NOT NULL,
        PASSWORD_HASH VARCHAR2(255) NOT NULL,
        STATUS VARCHAR2(30) NOT NULL,
        ROLE_NAME VARCHAR2(80) NOT NULL,
        CREATED_AT DATE DEFAULT SYSDATE NOT NULL,
        CONSTRAINT PK_USERS PRIMARY KEY (ID),
        CONSTRAINT UQ_USERS_EMAIL UNIQUE (EMAIL)
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
    EXECUTE IMMEDIATE 'CREATE TABLE EQUIPMENTS (
        ID NUMBER(10) NOT NULL,
        USER_ID NUMBER(10) NOT NULL,
        NAME VARCHAR2(120) NOT NULL,
        TYPE VARCHAR2(80) NOT NULL,
        STATUS VARCHAR2(30) NOT NULL,
        PURCHASE_DATE DATE,
        CONSTRAINT PK_EQUIPMENTS PRIMARY KEY (ID),
        CONSTRAINT FK_EQUIPMENTS_USER FOREIGN KEY (USER_ID) REFERENCES USERS(ID) ON DELETE CASCADE
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
    EXECUTE IMMEDIATE 'CREATE TABLE MAINTENANCE (
        ID NUMBER(10) NOT NULL,
        USER_ID NUMBER(10) NOT NULL,
        EQUIPMENT_ID NUMBER(10) NOT NULL,
        MAINTENANCE_DATE DATE,
        MAINTENANCE_TYPE VARCHAR2(80) NOT NULL,
        COST NUMBER(10, 2) NOT NULL,
        CONSTRAINT PK_MAINTENANCE PRIMARY KEY (ID),
        CONSTRAINT FK_MAINTENANCE_EQUIPMENT FOREIGN KEY (EQUIPMENT_ID) REFERENCES EQUIPMENTS(ID) ON DELETE CASCADE,
        CONSTRAINT FK_MAINTENANCE_USER FOREIGN KEY (USER_ID) REFERENCES USERS(ID) ON DELETE CASCADE
    )';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 THEN
            RAISE;
        END IF;
END;
SQL);

            $this->schemaInitialized = true;

            return;
        }

        throw new \RuntimeException('Unsupported database platform: ' . $platform);
    }

    private function isOraclePlatform(): bool
    {
        return str_contains(strtolower(get_class($this->connection->getDatabasePlatform())), 'oracle');
    }

    private function trimToNull(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        return trim($value);
    }

    private function toDateString(?string $value): ?string
    {
        $trimmed = $this->trimToNull($value);
        if ($trimmed === null) {
            return null;
        }

        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $trimmed);

        return $date ? $date->format('Y-m-d') : null;
    }

    private function numericOrZero(?string $value): float
    {
        if ($value === null || trim($value) === '') {
            return 0.0;
        }

        $normalized = str_replace(',', '.', trim($value));
        if (!is_numeric($normalized)) {
            return 0.0;
        }

        return (float) $normalized;
    }

    private function toDateTime(string $value): ?\DateTimeImmutable
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            return null;
        }

        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $trimmed);
        return $date ?: null;
    }
}
