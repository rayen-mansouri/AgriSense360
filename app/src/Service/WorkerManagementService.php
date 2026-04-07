<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class WorkerManagementService
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
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS WORKERS (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                last_name TEXT NOT NULL,
                first_name TEXT NOT NULL,
                role TEXT NOT NULL,
                salary REAL NOT NULL DEFAULT 0,
                availability TEXT NOT NULL DEFAULT "Available",
                FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS WORKER_ASSIGNMENTS (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                worker_id INTEGER NOT NULL,
                task_name TEXT NOT NULL,
                start_date TEXT DEFAULT NULL,
                end_date TEXT DEFAULT NULL,
                FOREIGN KEY (worker_id) REFERENCES WORKERS(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS WORKER_PAYMENTS (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                worker_id INTEGER NOT NULL,
                amount REAL NOT NULL DEFAULT 0,
                payment_date TEXT DEFAULT NULL,
                payment_status TEXT NOT NULL DEFAULT "Pending",
                FOREIGN KEY (worker_id) REFERENCES WORKERS(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
            )');
            $this->schemaInitialized = true;
            return;
        }

        if (str_contains($platform, 'mysql')) {
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS WORKERS (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                last_name VARCHAR(120) NOT NULL,
                first_name VARCHAR(120) NOT NULL,
                role VARCHAR(120) NOT NULL,
                salary DECIMAL(10,2) NOT NULL DEFAULT 0,
                availability VARCHAR(40) NOT NULL DEFAULT "Available",
                CONSTRAINT fk_workers_user FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS WORKER_ASSIGNMENTS (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                worker_id INT NOT NULL,
                task_name VARCHAR(180) NOT NULL,
                start_date DATE NULL,
                end_date DATE NULL,
                CONSTRAINT fk_assignments_user FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE,
                CONSTRAINT fk_assignments_worker FOREIGN KEY (worker_id) REFERENCES WORKERS(id) ON DELETE CASCADE
            )');
            $this->connection->executeStatement('CREATE TABLE IF NOT EXISTS WORKER_PAYMENTS (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                worker_id INT NOT NULL,
                amount DECIMAL(10,2) NOT NULL DEFAULT 0,
                payment_date DATE NULL,
                payment_status VARCHAR(40) NOT NULL DEFAULT "Pending",
                CONSTRAINT fk_payments_user FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE,
                CONSTRAINT fk_payments_worker FOREIGN KEY (worker_id) REFERENCES WORKERS(id) ON DELETE CASCADE
            )');
            $this->schemaInitialized = true;
            return;
        }

        if (str_contains($platform, 'oracle')) {
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE SEQUENCE WORKER_SEQ START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 AND SQLCODE != -2289 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE SEQUENCE WORKER_ASSIGNMENT_SEQ START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 AND SQLCODE != -2289 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE SEQUENCE WORKER_PAYMENT_SEQ START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE';
EXCEPTION
    WHEN OTHERS THEN
        IF SQLCODE != -955 AND SQLCODE != -2289 THEN
            RAISE;
        END IF;
END;
SQL);
            $this->connection->executeStatement(<<<'SQL'
BEGIN
    EXECUTE IMMEDIATE 'CREATE TABLE WORKERS (
        ID NUMBER(10) NOT NULL,
        USER_ID NUMBER(10) NOT NULL,
        LAST_NAME VARCHAR2(120) NOT NULL,
        FIRST_NAME VARCHAR2(120) NOT NULL,
        ROLE VARCHAR2(120) NOT NULL,
        SALARY NUMBER(10,2) DEFAULT 0 NOT NULL,
        AVAILABILITY VARCHAR2(40) DEFAULT ''Available'' NOT NULL,
        CONSTRAINT PK_WORKERS PRIMARY KEY (ID),
        CONSTRAINT FK_WORKERS_USER FOREIGN KEY (USER_ID) REFERENCES USERS(ID) ON DELETE CASCADE
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
    EXECUTE IMMEDIATE 'CREATE TABLE WORKER_ASSIGNMENTS (
        ID NUMBER(10) NOT NULL,
        USER_ID NUMBER(10) NOT NULL,
        WORKER_ID NUMBER(10) NOT NULL,
        TASK_NAME VARCHAR2(180) NOT NULL,
        START_DATE DATE,
        END_DATE DATE,
        CONSTRAINT PK_WORKER_ASSIGNMENTS PRIMARY KEY (ID),
        CONSTRAINT FK_ASSIGNMENTS_USER FOREIGN KEY (USER_ID) REFERENCES USERS(ID) ON DELETE CASCADE,
        CONSTRAINT FK_ASSIGNMENTS_WORKER FOREIGN KEY (WORKER_ID) REFERENCES WORKERS(ID) ON DELETE CASCADE
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
    EXECUTE IMMEDIATE 'CREATE TABLE WORKER_PAYMENTS (
        ID NUMBER(10) NOT NULL,
        USER_ID NUMBER(10) NOT NULL,
        WORKER_ID NUMBER(10) NOT NULL,
        AMOUNT NUMBER(10,2) DEFAULT 0 NOT NULL,
        PAYMENT_DATE DATE,
        PAYMENT_STATUS VARCHAR2(40) DEFAULT ''Pending'' NOT NULL,
        CONSTRAINT PK_WORKER_PAYMENTS PRIMARY KEY (ID),
        CONSTRAINT FK_PAYMENTS_USER FOREIGN KEY (USER_ID) REFERENCES USERS(ID) ON DELETE CASCADE,
        CONSTRAINT FK_PAYMENTS_WORKER FOREIGN KEY (WORKER_ID) REFERENCES WORKERS(ID) ON DELETE CASCADE
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

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listWorkers(int $ownerUserId): array
    {
        $this->ensureSchema();

        $rows = $this->connection->fetchAllAssociative(
            'SELECT id, user_id, last_name, first_name, role, salary, availability FROM WORKERS WHERE user_id = :ownerUserId ORDER BY id DESC',
            ['ownerUserId' => $ownerUserId]
        );

        return array_map(static function (array $row): array {
            return [
                'id' => (int) ($row['id'] ?? 0),
                'userId' => (int) ($row['user_id'] ?? 0),
                'lastName' => (string) ($row['last_name'] ?? ''),
                'firstName' => (string) ($row['first_name'] ?? ''),
                'position' => (string) ($row['role'] ?? ''),
                'salary' => (float) ($row['salary'] ?? 0),
                'availability' => (string) ($row['availability'] ?? 'Available'),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findWorker(int $id, int $ownerUserId): ?array
    {
        $this->ensureSchema();

        $rows = $this->connection->fetchAllAssociative(
            'SELECT id, user_id, last_name, first_name, role, salary, availability FROM WORKERS WHERE id = :id AND user_id = :ownerUserId',
            ['id' => $id, 'ownerUserId' => $ownerUserId]
        );

        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) ($row['id'] ?? 0),
            'userId' => (int) ($row['user_id'] ?? 0),
            'lastName' => (string) ($row['last_name'] ?? ''),
            'firstName' => (string) ($row['first_name'] ?? ''),
            'position' => (string) ($row['role'] ?? ''),
            'salary' => (float) ($row['salary'] ?? 0),
            'availability' => (string) ($row['availability'] ?? 'Available'),
        ];
    }

    /**
     * @param array{lastName:?string,firstName:?string,position:?string,salary:?string,availability:?string} $data
     */
    public function createWorker(array $data, int $ownerUserId): void
    {
        $this->ensureSchema();

        $payload = [
            'user_id' => $ownerUserId,
            'last_name' => $this->trimToNull($data['lastName']) ?? '',
            'first_name' => $this->trimToNull($data['firstName']) ?? '',
            'role' => $this->trimToNull($data['position']) ?? 'Worker',
            'salary' => $this->numericOrZero($data['salary']),
            'availability' => $this->trimToNull($data['availability']) ?? 'Available',
        ];

        if ($this->isOraclePlatform()) {
            $this->connection->executeStatement(
                'INSERT INTO WORKERS (ID, USER_ID, LAST_NAME, FIRST_NAME, ROLE, SALARY, AVAILABILITY) VALUES (WORKER_SEQ.NEXTVAL, :user_id, :last_name, :first_name, :role, :salary, :availability)',
                $payload
            );
            return;
        }

        $this->connection->insert('WORKERS', $payload);
    }

    /**
     * @param array{lastName:?string,firstName:?string,position:?string,salary:?string,availability:?string} $data
     */
    public function updateWorker(int $id, array $data, int $ownerUserId): void
    {
        $this->ensureSchema();

        $this->connection->executeStatement(
            'UPDATE WORKERS SET last_name = :last_name, first_name = :first_name, role = :role, salary = :salary, availability = :availability WHERE id = :id AND user_id = :ownerUserId',
            [
                'last_name' => $this->trimToNull($data['lastName']) ?? '',
                'first_name' => $this->trimToNull($data['firstName']) ?? '',
                'role' => $this->trimToNull($data['position']) ?? 'Worker',
                'salary' => $this->numericOrZero($data['salary']),
                'availability' => $this->trimToNull($data['availability']) ?? 'Available',
                'id' => $id,
                'ownerUserId' => $ownerUserId,
            ]
        );
    }

    public function deleteWorker(int $id, int $ownerUserId): void
    {
        $this->ensureSchema();

        $this->connection->beginTransaction();
        try {
            $params = ['id' => $id, 'ownerUserId' => $ownerUserId];
            $this->connection->executeStatement('DELETE FROM WORKER_ASSIGNMENTS WHERE worker_id = :id AND user_id = :ownerUserId', $params);
            $this->connection->executeStatement('DELETE FROM WORKER_PAYMENTS WHERE worker_id = :id AND user_id = :ownerUserId', $params);
            $this->connection->executeStatement('DELETE FROM WORKERS WHERE id = :id AND user_id = :ownerUserId', $params);
            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();
            throw $e;
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listAssignments(int $ownerUserId): array
    {
        $this->ensureSchema();

        $rows = $this->connection->fetchAllAssociative(
            'SELECT a.id, a.worker_id, a.task_name, a.start_date, a.end_date, w.first_name, w.last_name FROM WORKER_ASSIGNMENTS a LEFT JOIN WORKERS w ON w.id = a.worker_id WHERE a.user_id = :ownerUserId ORDER BY a.id DESC',
            ['ownerUserId' => $ownerUserId]
        );

        return array_map(function (array $row): array {
            return [
                'id' => (int) ($row['id'] ?? 0),
                'workerId' => (int) ($row['worker_id'] ?? 0),
                'workerName' => trim(((string) ($row['first_name'] ?? '')) . ' ' . ((string) ($row['last_name'] ?? ''))),
                'task' => (string) ($row['task_name'] ?? ''),
                'startDate' => $this->toDateTime((string) ($row['start_date'] ?? '')),
                'endDate' => $this->toDateTime((string) ($row['end_date'] ?? '')),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findAssignment(int $id, int $ownerUserId): ?array
    {
        $this->ensureSchema();

        $rows = $this->connection->fetchAllAssociative(
            'SELECT id, worker_id, task_name, start_date, end_date FROM WORKER_ASSIGNMENTS WHERE id = :id AND user_id = :ownerUserId',
            ['id' => $id, 'ownerUserId' => $ownerUserId]
        );

        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) ($row['id'] ?? 0),
            'workerId' => (int) ($row['worker_id'] ?? 0),
            'task' => (string) ($row['task_name'] ?? ''),
            'startDate' => $this->toDateTime((string) ($row['start_date'] ?? '')),
            'endDate' => $this->toDateTime((string) ($row['end_date'] ?? '')),
        ];
    }

    /**
     * @param array{workerId:int,task:?string,startDate:?string,endDate:?string} $data
     */
    public function createAssignment(array $data, int $ownerUserId): void
    {
        $this->ensureSchema();

        $worker = $this->findWorker((int) ($data['workerId'] ?? 0), $ownerUserId);
        if ($worker === null) {
            throw new \RuntimeException('Selected worker does not belong to this user.');
        }

        $payload = [
            'user_id' => $ownerUserId,
            'worker_id' => (int) ($data['workerId'] ?? 0),
            'task_name' => $this->trimToNull($data['task']) ?? 'Task',
            'start_date' => $this->toDateString($data['startDate']),
            'end_date' => $this->toDateString($data['endDate']),
        ];

        if ($this->isOraclePlatform()) {
            $this->connection->executeStatement(
                "INSERT INTO WORKER_ASSIGNMENTS (ID, USER_ID, WORKER_ID, TASK_NAME, START_DATE, END_DATE) VALUES (WORKER_ASSIGNMENT_SEQ.NEXTVAL, :user_id, :worker_id, :task_name, TO_DATE(:start_date, 'YYYY-MM-DD'), TO_DATE(:end_date, 'YYYY-MM-DD'))",
                $payload
            );
            return;
        }

        $this->connection->insert('WORKER_ASSIGNMENTS', $payload);
    }

    /**
     * @param array{workerId:int,task:?string,startDate:?string,endDate:?string} $data
     */
    public function updateAssignment(int $id, array $data, int $ownerUserId): void
    {
        $this->ensureSchema();

        $worker = $this->findWorker((int) ($data['workerId'] ?? 0), $ownerUserId);
        if ($worker === null) {
            throw new \RuntimeException('Selected worker does not belong to this user.');
        }

        $sql = 'UPDATE WORKER_ASSIGNMENTS SET worker_id = :worker_id, task_name = :task_name, start_date = :start_date, end_date = :end_date WHERE id = :id AND user_id = :ownerUserId';
        if ($this->isOraclePlatform()) {
            $sql = "UPDATE WORKER_ASSIGNMENTS SET worker_id = :worker_id, task_name = :task_name, start_date = TO_DATE(:start_date, 'YYYY-MM-DD'), end_date = TO_DATE(:end_date, 'YYYY-MM-DD') WHERE id = :id AND user_id = :ownerUserId";
        }

        $this->connection->executeStatement($sql, [
            'worker_id' => (int) ($data['workerId'] ?? 0),
            'task_name' => $this->trimToNull($data['task']) ?? 'Task',
            'start_date' => $this->toDateString($data['startDate']),
            'end_date' => $this->toDateString($data['endDate']),
            'id' => $id,
            'ownerUserId' => $ownerUserId,
        ]);
    }

    public function deleteAssignment(int $id, int $ownerUserId): void
    {
        $this->ensureSchema();

        $this->connection->executeStatement(
            'DELETE FROM WORKER_ASSIGNMENTS WHERE id = :id AND user_id = :ownerUserId',
            ['id' => $id, 'ownerUserId' => $ownerUserId]
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listPayments(int $ownerUserId): array
    {
        $this->ensureSchema();

        $rows = $this->connection->fetchAllAssociative(
            'SELECT p.id, p.worker_id, p.amount, p.payment_date, p.payment_status, w.first_name, w.last_name FROM WORKER_PAYMENTS p LEFT JOIN WORKERS w ON w.id = p.worker_id WHERE p.user_id = :ownerUserId ORDER BY p.id DESC',
            ['ownerUserId' => $ownerUserId]
        );

        return array_map(function (array $row): array {
            return [
                'id' => (int) ($row['id'] ?? 0),
                'workerId' => (int) ($row['worker_id'] ?? 0),
                'workerName' => trim(((string) ($row['first_name'] ?? '')) . ' ' . ((string) ($row['last_name'] ?? ''))),
                'amount' => (float) ($row['amount'] ?? 0),
                'paymentDate' => $this->toDateTime((string) ($row['payment_date'] ?? '')),
                'status' => (string) ($row['payment_status'] ?? 'Pending'),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findPayment(int $id, int $ownerUserId): ?array
    {
        $this->ensureSchema();

        $rows = $this->connection->fetchAllAssociative(
            'SELECT id, worker_id, amount, payment_date, payment_status FROM WORKER_PAYMENTS WHERE id = :id AND user_id = :ownerUserId',
            ['id' => $id, 'ownerUserId' => $ownerUserId]
        );

        if ($rows === []) {
            return null;
        }

        $row = $rows[0];

        return [
            'id' => (int) ($row['id'] ?? 0),
            'workerId' => (int) ($row['worker_id'] ?? 0),
            'amount' => (float) ($row['amount'] ?? 0),
            'paymentDate' => $this->toDateTime((string) ($row['payment_date'] ?? '')),
            'status' => (string) ($row['payment_status'] ?? 'Pending'),
        ];
    }

    /**
     * @param array{workerId:int,amount:?string,paymentDate:?string,status:?string} $data
     */
    public function createPayment(array $data, int $ownerUserId): void
    {
        $this->ensureSchema();

        $worker = $this->findWorker((int) ($data['workerId'] ?? 0), $ownerUserId);
        if ($worker === null) {
            throw new \RuntimeException('Selected worker does not belong to this user.');
        }

        $payload = [
            'user_id' => $ownerUserId,
            'worker_id' => (int) ($data['workerId'] ?? 0),
            'amount' => $this->numericOrZero($data['amount']),
            'payment_date' => $this->toDateString($data['paymentDate']),
            'payment_status' => $this->trimToNull($data['status']) ?? 'Pending',
        ];

        if ($this->isOraclePlatform()) {
            $this->connection->executeStatement(
                "INSERT INTO WORKER_PAYMENTS (ID, USER_ID, WORKER_ID, AMOUNT, PAYMENT_DATE, PAYMENT_STATUS) VALUES (WORKER_PAYMENT_SEQ.NEXTVAL, :user_id, :worker_id, :amount, TO_DATE(:payment_date, 'YYYY-MM-DD'), :payment_status)",
                $payload
            );
            return;
        }

        $this->connection->insert('WORKER_PAYMENTS', $payload);
    }

    /**
     * @param array{workerId:int,amount:?string,paymentDate:?string,status:?string} $data
     */
    public function updatePayment(int $id, array $data, int $ownerUserId): void
    {
        $this->ensureSchema();

        $worker = $this->findWorker((int) ($data['workerId'] ?? 0), $ownerUserId);
        if ($worker === null) {
            throw new \RuntimeException('Selected worker does not belong to this user.');
        }

        $sql = 'UPDATE WORKER_PAYMENTS SET worker_id = :worker_id, amount = :amount, payment_date = :payment_date, payment_status = :payment_status WHERE id = :id AND user_id = :ownerUserId';
        if ($this->isOraclePlatform()) {
            $sql = "UPDATE WORKER_PAYMENTS SET worker_id = :worker_id, amount = :amount, payment_date = TO_DATE(:payment_date, 'YYYY-MM-DD'), payment_status = :payment_status WHERE id = :id AND user_id = :ownerUserId";
        }

        $this->connection->executeStatement($sql, [
            'worker_id' => (int) ($data['workerId'] ?? 0),
            'amount' => $this->numericOrZero($data['amount']),
            'payment_date' => $this->toDateString($data['paymentDate']),
            'payment_status' => $this->trimToNull($data['status']) ?? 'Pending',
            'id' => $id,
            'ownerUserId' => $ownerUserId,
        ]);
    }

    public function deletePayment(int $id, int $ownerUserId): void
    {
        $this->ensureSchema();

        $this->connection->executeStatement(
            'DELETE FROM WORKER_PAYMENTS WHERE id = :id AND user_id = :ownerUserId',
            ['id' => $id, 'ownerUserId' => $ownerUserId]
        );
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
