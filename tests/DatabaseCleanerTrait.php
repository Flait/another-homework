<?php

declare(strict_types=1);

namespace Tests;

use Nette\Database\Explorer;

trait DatabaseCleanerTrait
{
    private Explorer $db;

    protected function truncateTable(string $tableName): void
    {
        $this->db->query("TRUNCATE TABLE {$tableName} RESTART IDENTITY CASCADE");
    }
}
