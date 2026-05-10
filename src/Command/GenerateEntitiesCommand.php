<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:generate:entities',
    description: 'Reverse Engineering : génère les entités Doctrine depuis la base de données',
)]
class GenerateEntitiesCommand extends Command
{
    private const IGNORED = ['migration_versions', 'doctrine_migration_versions', 'messenger_messages'];

    public function __construct(private readonly Connection $connection)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('force', 'f', InputOption::VALUE_NONE, 'Écrase les entités existantes');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io    = new SymfonyStyle($input, $output);
        $force = $input->getOption('force');

        $io->title('🌾 Agrisens 360 — Reverse Engineering');

        $tables = $this->connection->executeQuery('SHOW TABLES')->fetchFirstColumn();
        $tables = array_filter($tables, fn($t) => !in_array($t, self::IGNORED)
            && !str_contains($t, 'migration') && !str_contains($t, 'doctrine'));

        $io->info(count($tables).' table(s) trouvée(s)');

        $foreignKeysMap = [];
        $uniqueColsMap = [];
        $manyToManyTables = [];

        foreach ($tables as $table) {
            $foreignKeysMap[$table] = $this->fetchForeignKeys($table);
            $uniqueColsMap[$table] = $this->fetchUniqueColumns($table);
        }

        foreach ($tables as $table) {
            $fks = $foreignKeysMap[$table];
            $cols = $this->connection->executeQuery("DESCRIBE `$table`")->fetchAllAssociative();
            if (count($fks) >= 2 && count($fks) >= count($cols) - 2) {
                $manyToManyTables[$table] = $fks;
                $io->text("  🔗 Table ManyToMany détectée : $table");
            }
        }

        $io->section('Génération des entités');
        $generated = 0;

        foreach ($tables as $table) {
            if (isset($manyToManyTables[$table])) continue;

            $className = $this->tableToClassName($table);
            $filePath  = __DIR__.'/../../src/Entity/'.$className.'.php';

            if (file_exists($filePath) && !$force) {
                $io->text("  ⏭️  Ignoré (existe déjà) : $className — utilisez --force");
                continue;
            }

            $columns    = $this->connection->executeQuery("DESCRIBE `$table`")->fetchAllAssociative();
            $primaryKey = $this->getPrimaryKey($columns);
            $ownFks     = $foreignKeysMap[$table];
            $ownUniques = $uniqueColsMap[$table];

            $code = $this->generateEntityCode(
                $table, $className, $columns, $primaryKey,
                $ownFks, $ownUniques,
                $foreignKeysMap, $uniqueColsMap, $manyToManyTables, $tables
            );

            file_put_contents($filePath, $code);
            $io->text("  ✅ Entité générée : src/Entity/$className.php");
            $generated++;
        }

        $io->success("$generated entité(s) générée(s).");
        return Command::SUCCESS;
    }

    // ==================== MÉTHODES PRIVÉES ====================

    private function generateEntityCode(
        string $table, string $className, array $columns, ?string $primaryKey,
        array $ownFks, array $ownUniques,
        array $fkMap, array $uniqueMap, array $m2mTables, array $allTables
    ): string {
        $c  = "<?php\n\n";
        $c .= "namespace App\\Entity;\n\n";
        $c .= "use App\\Repository\\{$className}Repository;\n";
        $c .= "use Doctrine\\DBAL\\Types\\Types;\n";
        $c .= "use Doctrine\\ORM\\Mapping as ORM;\n\n";
        $c .= "#[ORM\\Entity(repositoryClass: {$className}Repository::class)]\n";
        $c .= "#[ORM\\Table(name: '$table')]\n";
        $c .= "class $className\n{\n";

        // Propriétés scalaires
        foreach ($columns as $col) {
            $name = $col['Field'];
            if ($this->isFk($name, $ownFks)) continue;

            $phpType = $this->getPhpType($col['Type']);
            $doctrineType = $this->getDoctrineType($col['Type']);
            $nullable = $col['Null'] === 'YES';

            if ($name === $primaryKey) {
                $c .= "    #[ORM\\Id]\n";
                $c .= "    #[ORM\\GeneratedValue]\n";
                $c .= "    #[ORM\\Column]\n";
                $c .= "    private ?int \$$name = null;\n\n";
            } else {
                $nullStr = $nullable ? 'true' : 'false';
                $c .= "    #[ORM\\Column(type: $doctrineType, nullable: $nullStr)]\n";
                $c .= "    private ?$phpType \$$name = null;\n\n";
            }
        }

        // Relations ManyToOne
        foreach ($ownFks as $fk) {
            $refClass = $this->tableToClassName($fk['refTable']);
            $propName = lcfirst($refClass);
            $c .= "    #[ORM\\ManyToOne(targetEntity: $refClass::class)]\n";
            $c .= "    #[ORM\\JoinColumn(name: '{$fk['column']}', referencedColumnName: '{$fk['refColumn']}')]\n";
            $c .= "    private ?$refClass \$$propName = null;\n\n";
        }

        $c .= "}\n";
        return $c;
    }

    private function fetchForeignKeys(string $table): array
    {
        $rows = $this->connection->executeQuery("
            SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = :tbl
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ", [':tbl' => $table])->fetchAllAssociative();

        return array_map(fn($r) => [
            'column' => $r['COLUMN_NAME'],
            'refTable' => $r['REFERENCED_TABLE_NAME'],
            'refColumn' => $r['REFERENCED_COLUMN_NAME'],
        ], $rows);
    }

    private function fetchUniqueColumns(string $table): array
    {
        $rows = $this->connection->executeQuery("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.STATISTICS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = :tbl
              AND NON_UNIQUE = 0
              AND INDEX_NAME != 'PRIMARY'
        ", [':tbl' => $table])->fetchAllAssociative();

        $result = [];
        foreach ($rows as $r) {
            $result[$r['COLUMN_NAME']] = true;
        }
        return $result;
    }

    private function tableToClassName(string $table): string
    {
        $c = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
        if (str_ends_with($c, 's') && !str_ends_with($c, 'ss')) {
            $c = substr($c, 0, -1);
        }
        return $c;
    }

    private function getPrimaryKey(array $columns): ?string
    {
        foreach ($columns as $col) {
            if ($col['Key'] === 'PRI') {
                return $col['Field'];
            }
        }
        return null;
    }

    private function isFk(string $col, array $fks): bool
    {
        foreach ($fks as $fk) {
            if ($fk['column'] === $col) {
                return true;
            }
        }
        return false;
    }

    private function getPhpType(string $mysqlType): string
    {
        if (str_contains($mysqlType, 'tinyint(1)')) return 'bool';
        if (str_contains($mysqlType, 'int')) return 'int';
        if (str_contains($mysqlType, 'decimal') || str_contains($mysqlType, 'numeric')) return 'string';
        if (str_contains($mysqlType, 'float') || str_contains($mysqlType, 'double')) return 'float';
        if (str_contains($mysqlType, 'datetime') || str_contains($mysqlType, 'timestamp')) return '\\DateTimeInterface';
        if (str_contains($mysqlType, 'date')) return '\\DateTimeInterface';
        return 'string';
    }

    private function getDoctrineType(string $mysqlType): string
    {
        if (str_contains($mysqlType, 'tinyint(1)')) return 'Types::BOOLEAN';
        if (str_contains($mysqlType, 'int')) return 'Types::INTEGER';
        if (str_contains($mysqlType, 'decimal') || str_contains($mysqlType, 'numeric')) return 'Types::DECIMAL';
        if (str_contains($mysqlType, 'float')) return 'Types::FLOAT';
        if (str_contains($mysqlType, 'double')) return 'Types::FLOAT';
        if (str_contains($mysqlType, 'datetime') || str_contains($mysqlType, 'timestamp')) return 'Types::DATETIME_MUTABLE';
        if (str_contains($mysqlType, 'date')) return 'Types::DATE_MUTABLE';
        if (str_contains($mysqlType, 'text')) return 'Types::TEXT';
        return 'Types::STRING';
    }
}