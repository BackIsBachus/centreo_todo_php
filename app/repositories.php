<?php

declare(strict_types=1);

use App\Domain\Task\TaskRepository;
use App\Infrastructure\Sqlite\Task\SqliteTaskRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        TaskRepository::class => \DI\autowire(SqliteTaskRepository::class),
    ]);
};
