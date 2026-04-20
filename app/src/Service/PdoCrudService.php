<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class PdoCrudService
{
    public function __construct(private Connection $connection)
    {
    }

    // ======================== USER METHODS ========================

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listUsers(): array
    {
        $sql = 'SELECT id, last_name, first_name, email, password_hash, status, role_name, created_at FROM users ORDER BY id DESC';
        $stmt = $this->connection->executeQuery($sql);
        $rows = $stmt->fetchAllAssociative();

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['id'],
                'lastName' => $row['last_name'],
                'firstName' => $row['first_name'],
                'email' => $row['email'],
                'passwordHash' => $row['password_hash'],
                'status' => $row['status'],
                'roleName' => $row['role_name'],
                'createdAt' => $this->toDateTime($row['created_at']),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findUser(int $id): ?array
    {
        $sql = 'SELECT id, last_name, first_name, email, password_hash, status, role_name, created_at FROM users WHERE id = ?';
        $stmt = $this->connection->executeQuery($sql, [$id]);
        $row = $stmt->fetchAssociative();

        if (!$row) {
            return null;
        }

        return [
            'id' => (int) $row['id'],
            'lastName' => $row['last_name'],
            'firstName' => $row['first_name'],
            'email' => $row['email'],
            'passwordHash' => $row['password_hash'],
            'status' => $row['status'],
            'roleName' => $row['role_name'],
            'createdAt' => $this->toDateTime($row['created_at']),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findUserByEmail(string $email): ?array
    {
        $sql = 'SELECT id, last_name, first_name, email, password_hash, status, role_name, created_at FROM users WHERE LOWER(email) = LOWER(?)';
        $stmt = $this->connection->executeQuery($sql, [$email]);
        $row = $stmt->fetchAssociative();

        if (!$row) {
            return null;
        }

        return [
            'id' => (int) $row['id'],
            'lastName' => $row['last_name'],
            'firstName' => $row['first_name'],
            'email' => $row['email'],
            'passwordHash' => $row['password_hash'],
            'status' => $row['status'],
            'roleName' => $row['role_name'],
            'createdAt' => $this->toDateTime($row['created_at']),
        ];
    }

    /**
     * @param array{lastName:?string,firstName:?string,email:?string,passwordHash:?string,status:?string,roleName:?string} $data
     */
    public function createUser(array $data): void
    {
        $sql = 'INSERT INTO users (last_name, first_name, email, password_hash, status, role_name, created_at) VALUES (?, ?, ?, ?, ?, ?, CURRENT_DATE)';
        $this->connection->executeStatement($sql, [
            $data['lastName'],
            $data['firstName'],
            $data['email'],
            $data['passwordHash'],
            $data['status'],
            $data['roleName'],
        ]);
    }

    /**
     * @param array{lastName:?string,firstName:?string,email:?string,passwordHash:?string,status:?string,roleName:?string} $data
     */
    public function updateUser(int $id, array $data): void
    {
        $setClauses = [
            'last_name = ?',
            'first_name = ?',
            'email = ?',
            'status = ?',
            'role_name = ?',
        ];
        $params = [
            $data['lastName'],
            $data['firstName'],
            $data['email'],
            $data['status'],
            $data['roleName'],
        ];

        if (($data['passwordHash'] ?? null) !== null && trim((string) $data['passwordHash']) !== '') {
            $setClauses[] = 'password_hash = ?';
            $params[] = $data['passwordHash'];
        }

        $params[] = $id;
        $sql = 'UPDATE users SET ' . implode(', ', $setClauses) . ' WHERE id = ?';
        $this->connection->executeStatement($sql, $params);
    }

    public function deleteUser(int $id): void
    {
        $this->connection->executeStatement('DELETE FROM users WHERE id = ?', [$id]);
    }

    // ======================== EQUIPMENT METHODS ========================

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listEquipments(?int $ownerUserId = null): array
    {
        $baseSQL = 'SELECT id, user_id, name, type, status, purchase_date FROM equipments';
        $params = [];

        if ($ownerUserId !== null) {
            $baseSQL .= ' WHERE user_id = ?';
            $params[] = $ownerUserId;
        }

        $baseSQL .= ' ORDER BY id DESC';
        $stmt = $this->connection->executeQuery($baseSQL, $params);
        $rows = $stmt->fetchAllAssociative();

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['id'],
                'userId' => (int) $row['user_id'],
                'name' => $row['name'],
                'type' => $row['type'],
                'status' => $row['status'],
                'purchaseDate' => $this->toDateTime($row['purchase_date']),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findEquipment(int $id, ?int $ownerUserId = null): ?array
    {
        $sql = 'SELECT id, user_id, name, type, status, purchase_date FROM equipments WHERE id = ?';
        $params = [$id];

        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = ?';
            $params[] = $ownerUserId;
        }

        $stmt = $this->connection->executeQuery($sql, $params);
        $row = $stmt->fetchAssociative();

        if (!$row) {
            return null;
        }

        return [
            'id' => (int) $row['id'],
            'userId' => (int) $row['user_id'],
            'name' => $row['name'],
            'type' => $row['type'],
            'status' => $row['status'],
            'purchaseDate' => $this->toDateTime($row['purchase_date']),
        ];
    }

    /**
     * @param array{name:?string,type:?string,status:?string,purchaseDate:?string} $data
     */
    public function createEquipment(array $data, int $ownerUserId): void
    {
        $sql = 'INSERT INTO equipments (user_id, name, type, status, purchase_date) VALUES (?, ?, ?, ?, ?)';
        $this->connection->executeStatement($sql, [
            $ownerUserId,
            $data['name'],
            $data['type'],
            $data['status'],
            $data['purchaseDate'],
        ]);
    }

    /**
     * @param array{name:?string,type:?string,status:?string,purchaseDate:?string} $data
     */
    public function updateEquipment(int $id, array $data, ?int $ownerUserId = null): void
    {
        $params = [
            $data['name'],
            $data['type'],
            $data['status'],
            $data['purchaseDate'],
            $id,
        ];

        $sql = 'UPDATE equipments SET name = ?, type = ?, status = ?, purchase_date = ? WHERE id = ?';

        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = ?';
            $params[] = $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
    }

    public function deleteEquipment(int $id, ?int $ownerUserId = null): void
    {
        $params = [$id];
        $sql = 'DELETE FROM maintenance WHERE equipment_id = ?';

        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = ?';
            $params[] = $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);

        $params = [$id];
        $sql = 'DELETE FROM equipments WHERE id = ?';

        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = ?';
            $params[] = $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
    }

    // ======================== MAINTENANCE METHODS ========================

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listMaintenances(?int $ownerUserId = null): array
    {
        $baseSQL = 'SELECT m.id, m.user_id, m.equipment_id, e.name as equipment_name, m.maintenance_date, m.maintenance_type, m.cost FROM maintenance m LEFT JOIN equipments e ON e.id = m.equipment_id';
        $params = [];

        if ($ownerUserId !== null) {
            $baseSQL .= ' WHERE m.user_id = ?';
            $params[] = $ownerUserId;
        }

        $baseSQL .= ' ORDER BY m.id DESC';
        $stmt = $this->connection->executeQuery($baseSQL, $params);
        $rows = $stmt->fetchAllAssociative();

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['id'],
                'userId' => (int) $row['user_id'],
                'equipment' => [
                    'id' => (int) $row['equipment_id'],
                    'name' => $row['equipment_name'] ?? '',
                ],
                'maintenanceDate' => $this->toDateTime($row['maintenance_date']),
                'maintenanceType' => $row['maintenance_type'],
                'cost' => $row['cost'],
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findMaintenance(int $id, ?int $ownerUserId = null): ?array
    {
        $sql = 'SELECT m.id, m.user_id, m.equipment_id, e.name as equipment_name, m.maintenance_date, m.maintenance_type, m.cost FROM maintenance m LEFT JOIN equipments e ON e.id = m.equipment_id WHERE m.id = ?';
        $params = [$id];

        if ($ownerUserId !== null) {
            $sql .= ' AND m.user_id = ?';
            $params[] = $ownerUserId;
        }

        $stmt = $this->connection->executeQuery($sql, $params);
        $row = $stmt->fetchAssociative();

        if (!$row) {
            return null;
        }

        return [
            'id' => (int) $row['id'],
            'userId' => (int) $row['user_id'],
            'equipment' => [
                'id' => (int) $row['equipment_id'],
                'name' => $row['equipment_name'] ?? '',
            ],
            'maintenanceDate' => $this->toDateTime($row['maintenance_date']),
            'maintenanceType' => $row['maintenance_type'],
            'cost' => $row['cost'],
        ];
    }

    /**
     * @param array{equipmentId:int,maintenanceDate:?string,maintenanceType:?string,cost:?string} $data
     */
    public function createMaintenance(array $data, int $ownerUserId): void
    {
        $ownedEquipment = $this->findEquipment((int) $data['equipmentId'], $ownerUserId);
        if (!$ownedEquipment) {
            throw new \RuntimeException('Selected equipment does not belong to this user.');
        }

        $sql = 'INSERT INTO maintenance (user_id, equipment_id, maintenance_date, maintenance_type, cost) VALUES (?, ?, ?, ?, ?)';
        $this->connection->executeStatement($sql, [
            $ownerUserId,
            $data['equipmentId'],
            $data['maintenanceDate'],
            $data['maintenanceType'],
            $data['cost'] ?? 0,
        ]);
    }

    /**
     * @param array{equipmentId:int,maintenanceDate:?string,maintenanceType:?string,cost:?string} $data
     */
    public function updateMaintenance(int $id, array $data, ?int $ownerUserId = null): void
    {
        $params = [
            $data['equipmentId'],
            $data['maintenanceDate'],
            $data['maintenanceType'],
            $data['cost'] ?? 0,
            $id,
        ];

        $sql = 'UPDATE maintenance SET equipment_id = ?, maintenance_date = ?, maintenance_type = ?, cost = ? WHERE id = ?';

        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = ?';
            $params[] = $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
    }

    public function deleteMaintenance(int $id, ?int $ownerUserId = null): void
    {
        $params = [$id];
        $sql = 'DELETE FROM maintenance WHERE id = ?';

        if ($ownerUserId !== null) {
            $sql .= ' AND user_id = ?';
            $params[] = $ownerUserId;
        }

        $this->connection->executeStatement($sql, $params);
    }

    // ======================== AFFECTATION METHODS ========================

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listAffectations(): array
    {
        $sql = 'SELECT id_affectation, type_travail, date_debut, date_fin, zone_travail, statut FROM affectation_travail ORDER BY id_affectation DESC';
        $stmt = $this->connection->executeQuery($sql);
        $rows = $stmt->fetchAllAssociative();

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['id_affectation'],
                'typeTravail' => $row['type_travail'],
                'dateDebut' => $this->toDateTime($row['date_debut']),
                'dateFin' => $this->toDateTime($row['date_fin']),
                'zoneTravail' => $row['zone_travail'],
                'statut' => $row['statut'],
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findAffectation(int $id): ?array
    {
        $sql = 'SELECT id_affectation, type_travail, date_debut, date_fin, zone_travail, statut FROM affectation_travail WHERE id_affectation = ?';
        $stmt = $this->connection->executeQuery($sql, [$id]);
        $row = $stmt->fetchAssociative();

        if (!$row) {
            return null;
        }

        return [
            'id' => (int) $row['id_affectation'],
            'typeTravail' => $row['type_travail'],
            'dateDebut' => $this->toDateTime($row['date_debut']),
            'dateFin' => $this->toDateTime($row['date_fin']),
            'zoneTravail' => $row['zone_travail'],
            'statut' => $row['statut'],
        ];
    }

    /**
     * @param array{typeTravail:?string,dateDebut:?string,dateFin:?string,zoneTravail:?string,statut:?string} $data
     */
    public function createAffectation(array $data): void
    {
        $sql = 'INSERT INTO affectation_travail (type_travail, date_debut, date_fin, zone_travail, statut) VALUES (?, ?, ?, ?, ?)';
        $this->connection->executeStatement($sql, [
            $data['typeTravail'],
            $data['dateDebut'],
            $data['dateFin'],
            $data['zoneTravail'],
            $data['statut'],
        ]);
    }

    /**
     * @param array{typeTravail:?string,dateDebut:?string,dateFin:?string,zoneTravail:?string,statut:?string} $data
     */
    public function updateAffectation(int $id, array $data): void
    {
        $sql = 'UPDATE affectation_travail SET type_travail = ?, date_debut = ?, date_fin = ?, zone_travail = ?, statut = ? WHERE id_affectation = ?';
        $this->connection->executeStatement($sql, [
            $data['typeTravail'],
            $data['dateDebut'],
            $data['dateFin'],
            $data['zoneTravail'],
            $data['statut'],
            $id,
        ]);
    }

    public function deleteAffectation(int $id): void
    {
        $this->connection->executeStatement('DELETE FROM evaluation_performance WHERE affectation_id = ?', [$id]);
        $this->connection->executeStatement('DELETE FROM affectation_travail WHERE id_affectation = ?', [$id]);
    }

    // ======================== EVALUATION METHODS ========================

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listEvaluations(?int $affectationId = null): array
    {
        $baseSQL = 'SELECT id_evaluation, affectation_id, note, qualite, commentaire, date_evaluation FROM evaluation_performance';
        $params = [];

        if ($affectationId !== null) {
            $baseSQL .= ' WHERE affectation_id = ?';
            $params[] = $affectationId;
        }

        $baseSQL .= ' ORDER BY id_evaluation DESC';
        $stmt = $this->connection->executeQuery($baseSQL, $params);
        $rows = $stmt->fetchAllAssociative();

        return array_map(function (array $row): array {
            return [
                'id' => (int) $row['id_evaluation'],
                'affectationId' => (int) $row['affectation_id'],
                'note' => (int) $row['note'],
                'qualite' => $row['qualite'],
                'commentaire' => $row['commentaire'],
                'dateEvaluation' => $this->toDateTime($row['date_evaluation']),
            ];
        }, $rows);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findEvaluation(int $id): ?array
    {
        $sql = 'SELECT id_evaluation, affectation_id, note, qualite, commentaire, date_evaluation FROM evaluation_performance WHERE id_evaluation = ?';
        $stmt = $this->connection->executeQuery($sql, [$id]);
        $row = $stmt->fetchAssociative();

        if (!$row) {
            return null;
        }

        return [
            'id' => (int) $row['id_evaluation'],
            'affectationId' => (int) $row['affectation_id'],
            'note' => (int) $row['note'],
            'qualite' => $row['qualite'],
            'commentaire' => $row['commentaire'],
            'dateEvaluation' => $this->toDateTime($row['date_evaluation']),
        ];
    }

    /**
     * @param array{affectationId:int,note:?string,qualite:?string,commentaire:?string,dateEvaluation:?string} $data
     */
    public function createEvaluation(array $data): void
    {
        $affectation = $this->findAffectation((int) $data['affectationId']);
        if (!$affectation) {
            throw new \RuntimeException('Selected affectation does not exist.');
        }

        $sql = 'INSERT INTO evaluation_performance (affectation_id, note, qualite, commentaire, date_evaluation) VALUES (?, ?, ?, ?, ?)';
        $this->connection->executeStatement($sql, [
            $data['affectationId'],
            $data['note'],
            $data['qualite'],
            $data['commentaire'],
            $data['dateEvaluation'],
        ]);
    }

    /**
     * @param array{affectationId:int,note:?string,qualite:?string,commentaire:?string,dateEvaluation:?string} $data
     */
    public function updateEvaluation(int $id, array $data): void
    {
        $sql = 'UPDATE evaluation_performance SET affectation_id = ?, note = ?, qualite = ?, commentaire = ?, date_evaluation = ? WHERE id_evaluation = ?';
        $this->connection->executeStatement($sql, [
            $data['affectationId'],
            $data['note'],
            $data['qualite'],
            $data['commentaire'],
            $data['dateEvaluation'],
            $id,
        ]);
    }

    public function deleteEvaluation(int $id): void
    {
        $this->connection->executeStatement('DELETE FROM evaluation_performance WHERE id_evaluation = ?', [$id]);
    }

    private function toDateTime(mixed $value): ?\DateTimeImmutable
    {
        if ($value === null || (is_string($value) && trim($value) === '')) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return \DateTimeImmutable::createFromInterface($value);
        }

        $trimmed = trim((string) $value);
        if ($trimmed === '') {
            return null;
        }

        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $trimmed);
        return $date ?: null;
    }
}
