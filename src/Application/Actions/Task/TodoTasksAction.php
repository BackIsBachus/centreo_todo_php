<?php

declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;

class TodoTasksAction extends TaskAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $tasks = $this->taskRepository->findAllOfDone(false);

        $this->logger->info("Tasks not done list was viewed.");

        return $this->respondWithData($tasks);
    }
}
