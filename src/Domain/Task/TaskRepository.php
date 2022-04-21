<?php

declare(strict_types=1);

namespace App\Domain\Task;

interface TaskRepository
{
    /**
     * @return Task[]
     */
    public function findAll(): array;

        /**
     * @param bool $done
     * @return Task[]
     */
    public function findAllOfDone(bool $done): array;

    /**
     * @param string $uuid
     * @return Task
     * @throws TaskNotFoundException
     */
    public function findOneOfUuid(string $uuid): Task;

    /**
     * @param Task $task
     * @return bool
     * @throws TaskEmptyException
     */
    public function insertOne(Task $task): bool;
    
    /**
     * @param Task $task
     * @return bool
     * @throws TaskNotFoundException
     * @throws TaskEmptyException
     */
    public function updateOne(Task $task): bool;

    /**
     * @param string $uuid
     * @return bool
     * @throws TaskNotFoundException
     */
    public function deleteOneOfUuid(string $uuid): bool;
}
