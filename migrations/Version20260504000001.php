<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Fix corrupted `roles` column: rows where roles was stored as a plain string
 * (e.g. "ROLE_GERANT") instead of a JSON array (e.g. ["ROLE_GERANT"]) are
 * rewritten to the correct JSON format.
 */
final class Version20260504000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fix roles column: wrap bare role strings into JSON arrays';
    }

    public function up(Schema $schema): void
    {
        // Fetch every user row and fix the ones whose roles value is not a
        // valid JSON array (i.e. does not start with "[").
        $rows = $this->connection->fetchAllAssociative('SELECT id, roles FROM `user`');

        foreach ($rows as $row) {
            $raw = $row['roles'];

            // Skip nulls and already-valid JSON arrays
            if ($raw === null || str_starts_with(ltrim($raw), '[')) {
                continue;
            }

            // Attempt to decode – if it decodes to a string it was stored without the array wrapper
            $decoded = json_decode($raw, true);

            if (is_string($decoded)) {
                // e.g. "ROLE_GERANT"  →  ["ROLE_GERANT"]
                $fixed = json_encode([$decoded]);
            } elseif ($decoded === null) {
                // Not JSON at all – the raw value is a plain string like ROLE_GERANT (no quotes)
                $fixed = json_encode([$raw]);
            } else {
                // Already an array or unknown structure – leave it alone
                continue;
            }

            $this->addSql(
                'UPDATE `user` SET roles = :roles WHERE id = :id',
                ['roles' => $fixed, 'id' => $row['id']]
            );
        }
    }

    public function down(Schema $schema): void
    {
        // This migration cannot be safely reversed without knowing the original values.
        $this->throwIrreversibleMigrationException();
    }
}
