<?php

namespace App\Service;

class OracleSqlPlusCrudService
{
    private string $connectionString;

    public function __construct(string $databaseUrl)
    {
        $this->connectionString = $this->buildConnectionString($databaseUrl);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listEquipments(?int $ownerUserId = null): array
    {
        $whereClause = '';
        if ($ownerUserId !== null) {
            $whereClause = 'WHERE USER_ID = ' . (int) $ownerUserId;
        }

        $sql = <<<SQL
SELECT
    ID,
    USER_ID,
    NAME,
    TYPE,
    STATUS,
    TO_CHAR(PURCHASE_DATE, 'YYYY-MM-DD') AS PURCHASE_DATE
FROM EQUIPMENTS
{$whereClause}
ORDER BY ID DESC
SQL;

        $rows = $this->query($sql, ['ID', 'USER_ID', 'NAME', 'TYPE', 'STATUS', 'PURCHASE_DATE']);

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['ID'],
                'userId' => (int) $row['USER_ID'],
                'name' => $row['NAME'],
                'type' => $row['TYPE'],
                'status' => $row['STATUS'],
                'purchaseDate' => $this->toDateTime($row['PURCHASE_DATE']),
            ];
        }, $rows);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listMaintenances(?int $ownerUserId = null): array
    {
        $whereClause = '';
        if ($ownerUserId !== null) {
            $whereClause = 'WHERE m.USER_ID = ' . (int) $ownerUserId;
        }

        $sql = <<<SQL
SELECT
    m.ID,
    m.USER_ID,
    m.EQUIPMENT_ID,
    NVL(e.NAME, '') AS EQUIPMENT_NAME,
    TO_CHAR(m.MAINTENANCE_DATE, 'YYYY-MM-DD') AS MAINTENANCE_DATE,
    m.MAINTENANCE_TYPE,
    TO_CHAR(m.COST) AS COST
FROM MAINTENANCE m
LEFT JOIN EQUIPMENTS e ON e.ID = m.EQUIPMENT_ID
{$whereClause}
ORDER BY m.ID DESC
SQL;

        $rows = $this->query($sql, ['ID', 'USER_ID', 'EQUIPMENT_ID', 'EQUIPMENT_NAME', 'MAINTENANCE_DATE', 'MAINTENANCE_TYPE', 'COST']);

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['ID'],
                'userId' => (int) $row['USER_ID'],
                'equipment' => [
                    'id' => (int) $row['EQUIPMENT_ID'],
                    'name' => $row['EQUIPMENT_NAME'],
                ],
                'maintenanceDate' => $this->toDateTime($row['MAINTENANCE_DATE']),
                'maintenanceType' => $row['MAINTENANCE_TYPE'],
                'cost' => $row['COST'],
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findEquipment(int $id, ?int $ownerUserId = null): ?array
    {
        $ownerCondition = $ownerUserId !== null ? ' AND USER_ID = ' . (int) $ownerUserId : '';

        $sql = <<<SQL
SELECT
    ID,
    USER_ID,
    NAME,
    TYPE,
    STATUS,
    TO_CHAR(PURCHASE_DATE, 'YYYY-MM-DD') AS PURCHASE_DATE
FROM EQUIPMENTS
WHERE ID = {$id}{$ownerCondition}
SQL;

        $rows = $this->query($sql, ['ID', 'USER_ID', 'NAME', 'TYPE', 'STATUS', 'PURCHASE_DATE']);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) $row['ID'],
            'userId' => (int) $row['USER_ID'],
            'name' => $row['NAME'],
            'type' => $row['TYPE'],
            'status' => $row['STATUS'],
            'purchaseDate' => $this->toDateTime($row['PURCHASE_DATE']),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findMaintenance(int $id, ?int $ownerUserId = null): ?array
    {
        $ownerCondition = $ownerUserId !== null ? ' AND m.USER_ID = ' . (int) $ownerUserId : '';

        $sql = <<<SQL
SELECT
    m.ID,
    m.USER_ID,
    m.EQUIPMENT_ID,
    NVL(e.NAME, '') AS EQUIPMENT_NAME,
    TO_CHAR(m.MAINTENANCE_DATE, 'YYYY-MM-DD') AS MAINTENANCE_DATE,
    m.MAINTENANCE_TYPE,
    TO_CHAR(m.COST) AS COST
FROM MAINTENANCE m
LEFT JOIN EQUIPMENTS e ON e.ID = m.EQUIPMENT_ID
WHERE m.ID = {$id}{$ownerCondition}
SQL;

        $rows = $this->query($sql, ['ID', 'USER_ID', 'EQUIPMENT_ID', 'EQUIPMENT_NAME', 'MAINTENANCE_DATE', 'MAINTENANCE_TYPE', 'COST']);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) $row['ID'],
            'userId' => (int) $row['USER_ID'],
            'equipment' => [
                'id' => (int) $row['EQUIPMENT_ID'],
                'name' => $row['EQUIPMENT_NAME'],
            ],
            'maintenanceDate' => $this->toDateTime($row['MAINTENANCE_DATE']),
            'maintenanceType' => $row['MAINTENANCE_TYPE'],
            'cost' => $row['COST'],
        ];
    }

    /**
     * @param array{name:?string,type:?string,status:?string,purchaseDate:?string} $data
     */
    public function createEquipment(array $data, int $ownerUserId): void
    {
        $name = $this->quoteOrNull($data['name']);
        $type = $this->quoteOrNull($data['type']);
        $status = $this->quoteOrNull($data['status']);
        $purchaseDate = $this->toDateExpression($data['purchaseDate']);
        $safeOwnerId = (int) $ownerUserId;

        $sql = <<<SQL
INSERT INTO EQUIPMENTS (ID, USER_ID, NAME, TYPE, STATUS, PURCHASE_DATE)
VALUES (EQUIPMENT_SEQ.NEXTVAL, {$safeOwnerId}, {$name}, {$type}, {$status}, {$purchaseDate})
SQL;

        $this->execute($sql);
    }

    /**
     * @param array{name:?string,type:?string,status:?string,purchaseDate:?string} $data
     */
    public function updateEquipment(int $id, array $data, ?int $ownerUserId = null): void
    {
        $name = $this->quoteOrNull($data['name']);
        $type = $this->quoteOrNull($data['type']);
        $status = $this->quoteOrNull($data['status']);
        $purchaseDate = $this->toDateExpression($data['purchaseDate']);
        $ownerCondition = $ownerUserId !== null ? ' AND USER_ID = ' . (int) $ownerUserId : '';

        $sql = <<<SQL
UPDATE EQUIPMENTS
SET NAME = {$name},
    TYPE = {$type},
    STATUS = {$status},
    PURCHASE_DATE = {$purchaseDate}
WHERE ID = {$id}{$ownerCondition}
SQL;

        $this->execute($sql);
    }

    public function deleteEquipment(int $id, ?int $ownerUserId = null): void
    {
        $ownerCondition = $ownerUserId !== null ? ' AND USER_ID = ' . (int) $ownerUserId : '';
        // Keep user/admin behavior consistent by removing dependent maintenance rows first.
        $this->execute("DELETE FROM MAINTENANCE WHERE EQUIPMENT_ID = {$id}{$ownerCondition}");
        $this->execute("DELETE FROM EQUIPMENTS WHERE ID = {$id}{$ownerCondition}");
    }

    /**
     * @param array{equipmentId:int,maintenanceDate:?string,maintenanceType:?string,cost:?string} $data
     */
    public function createMaintenance(array $data, int $ownerUserId): void
    {
        $equipmentId = (int) $data['equipmentId'];
        $maintenanceDate = $this->toDateExpression($data['maintenanceDate']);
        $maintenanceType = $this->quoteOrNull($data['maintenanceType']);
        $cost = $this->numericOrZero($data['cost']);
        $safeOwnerId = (int) $ownerUserId;

        $ownedEquipment = $this->findEquipment($equipmentId, $safeOwnerId);
        if ($ownedEquipment === null) {
            throw new \RuntimeException('Selected equipment does not belong to this user.');
        }

        $sql = <<<SQL
INSERT INTO MAINTENANCE (ID, USER_ID, EQUIPMENT_ID, MAINTENANCE_DATE, MAINTENANCE_TYPE, COST)
VALUES (MAINTENANCE_SEQ.NEXTVAL, {$safeOwnerId}, {$equipmentId}, {$maintenanceDate}, {$maintenanceType}, {$cost})
SQL;

        $this->execute($sql);
    }

    /**
     * @param array{equipmentId:int,maintenanceDate:?string,maintenanceType:?string,cost:?string} $data
     */
    public function updateMaintenance(int $id, array $data, ?int $ownerUserId = null): void
    {
        $equipmentId = (int) $data['equipmentId'];
        $maintenanceDate = $this->toDateExpression($data['maintenanceDate']);
        $maintenanceType = $this->quoteOrNull($data['maintenanceType']);
        $cost = $this->numericOrZero($data['cost']);
        $ownerCondition = $ownerUserId !== null ? ' AND USER_ID = ' . (int) $ownerUserId : '';

        $sql = <<<SQL
UPDATE MAINTENANCE
SET EQUIPMENT_ID = {$equipmentId},
    MAINTENANCE_DATE = {$maintenanceDate},
    MAINTENANCE_TYPE = {$maintenanceType},
    COST = {$cost}
WHERE ID = {$id}{$ownerCondition}
SQL;

        $this->execute($sql);
    }

    public function deleteMaintenance(int $id, ?int $ownerUserId = null): void
    {
        $ownerCondition = $ownerUserId !== null ? ' AND USER_ID = ' . (int) $ownerUserId : '';
        $sql = "DELETE FROM MAINTENANCE WHERE ID = {$id}{$ownerCondition}";
        $this->execute($sql);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listUsers(): array
    {
        $sql = <<<SQL
SELECT
    ID,
    LAST_NAME,
    FIRST_NAME,
    EMAIL,
    PASSWORD_HASH,
    STATUS,
    ROLE_NAME,
    TO_CHAR(CREATED_AT, 'YYYY-MM-DD') AS CREATED_AT
FROM USERS
ORDER BY ID DESC
SQL;

        $rows = $this->query($sql, ['ID', 'LAST_NAME', 'FIRST_NAME', 'EMAIL', 'PASSWORD_HASH', 'STATUS', 'ROLE_NAME', 'CREATED_AT']);

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['ID'],
                'lastName' => $row['LAST_NAME'],
                'firstName' => $row['FIRST_NAME'],
                'email' => $row['EMAIL'],
                'passwordHash' => $row['PASSWORD_HASH'],
                'status' => $row['STATUS'],
                'roleName' => $row['ROLE_NAME'],
                'createdAt' => $this->toDateTime($row['CREATED_AT']),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findUser(int $id): ?array
    {
        $sql = <<<SQL
SELECT
    ID,
    LAST_NAME,
    FIRST_NAME,
    EMAIL,
    PASSWORD_HASH,
    STATUS,
    ROLE_NAME,
    TO_CHAR(CREATED_AT, 'YYYY-MM-DD') AS CREATED_AT
FROM USERS
WHERE ID = {$id}
SQL;

        $rows = $this->query($sql, ['ID', 'LAST_NAME', 'FIRST_NAME', 'EMAIL', 'PASSWORD_HASH', 'STATUS', 'ROLE_NAME', 'CREATED_AT']);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) $row['ID'],
            'lastName' => $row['LAST_NAME'],
            'firstName' => $row['FIRST_NAME'],
            'email' => $row['EMAIL'],
            'passwordHash' => $row['PASSWORD_HASH'],
            'status' => $row['STATUS'],
            'roleName' => $row['ROLE_NAME'],
            'createdAt' => $this->toDateTime($row['CREATED_AT']),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findUserByEmail(string $email): ?array
    {
        $emailExpr = $this->quoteOrNull($email);
        $sql = <<<SQL
SELECT
    ID,
    LAST_NAME,
    FIRST_NAME,
    EMAIL,
    PASSWORD_HASH,
    STATUS,
    ROLE_NAME,
    TO_CHAR(CREATED_AT, 'YYYY-MM-DD') AS CREATED_AT
FROM USERS
WHERE LOWER(EMAIL) = LOWER({$emailExpr})
SQL;

        $rows = $this->query($sql, ['ID', 'LAST_NAME', 'FIRST_NAME', 'EMAIL', 'PASSWORD_HASH', 'STATUS', 'ROLE_NAME', 'CREATED_AT']);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) $row['ID'],
            'lastName' => $row['LAST_NAME'],
            'firstName' => $row['FIRST_NAME'],
            'email' => $row['EMAIL'],
            'passwordHash' => $row['PASSWORD_HASH'],
            'status' => $row['STATUS'],
            'roleName' => $row['ROLE_NAME'],
            'createdAt' => $this->toDateTime($row['CREATED_AT']),
        ];
    }

    /**
     * @param array{lastName:?string,firstName:?string,email:?string,passwordHash:?string,status:?string,roleName:?string} $data
     */
    public function createUser(array $data): void
    {
        $lastName = $this->quoteOrNull($data['lastName']);
        $firstName = $this->quoteOrNull($data['firstName']);
        $email = $this->quoteOrNull($data['email']);
        $passwordHash = $this->quoteOrNull($data['passwordHash']);
        $status = $this->quoteOrNull($data['status']);
        $roleName = $this->quoteOrNull($data['roleName']);

        $sql = <<<SQL
INSERT INTO USERS (ID, LAST_NAME, FIRST_NAME, EMAIL, PASSWORD_HASH, STATUS, ROLE_NAME, CREATED_AT)
VALUES (USER_SEQ.NEXTVAL, {$lastName}, {$firstName}, {$email}, {$passwordHash}, {$status}, {$roleName}, SYSDATE)
SQL;

        $this->execute($sql);
    }

    /**
     * @param array{lastName:?string,firstName:?string,email:?string,passwordHash:?string,status:?string,roleName:?string} $data
     */
    public function updateUser(int $id, array $data): void
    {
        $lastName = $this->quoteOrNull($data['lastName']);
        $firstName = $this->quoteOrNull($data['firstName']);
        $email = $this->quoteOrNull($data['email']);
        $status = $this->quoteOrNull($data['status']);
        $roleName = $this->quoteOrNull($data['roleName']);

        $setClauses = [
            "LAST_NAME = {$lastName}",
            "FIRST_NAME = {$firstName}",
            "EMAIL = {$email}",
            "STATUS = {$status}",
            "ROLE_NAME = {$roleName}",
        ];

        if (($data['passwordHash'] ?? null) !== null && trim((string) $data['passwordHash']) !== '') {
            $setClauses[] = 'PASSWORD_HASH = ' . $this->quoteOrNull($data['passwordHash']);
        }

        $sql = "UPDATE USERS SET " . implode(', ', $setClauses) . " WHERE ID = {$id}";
        $this->execute($sql);
    }

    public function deleteUser(int $id): void
    {
        $this->execute("DELETE FROM USERS WHERE ID = {$id}");
    }

    // ======================== AFFECTATION_TRAVAIL CRUD METHODS ========================

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listAffectations(): array
    {
        $sql = <<<SQL
SELECT
    ID_AFFECTATION,
    TYPE_TRAVAIL,
    TO_CHAR(DATE_DEBUT, 'YYYY-MM-DD') AS DATE_DEBUT,
    TO_CHAR(DATE_FIN, 'YYYY-MM-DD') AS DATE_FIN,
    ZONE_TRAVAIL,
    STATUT
FROM AFFECTATION_TRAVAIL
ORDER BY ID_AFFECTATION DESC
SQL;

        $rows = $this->query($sql, ['ID_AFFECTATION', 'TYPE_TRAVAIL', 'DATE_DEBUT', 'DATE_FIN', 'ZONE_TRAVAIL', 'STATUT']);

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['ID_AFFECTATION'],
                'typeTravail' => $row['TYPE_TRAVAIL'],
                'dateDebut' => $this->toDateTime($row['DATE_DEBUT']),
                'dateFin' => $this->toDateTime($row['DATE_FIN']),
                'zoneTravail' => $row['ZONE_TRAVAIL'],
                'statut' => $row['STATUT'],
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findAffectation(int $id): ?array
    {
        $sql = <<<SQL
SELECT
    ID_AFFECTATION,
    TYPE_TRAVAIL,
    TO_CHAR(DATE_DEBUT, 'YYYY-MM-DD') AS DATE_DEBUT,
    TO_CHAR(DATE_FIN, 'YYYY-MM-DD') AS DATE_FIN,
    ZONE_TRAVAIL,
    STATUT
FROM AFFECTATION_TRAVAIL
WHERE ID_AFFECTATION = {$id}
SQL;

        $rows = $this->query($sql, ['ID_AFFECTATION', 'TYPE_TRAVAIL', 'DATE_DEBUT', 'DATE_FIN', 'ZONE_TRAVAIL', 'STATUT']);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) $row['ID_AFFECTATION'],
            'typeTravail' => $row['TYPE_TRAVAIL'],
            'dateDebut' => $this->toDateTime($row['DATE_DEBUT']),
            'dateFin' => $this->toDateTime($row['DATE_FIN']),
            'zoneTravail' => $row['ZONE_TRAVAIL'],
            'statut' => $row['STATUT'],
        ];
    }

    /**
     * @param array{typeTravail:?string,dateDebut:?string,dateFin:?string,zoneTravail:?string,statut:?string} $data
     */
    public function createAffectation(array $data): void
    {
        $typeTravail = $this->quoteOrNull($data['typeTravail']);
        $dateDebut = $this->toDateExpression($data['dateDebut']);
        $dateFin = $this->toDateExpression($data['dateFin']);
        $zoneTravail = $this->quoteOrNull($data['zoneTravail']);
        $statut = $this->quoteOrNull($data['statut']);

        $sql = <<<SQL
INSERT INTO AFFECTATION_TRAVAIL (ID_AFFECTATION, TYPE_TRAVAIL, DATE_DEBUT, DATE_FIN, ZONE_TRAVAIL, STATUT)
VALUES (AFFECTATION_TRAVAIL_SEQ.NEXTVAL, {$typeTravail}, {$dateDebut}, {$dateFin}, {$zoneTravail}, {$statut})
SQL;

        $this->execute($sql);
    }

    /**
     * @param array{typeTravail:?string,dateDebut:?string,dateFin:?string,zoneTravail:?string,statut:?string} $data
     */
    public function updateAffectation(int $id, array $data): void
    {
        $typeTravail = $this->quoteOrNull($data['typeTravail']);
        $dateDebut = $this->toDateExpression($data['dateDebut']);
        $dateFin = $this->toDateExpression($data['dateFin']);
        $zoneTravail = $this->quoteOrNull($data['zoneTravail']);
        $statut = $this->quoteOrNull($data['statut']);

        $sql = <<<SQL
UPDATE AFFECTATION_TRAVAIL
SET TYPE_TRAVAIL = {$typeTravail},
    DATE_DEBUT = {$dateDebut},
    DATE_FIN = {$dateFin},
    ZONE_TRAVAIL = {$zoneTravail},
    STATUT = {$statut}
WHERE ID_AFFECTATION = {$id}
SQL;

        $this->execute($sql);
    }

    public function deleteAffectation(int $id): void
    {
        // Delete evaluations first (ON DELETE CASCADE would handle this in DB)
        $this->execute("DELETE FROM EVALUATION_PERFORMANCE WHERE ID_AFFECTATION = {$id}");
        $this->execute("DELETE FROM AFFECTATION_TRAVAIL WHERE ID_AFFECTATION = {$id}");
    }

    // ======================== EVALUATION_PERFORMANCE CRUD METHODS ========================

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listEvaluations(?int $affectationId = null): array
    {
        $whereClause = '';
        if ($affectationId !== null) {
            $whereClause = 'WHERE ID_AFFECTATION = ' . (int) $affectationId;
        }

        $sql = <<<SQL
SELECT
    ID_EVALUATION,
    ID_AFFECTATION,
    NOTE,
    QUALITE,
    COMMENTAIRE,
    TO_CHAR(DATE_EVALUATION, 'YYYY-MM-DD') AS DATE_EVALUATION
FROM EVALUATION_PERFORMANCE
{$whereClause}
ORDER BY ID_EVALUATION DESC
SQL;

        $rows = $this->query($sql, ['ID_EVALUATION', 'ID_AFFECTATION', 'NOTE', 'QUALITE', 'COMMENTAIRE', 'DATE_EVALUATION']);

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['ID_EVALUATION'],
                'affectationId' => (int) $row['ID_AFFECTATION'],
                'note' => (int) $row['NOTE'],
                'qualite' => $row['QUALITE'],
                'commentaire' => $row['COMMENTAIRE'],
                'dateEvaluation' => $this->toDateTime($row['DATE_EVALUATION']),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findEvaluation(int $id): ?array
    {
        $sql = <<<SQL
SELECT
    ID_EVALUATION,
    ID_AFFECTATION,
    NOTE,
    QUALITE,
    COMMENTAIRE,
    TO_CHAR(DATE_EVALUATION, 'YYYY-MM-DD') AS DATE_EVALUATION
FROM EVALUATION_PERFORMANCE
WHERE ID_EVALUATION = {$id}
SQL;

        $rows = $this->query($sql, ['ID_EVALUATION', 'ID_AFFECTATION', 'NOTE', 'QUALITE', 'COMMENTAIRE', 'DATE_EVALUATION']);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) $row['ID_EVALUATION'],
            'affectationId' => (int) $row['ID_AFFECTATION'],
            'note' => (int) $row['NOTE'],
            'qualite' => $row['QUALITE'],
            'commentaire' => $row['COMMENTAIRE'],
            'dateEvaluation' => $this->toDateTime($row['DATE_EVALUATION']),
        ];
    }

    /**
     * @param array{affectationId:int,note:?string,qualite:?string,commentaire:?string,dateEvaluation:?string} $data
     */
    public function createEvaluation(array $data): void
    {
        $affectationId = (int) $data['affectationId'];
        $note = $this->numericOrZero($data['note']);
        $qualite = $this->quoteOrNull($data['qualite']);
        $commentaire = $this->quoteOrNull($data['commentaire']);
        $dateEvaluation = $this->toDateExpression($data['dateEvaluation']);

        // Verify affectation exists
        $affectation = $this->findAffectation($affectationId);
        if ($affectation === null) {
            throw new \RuntimeException('Selected affectation does not exist.');
        }

        $sql = <<<SQL
INSERT INTO EVALUATION_PERFORMANCE (ID_EVALUATION, ID_AFFECTATION, NOTE, QUALITE, COMMENTAIRE, DATE_EVALUATION)
VALUES (EVALUATION_PERFORMANCE_SEQ.NEXTVAL, {$affectationId}, {$note}, {$qualite}, {$commentaire}, {$dateEvaluation})
SQL;

        $this->execute($sql);
    }

    /**
     * @param array{affectationId:int,note:?string,qualite:?string,commentaire:?string,dateEvaluation:?string} $data
     */
    public function updateEvaluation(int $id, array $data): void
    {
        $affectationId = (int) $data['affectationId'];
        $note = $this->numericOrZero($data['note']);
        $qualite = $this->quoteOrNull($data['qualite']);
        $commentaire = $this->quoteOrNull($data['commentaire']);
        $dateEvaluation = $this->toDateExpression($data['dateEvaluation']);

        $sql = <<<SQL
UPDATE EVALUATION_PERFORMANCE
SET ID_AFFECTATION = {$affectationId},
    NOTE = {$note},
    QUALITE = {$qualite},
    COMMENTAIRE = {$commentaire},
    DATE_EVALUATION = {$dateEvaluation}
WHERE ID_EVALUATION = {$id}
SQL;

        $this->execute($sql);
    }

    public function deleteEvaluation(int $id): void
    {
        $this->execute("DELETE FROM EVALUATION_PERFORMANCE WHERE ID_EVALUATION = {$id}");
    }

    private function buildConnectionString(string $databaseUrl): string
    {
        $parts = parse_url($databaseUrl);
        if ($parts === false) {
            throw new \RuntimeException('Invalid DATABASE_URL format.');
        }

        $user = $parts['user'] ?? null;
        $pass = $parts['pass'] ?? null;
        $host = $parts['host'] ?? 'localhost';
        $port = $parts['port'] ?? 1521;
        $query = [];

        parse_str($parts['query'] ?? '', $query);
        $serviceName = $query['service_name'] ?? 'XE';

        if (!$user || $pass === null) {
            throw new \RuntimeException('DATABASE_URL must contain Oracle user and password.');
        }

        return sprintf('%s/%s@//%s:%d/%s', $user, $pass, $host, $port, $serviceName);
    }

    /**
     * @param list<string> $columns
     * @return array<int, array<string, string>>
     */
    private function query(string $sql, array $columns): array
    {
        $script = <<<SQL
SET PAGESIZE 50000
SET LINESIZE 32767
SET FEEDBACK OFF
SET HEADING OFF
SET VERIFY OFF
SET ECHO OFF
SET TERMOUT ON
SET TRIMSPOOL ON
SET TAB OFF
SET COLSEP '||'
ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD';
{$sql};
EXIT;
SQL;

        $output = $this->runSqlPlusScript($script);
        $lines = preg_split('/\r\n|\r|\n/', $output) ?: [];
        $rows = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || str_starts_with($trimmed, 'ALTER SESSION')) {
                continue;
            }

            $parts = array_map('trim', explode('||', $line));
            if (count($parts) < count($columns)) {
                continue;
            }

            $row = [];
            foreach ($columns as $index => $column) {
                $row[$column] = $parts[$index] ?? '';
            }

            $rows[] = $row;
        }

        return $rows;
    }

    private function execute(string $sql): void
    {
        $script = <<<SQL
WHENEVER SQLERROR EXIT SQL.SQLCODE
SET FEEDBACK OFF
SET HEADING OFF
SET VERIFY OFF
SET ECHO OFF
ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD';
{$sql};
COMMIT;
EXIT;
SQL;

        $this->runSqlPlusScript($script);
    }

    private function runSqlPlusScript(string $script): string
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'agrisense_sql_');
        if ($tmpFile === false) {
            throw new \RuntimeException('Unable to create temporary SQL file.');
        }

        try {
            file_put_contents($tmpFile, $script);
            $command = ['sqlplus', '-S', $this->connectionString, '@' . $tmpFile];
            $descriptors = [
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ];

            $process = proc_open(
                $command,
                $descriptors,
                $pipes,
                null,
                null,
                ['bypass_shell' => true]
            );

            if (!is_resource($process)) {
                throw new \RuntimeException('SQL*Plus execution failed to start.');
            }

            $stdout = stream_get_contents($pipes[1]);
            $stderr = stream_get_contents($pipes[2]);

            fclose($pipes[1]);
            fclose($pipes[2]);

            $exitCode = proc_close($process);
            $output = trim((string) $stdout . PHP_EOL . (string) $stderr);

            if ($exitCode !== 0 && $output === '') {
                throw new \RuntimeException('SQL*Plus execution failed.');
            }

            if (stripos($output, 'ORA-') !== false || stripos($output, 'SP2-') !== false) {
                throw new \RuntimeException(trim($output));
            }

            return $output;
        } finally {
            if (is_file($tmpFile)) {
                @unlink($tmpFile);
            }
        }
    }

    private function quoteOrNull(?string $value): string
    {
        if ($value === null || trim($value) === '') {
            return 'NULL';
        }

        return "'" . str_replace("'", "''", trim($value)) . "'";
    }

    private function toDateExpression(?string $value): string
    {
        if ($value === null || trim($value) === '') {
            return 'NULL';
        }

        $date = trim($value);
        return "TO_DATE('" . str_replace("'", "''", $date) . "', 'YYYY-MM-DD')";
    }

    private function numericOrZero(?string $value): string
    {
        if ($value === null || trim($value) === '') {
            return '0';
        }

        $normalized = str_replace(',', '.', trim($value));
        if (!is_numeric($normalized)) {
            return '0';
        }

        return $normalized;
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
