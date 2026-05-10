<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class EnumOptionService
{
    private const MAX_DYNAMIC_OPTIONS = 99;

    public function __construct(private readonly Connection $connection)
    {
    }

    public function getTypeOptions(): array
    {
        return $this->getOptions('type');
    }

    public function getLocationOptions(): array
    {
        return $this->getOptions('location');
    }

    public function addType(string $value): void
    {
        $this->addOption('type', $value);
    }

    public function addLocation(string $value): void
    {
        $this->addOption('location', $value);
    }

    public function deleteType(string $value): void
    {
        if ($this->countUsingValue('type', $value) > 0) {
            throw new \RuntimeException('Cannot delete type used by animals.');
        }
        $this->removeOption('type', $value);
    }

    public function deleteLocation(string $value): void
    {
        if ($this->countUsingValue('location', $value) > 0) {
            throw new \RuntimeException('Cannot delete location used by animals.');
        }
        $this->removeOption('location', $value);
    }

    private function getOptions(string $column): array
    {
        $values = $this->connection->fetchFirstColumn(sprintf(
            'SELECT DISTINCT %s FROM animal WHERE %s IS NOT NULL AND %s <> \'\' ORDER BY %s ASC LIMIT %d',
            $column,
            $column,
            $column,
            $column,
            self::MAX_DYNAMIC_OPTIONS
        ));

        return array_values(array_map(static fn ($v): string => (string) $v, $values));
    }

    private function addOption(string $column, string $value): void
    {
        $normalized = strtolower(trim($value));
        if ($normalized === '') {
            throw new \RuntimeException('Value cannot be empty.');
        }
        $values = $this->getOptions($column);
        if (in_array($normalized, $values, true)) {
            throw new \RuntimeException('Value already exists.');
        }
        // Keep options dynamic without changing DB enum schema.
    }

    private function removeOption(string $column, string $value): void
    {
        $normalized = strtolower(trim($value));
        $values = $this->getOptions($column);
        if (!in_array($normalized, $values, true)) {
            throw new \RuntimeException('Value not found.');
        }
        // Keep options dynamic without changing DB enum schema.
    }

    private function countUsingValue(string $column, string $value): int
    {
        return (int) $this->connection->fetchOne(
            sprintf('SELECT COUNT(*) FROM animal WHERE %s = ?', $column),
            [strtolower(trim($value))]
        );
    }
}
