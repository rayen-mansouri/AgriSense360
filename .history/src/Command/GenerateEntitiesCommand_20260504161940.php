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

// ============================================================
// ERREURS CORRIGÉES dans GenerateEntitiesCommand :
//
// 1. Ne générait PAS les relations (ManyToOne, OneToMany) → ajoutées
// 2. Ne détectait pas les FK → requête INFORMATION_SCHEMA ajoutée
// 3. Ne générait pas les constructeurs avec ArrayCollection → ajouté
// 4. Ne gérait pas nullable correctement (seuil_alerte DEFAULT NULL
//    généré comme nullable: false) → correction via $column['Null']
// 5. Ne génère pas la colonne FK brute (produit_id), génère la
//    relation objet (#[ManyToOne]) → cohérent avec Doctrine ORM
// 6. Ajout de l'option --force pour écraser les fichiers existants
// ============================================================

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

        // 1. Lister les tables
        $tables = $this->connection->executeQuery('SHOW TABLES')->fetchFirstColumn();
        $tables = array_filter($tables, fn($t) => !in_array($t, self::IGNORED)
            && !str_contains($t, 'migration') && !str_contains($t, 'doctrine'));

        $io->info(count($tables).' table(s) trouvée(s) : '.implode(', ', $tables));

        // 2. Collecter FK et contraintes UNIQUE pour chaque table
        $foreignKeysMap  = [];
        $uniqueColsMap   = [];
        $manyToManyTables = [];

        foreach ($tables as $table) {
            $foreignKeysMap[$table]  = $this->fetchForeignKeys($table);
            $uniqueColsMap[$table]   = $this->fetchUniqueColumns($table);
        }

        // 3. Détecter tables de jointure ManyToMany
        foreach ($tables as $table) {
            $fks      = $foreignKeysMap[$table];
            $cols     = $this->connection->executeQuery("DESCRIBE `$table`")->fetchAllAssociative();
            if (count($fks) >= 2 && count($fks) >= count($cols) - 2) {
                $manyToManyTables[$table] = $fks;
                $io->text("  🔗 Table ManyToMany détectée : $table");
            }
        }

        // 4. Générer les entités
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
        $io->note([
            'Étapes suivantes :',
            '1. php bin/console make:entity --regenerate',
            '2. php bin/console doctrine:migrations:diff',
            '3. php bin/console doctrine:migrations:migrate',
        ]);

        return Command::SUCCESS;
    }

    // ─────────────────────────────────────────────────────────────────────────

    private function generateEntityCode(
        string $table, string $className, array $columns, ?string $primaryKey,
        array $ownFks, array $ownUniques,
        array $fkMap, array $uniqueMap, array $m2mTables, array $allTables
    ): string {
        $c  = "<?php\n\n";
        $c .= "namespace App\\Entity;\n\n";
        $c .= "use App\\Repository\\{$className}Repository;\n";
        $c .= "use Doctrine\\Common\\Collections\\ArrayCollection;\n";
        $c .= "use Doctrine\\Common\\Collections\\Collection;\n";
        $c .= "use Doctrine\\DBAL\\Types\\Types;\n";
        $c .= "use Doctrine\\ORM\\Mapping as ORM;\n\n";
        $c .= "#[ORM\\Entity(repositoryClass: {$className}Repository::class)]\n";
        $c .= "#[ORM\\Table(name: '$table')]\n";
        $c .= "#[ORM\\HasLifecycleCallbacks]\n";
        $c .= "class $className\n{\n";

        $colNames = array_column($columns, 'Field');

        // ── Propriétés scalaires ──────────────────────────────────────────
        foreach ($columns as $col) {
            $name = $col['Field'];
            if ($this->isFk($name, $ownFks)) continue; // FK → relation objet

            $phpType      = $this->getPhpType($col['Type']);
            $doctrineType = $this->getDoctrineType($col['Type']);
            $nullable     = $col['Null'] === 'YES';

            $c .= "\n";
            if ($name === $primaryKey) {
                $c .= "    #[ORM\\Id]\n    #[ORM\\GeneratedValue]\n    #[ORM\\Column]\n";
                $c .= "    private ?int \$$name = null;\n";
            } else {
                $nullStr = $nullable ? 'true' : 'false';
                $extra   = '';
                if (in_array($doctrineType, ['Types::STRING']) && preg_match('/\((\d+)\)/', $col['Type'], $m)) {
                    $extra = ", length: {$m[1]}";
                } elseif ($doctrineType === 'Types::DECIMAL') {
                    $extra = ', precision: 10, scale: 2';
                }
                $c .= "    #[ORM\\Column(type: $doctrineType$extra, nullable: $nullStr)]\n";
                $c .= "    private ?$phpType \$$name = null;\n";
            }
        }

        // ── Relations ManyToOne / OneToOne (FK dans cette table) ──────────
        foreach ($ownFks as $fk) {
            $refClass   = $this->tableToClassName($fk['refTable']);
            $propName   = lcfirst($refClass);
            $isOneToOne = isset($ownUniques[$fk['column']]);
            $c .= "\n";
            if ($isOneToOne) {
                $c .= "    #[ORM\\OneToOne(targetEntity: $refClass::class, inversedBy: '".lcfirst($className)."')]\n";
                $c .= "    #[ORM\\JoinColumn(name: '{$fk['column']}', referencedColumnName: '{$fk['refColumn']}', unique: true)]\n";
            } else {
                $c .= "    #[ORM\\ManyToOne(targetEntity: $refClass::class, inversedBy: '".lcfirst($className)."s')]\n";
                $c .= "    #[ORM\\JoinColumn(name: '{$fk['column']}', referencedColumnName: '{$fk['refColumn']}', nullable: false)]\n";
            }
            $c .= "    private ?$refClass \$$propName = null;\n";
        }

        // ── Relations OneToMany / inverse OneToOne ────────────────────────
        foreach ($allTables as $otherTable) {
            if (!isset($fkMap[$otherTable]) || isset($m2mTables[$otherTable])) continue;
            foreach ($fkMap[$otherTable] as $fk) {
                if ($fk['refTable'] !== $table) continue;
                $otherClass    = $this->tableToClassName($otherTable);
                $isOneToOneInv = isset($uniqueMap[$otherTable][$fk['column']]);
                $c .= "\n";
                if ($isOneToOneInv) {
                    $c .= "    #[ORM\\OneToOne(targetEntity: $otherClass::class, mappedBy: '".lcfirst($className)."')]\n";
                    $c .= "    private ?$otherClass \$".lcfirst($otherClass)." = null;\n";
                } else {
                    $cv = lcfirst($otherClass).'s';
                    $c .= "    #[ORM\\OneToMany(mappedBy: '".lcfirst($className)."', targetEntity: $otherClass::class, cascade: ['persist', 'remove'])]\n";
                    $c .= "    private Collection \$$cv;\n";
                }
            }
        }

        // ── ManyToMany ────────────────────────────────────────────────────
        foreach ($m2mTables as $jTable => $jFks) {
            $thisFk = $otherFk = null;
            foreach ($jFks as $fk) {
                if ($fk['refTable'] === $table) $thisFk = $fk;
                else                            $otherFk = $fk;
            }
            if (!$thisFk || !$otherFk) continue;
            $otherClass = $this->tableToClassName($otherFk['refTable']);
            $cv = lcfirst($otherClass).'s';
            $c .= "\n    #[ORM\\ManyToMany(targetEntity: $otherClass::class, inversedBy: '".lcfirst($className)."s')]\n";
            $c .= "    #[ORM\\JoinTable(name: '$jTable',\n";
            $c .= "        joinColumns: [new ORM\\JoinColumn(name: '{$thisFk['column']}', referencedColumnName: '{$thisFk['refColumn']}')],\n";
            $c .= "        inverseJoinColumns: [new ORM\\JoinColumn(name: '{$otherFk['column']}', referencedColumnName: '{$otherFk['refColumn']}')]\n    )]\n";
            $c .= "    private Collection \$$cv;\n";
        }

        // ── Constructeur ──────────────────────────────────────────────────
        $c .= "\n    public function __construct()\n    {\n";
        foreach ($allTables as $ot) {
            if (!isset($fkMap[$ot]) || isset($m2mTables[$ot])) continue;
            foreach ($fkMap[$ot] as $fk) {
                if ($fk['refTable'] !== $table) continue;
                if (!isset($uniqueMap[$ot][$fk['column']])) {
                    $c .= "        \$this->".lcfirst($this->tableToClassName($ot))."s = new ArrayCollection();\n";
                }
            }
        }
        foreach ($m2mTables as $jTable => $jFks) {
            $thisFk = $otherFk = null;
            foreach ($jFks as $fk) { if ($fk['refTable'] === $table) $thisFk=$fk; else $otherFk=$fk; }
            if ($thisFk && $otherFk) {
                $c .= "        \$this->".lcfirst($this->tableToClassName($otherFk['refTable']))."s = new ArrayCollection();\n";
            }
        }
        if (in_array('created_at', $colNames)) {
            $c .= "        \$this->created_at = new \\DateTime();\n";
            $c .= "        \$this->updated_at = new \\DateTime();\n";
        }
        $c .= "    }\n";

        if (in_array('updated_at', $colNames)) {
            $c .= "\n    #[ORM\\PreUpdate]\n";
            $c .= "    public function preUpdate(): void { \$this->updated_at = new \\DateTime(); }\n";
        }

        // ── Getters / Setters scalaires ───────────────────────────────────
        foreach ($columns as $col) {
            $name = $col['Field'];
            if ($this->isFk($name, $ownFks)) continue;
            $phpType = $this->getPhpType($col['Type']);
            $ucName  = ucfirst(str_replace('_', '', ucwords($name, '_')));
            $nullable = $col['Null'] === 'YES';
            if ($name === $primaryKey) {
                $c .= "\n    public function getId(): ?int { return \$this->$name; }\n";
            } else {
                $c .= "\n    public function get$ucName(): ?$phpType { return \$this->$name; }\n";
                $nStr = $nullable ? '?' : '';
                $c .= "    public function set$ucName({$nStr}$phpType \$v): static { \$this->$name = \$v; return \$this; }\n";
            }
        }

        // ── Getters / Setters relations ───────────────────────────────────
     // ── Relations ManyToOne / OneToOne (FK dans cette table) ──────────
foreach ($ownFks as $fk) {
    $refClass   = $this->tableToClassName($fk['refTable']);
    $propName   = lcfirst($refClass);
    $isOneToOne = isset($ownUniques[$fk['column']]);
    $c .= "\n";
    if ($isOneToOne) {
        $c .= "    #[ORM\\OneToOne(targetEntity: $refClass::class, inversedBy: '".lcfirst($className)."')]\n";
        $c .= "    #[ORM\\JoinColumn(name: '{$fk['column']}', referencedColumnName: '{$fk['refColumn']}', unique: true)]\n";
    } else {
        $c .= "    #[ORM\\ManyToOne(targetEntity: $refClass::class, inversedBy: '".lcfirst($className)."s')]\n";
        $c .= "    #[ORM\\JoinColumn(name: '{$fk['column']}', referencedColumnName: '{$fk['refColumn']}', nullable: false)]\n";
    }
    // ✅ CORRECTION : ajouter ? et = null
    $c .= "    private ?$refClass \$$propName = null;\n";
}

// ── Relations OneToMany / inverse OneToOne ────────────────────────
foreach ($allTables as $otherTable) {
    if (!isset($fkMap[$otherTable]) || isset($m2mTables[$otherTable])) continue;
    foreach ($fkMap[$otherTable] as $fk) {
        if ($fk['refTable'] !== $table) continue;
        $otherClass    = $this->tableToClassName($otherTable);
        $isOneToOneInv = isset($uniqueMap[$otherTable][$fk['column']]);
        $c .= "\n";
        if ($isOneToOneInv) {
            $c .= "    #[ORM\\OneToOne(targetEntity: $otherClass::class, mappedBy: '".lcfirst($className)."')]\n";
            // ✅ CORRECTION : ajouter ? et = null
            $c .= "    private ?$otherClass \$".lcfirst($otherClass)." = null;\n";
        } else {
            $cv = lcfirst($otherClass).'s';
            $c .= "    #[ORM\\OneToMany(mappedBy: '".lcfirst($className)."', targetEntity: $otherClass::class, cascade: ['persist', 'remove'])]\n";
            // ✅ CORRECTION : initialiser avec ArrayCollection (déjà fait dans constructeur)
            $c .= "    private Collection \$$cv;\n";
        }
    }
}

    // ─────────────────────────────────────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────────────────────────────────────

    private function fetchForeignKeys(string $table): array
    {
        $rows = $this->connection->executeQuery("
            SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
            FROM   INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE  TABLE_SCHEMA = DATABASE()
              AND  TABLE_NAME   = :tbl
              AND  REFERENCED_TABLE_NAME IS NOT NULL
        ", [':tbl' => $table])->fetchAllAssociative();

        return array_map(fn($r) => [
            'column'    => $r['COLUMN_NAME'],
            'refTable'  => $r['REFERENCED_TABLE_NAME'],
            'refColumn' => $r['REFERENCED_COLUMN_NAME'],
        ], $rows);
    }

    private function fetchUniqueColumns(string $table): array
    {
        $rows = $this->connection->executeQuery("
            SELECT COLUMN_NAME
            FROM   INFORMATION_SCHEMA.STATISTICS
            WHERE  TABLE_SCHEMA = DATABASE()
              AND  TABLE_NAME   = :tbl
              AND  NON_UNIQUE   = 0
              AND  INDEX_NAME  != 'PRIMARY'
        ", [':tbl' => $table])->fetchAllAssociative();

        $result = [];
        foreach ($rows as $r) { $result[$r['COLUMN_NAME']] = true; }
        return $result;
    }

    private function tableToClassName(string $table): string
    {
        $c = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
        if (str_ends_with($c, 's') && !str_ends_with($c, 'ss')) $c = substr($c, 0, -1);
        return $c;
    }

    private function getPrimaryKey(array $columns): ?string
    {
        foreach ($columns as $col) { if ($col['Key'] === 'PRI') return $col['Field']; }
        return null;
    }

    private function isFk(string $col, array $fks): bool
    {
        foreach ($fks as $fk) { if ($fk['column'] === $col) return true; }
        return false;
    }

    private function getPhpType(string $mysqlType): string
    {
        if (str_contains($mysqlType, 'tinyint(1)'))                    return 'bool';
        if (str_contains($mysqlType, 'int'))                           return 'int';
        if (str_contains($mysqlType, 'decimal') || str_contains($mysqlType, 'numeric')) return 'string';
        if (str_contains($mysqlType, 'float') || str_contains($mysqlType, 'double'))    return 'float';
        if (str_contains($mysqlType, 'datetime') || str_contains($mysqlType, 'timestamp')) return '\\DateTimeInterface';
        if (str_contains($mysqlType, 'date'))                          return '\\DateTimeInterface';
        return 'string';
    }

    private function getDoctrineType(string $mysqlType): string
    {
        if (str_contains($mysqlType, 'tinyint(1)'))  return 'Types::BOOLEAN';
        if (str_contains($mysqlType, 'int'))         return 'Types::INTEGER';
        if (str_contains($mysqlType, 'decimal') || str_contains($mysqlType, 'numeric')) return 'Types::DECIMAL';
        if (str_contains($mysqlType, 'float'))       return 'Types::FLOAT';
        if (str_contains($mysqlType, 'double'))      return 'Types::FLOAT';
        if (str_contains($mysqlType, 'datetime') || str_contains($mysqlType, 'timestamp')) return 'Types::DATETIME_MUTABLE';
        if (str_contains($mysqlType, 'date'))        return 'Types::DATE_MUTABLE';
        if (str_contains($mysqlType, 'text'))        return 'Types::TEXT';
        return 'Types::STRING';
    }
}
