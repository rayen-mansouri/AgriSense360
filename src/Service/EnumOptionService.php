<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class EnumOptionService
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function getTypeOptions(): array
    {
        return $this->getColumnOptions('animal', 'type');
    }

    public function getLocationOptions(): array
    {
        return $this->getColumnOptions('animal', 'location');
    }

    public function addType(string $value): void
    {
        $this->addOption('animal', 'type', $value);
    }

    public function addLocation(string $value): void
    {
        $this->addOption('animal', 'location', $value);
    }

    public function deleteType(string $value): void
    {
        if ($this->countUsingValue('type', $value) > 0) {
            throw new \RuntimeException('Cannot delete type used by animals.');
        }
        $this->removeOption('animal', 'type', $value);
    }

    public function deleteLocation(string $value): void
    {
        if ($this->countUsingValue('location', $value) > 0) {
            throw new \RuntimeException('Cannot delete location used by animals.');
        }
        $this->removeOption('animal', 'location', $value);
    }

    private function getColumnOptions(string $table, string $column): array
    {
        $type = (string) $this->connection->fetchOne(
            'SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?',
            [$table, $column]
        );
        if (str_starts_with(strtolower($type), 'enum(')) {
            preg_match('/^enum\((.*)\)$/i', $type, $matches);
            $inner = $matches[1] ?? '';
            $parts = $inner === '' ? [] : str_getcsv($inner, ',', "'");
            return array_values(array_filter(array_map(static fn ($v) => trim((string) $v), $parts)));
        }
        $values = $this->connection->fetchFirstColumn(
            'SELECT DISTINCT ' . $column . ' FROM ' . $table . ' WHERE ' . $column . ' IS NOT NULL AND ' . $column . " <> '' ORDER BY " . $column
        );
        return array_values(array_map(static fn ($v) => (string) $v, $values));
    }

    private function addOption(string $table, string $column, string $value): void
    {
        $normalized = strtolower(trim($value));
        if ($normalized === '') {
            throw new \RuntimeException('Value cannot be empty.');
        }
        $values = $this->getColumnOptions($table, $column);
        if (in_array($normalized, $values, true)) {
            throw new \RuntimeException('Value already exists.');
        }
        $values[] = $normalized;
        $this->alterEnumColumn($table, $column, $values);
    }

    private function removeOption(string $table, string $column, string $value): void
    {
        $normalized = strtolower(trim($value));
        $values = array_values(array_filter(
            $this->getColumnOptions($table, $column),
            static fn (string $v): bool => $v !== $normalized
        ));
        if ($values === []) {
            throw new \RuntimeException('At least one option is required.');
        }
        $this->alterEnumColumn($table, $column, $values);
    }

    private function alterEnumColumn(string $table, string $column, array $values): void
    {
        $quoted = implode(',', array_map(
            fn (string $v): string => "'" . str_replace("'", "''", $v) . "'",
            $values
        ));
        $sql = sprintf('ALTER TABLE %s MODIFY COLUMN %s ENUM(%s) NULL', $table, $column, $quoted);
        $this->connection->executeStatement($sql);
    }

    private function countUsingValue(string $column, string $value): int
    {
        return (int) $this->connection->fetchOne(
            'SELECT COUNT(*) FROM animal WHERE ' . $column . ' = ?',
            [strtolower(trim($value))]
        );
    }
}
