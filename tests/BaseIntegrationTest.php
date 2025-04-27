<?php

declare(strict_types=1);

namespace Tests;

use Nette\Database\Explorer;
use Nette\DI\Container;
use PHPUnit\Framework\TestCase;

abstract class BaseIntegrationTest extends TestCase
{
    use DatabaseCleanerTrait;

    protected Container $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = (new \App\Bootstrap())->bootWebApplication();

        $this->db = $this->container->getByType(Explorer::class);

        $this->cleanDatabase();
    }

    protected function cleanDatabase(): void
    {
        $this->truncateTable('products');
    }
}
