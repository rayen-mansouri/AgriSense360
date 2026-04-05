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
    public function listEquipments(): array
    {
        $sql = <<<SQL
SELECT
    ID,
    NAME,
    TYPE,
    STATUS,
    TO_CHAR(PURCHASE_DATE, 'YYYY-MM-DD') AS PURCHASE_DATE
FROM EQUIPMENTS
ORDER BY ID DESC
SQL;

        $rows = $this->query($sql, ['ID', 'NAME', 'TYPE', 'STATUS', 'PURCHASE_DATE']);

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['ID'],
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
    public function listMaintenances(): array
    {
        $sql = <<<SQL
SELECT
    m.ID,
    m.EQUIPMENT_ID,
    NVL(e.NAME, '') AS EQUIPMENT_NAME,
    TO_CHAR(m.MAINTENANCE_DATE, 'YYYY-MM-DD') AS MAINTENANCE_DATE,
    m.MAINTENANCE_TYPE,
    TO_CHAR(m.COST) AS COST
FROM MAINTENANCE m
LEFT JOIN EQUIPMENTS e ON e.ID = m.EQUIPMENT_ID
ORDER BY m.ID DESC
SQL;

        $rows = $this->query($sql, ['ID', 'EQUIPMENT_ID', 'EQUIPMENT_NAME', 'MAINTENANCE_DATE', 'MAINTENANCE_TYPE', 'COST']);

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['ID'],
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
    public function findEquipment(int $id): ?array
    {
        $sql = <<<SQL
SELECT
    ID,
    NAME,
    TYPE,
    STATUS,
    TO_CHAR(PURCHASE_DATE, 'YYYY-MM-DD') AS PURCHASE_DATE
FROM EQUIPMENTS
WHERE ID = {$id}
SQL;

        $rows = $this->query($sql, ['ID', 'NAME', 'TYPE', 'STATUS', 'PURCHASE_DATE']);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) $row['ID'],
            'name' => $row['NAME'],
            'type' => $row['TYPE'],
            'status' => $row['STATUS'],
            'purchaseDate' => $this->toDateTime($row['PURCHASE_DATE']),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findMaintenance(int $id): ?array
    {
        $sql = <<<SQL
SELECT
    m.ID,
    m.EQUIPMENT_ID,
    NVL(e.NAME, '') AS EQUIPMENT_NAME,
    TO_CHAR(m.MAINTENANCE_DATE, 'YYYY-MM-DD') AS MAINTENANCE_DATE,
    m.MAINTENANCE_TYPE,
    TO_CHAR(m.COST) AS COST
FROM MAINTENANCE m
LEFT JOIN EQUIPMENTS e ON e.ID = m.EQUIPMENT_ID
WHERE m.ID = {$id}
SQL;

        $rows = $this->query($sql, ['ID', 'EQUIPMENT_ID', 'EQUIPMENT_NAME', 'MAINTENANCE_DATE', 'MAINTENANCE_TYPE', 'COST']);
        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) $row['ID'],
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
    public function createEquipment(array $data): void
    {
        $name = $this->quoteOrNull($data['name']);
        $type = $this->quoteOrNull($data['type']);
        $status = $this->quoteOrNull($data['status']);
        $purchaseDate = $this->toDateExpression($data['purchaseDate']);

        $sql = <<<SQL
INSERT INTO EQUIPMENTS (ID, NAME, TYPE, STATUS, PURCHASE_DATE)
VALUES (EQUIPMENT_SEQ.NEXTVAL, {$name}, {$type}, {$status}, {$purchaseDate})
SQL;

        $this->execute($sql);
    }

    /**
     * @param array{name:?string,type:?string,status:?string,purchaseDate:?string} $data
     */
    public function updateEquipment(int $id, array $data): void
    {
        $name = $this->quoteOrNull($data['name']);
        $type = $this->quoteOrNull($data['type']);
        $status = $this->quoteOrNull($data['status']);
        $purchaseDate = $this->toDateExpression($data['purchaseDate']);

        $sql = <<<SQL
UPDATE EQUIPMENTS
SET NAME = {$name},
    TYPE = {$type},
    STATUS = {$status},
    PURCHASE_DATE = {$purchaseDate}
WHERE ID = {$id}
SQL;

        $this->execute($sql);
    }

    public function deleteEquipment(int $id): void
    {
        $sql = "DELETE FROM EQUIPMENTS WHERE ID = {$id}";
        $this->execute($sql);
    }

    /**
     * @param array{equipmentId:int,maintenanceDate:?string,maintenanceType:?string,cost:?string} $data
     */
    public function createMaintenance(array $data): void
    {
        $equipmentId = (int) $data['equipmentId'];
        $maintenanceDate = $this->toDateExpression($data['maintenanceDate']);
        $maintenanceType = $this->quoteOrNull($data['maintenanceType']);
        $cost = $this->numericOrZero($data['cost']);

        $sql = <<<SQL
INSERT INTO MAINTENANCE (ID, EQUIPMENT_ID, MAINTENANCE_DATE, MAINTENANCE_TYPE, COST)
VALUES (MAINTENANCE_SEQ.NEXTVAL, {$equipmentId}, {$maintenanceDate}, {$maintenanceType}, {$cost})
SQL;

        $this->execute($sql);
    }

    /**
     * @param array{equipmentId:int,maintenanceDate:?string,maintenanceType:?string,cost:?string} $data
     */
    public function updateMaintenance(int $id, array $data): void
    {
        $equipmentId = (int) $data['equipmentId'];
        $maintenanceDate = $this->toDateExpression($data['maintenanceDate']);
        $maintenanceType = $this->quoteOrNull($data['maintenanceType']);
        $cost = $this->numericOrZero($data['cost']);

        $sql = <<<SQL
UPDATE MAINTENANCE
SET EQUIPMENT_ID = {$equipmentId},
    MAINTENANCE_DATE = {$maintenanceDate},
    MAINTENANCE_TYPE = {$maintenanceType},
    COST = {$cost}
WHERE ID = {$id}
SQL;

        $this->execute($sql);
    }

    public function deleteMaintenance(int $id): void
    {
        $sql = "DELETE FROM MAINTENANCE WHERE ID = {$id}";
        $this->execute($sql);
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
