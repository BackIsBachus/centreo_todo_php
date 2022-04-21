<?php

declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;

class ViewTaskAction extends TaskAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $taskUuid = (string) $this->resolveArg('uuid');
        $task = $this->taskRepository->findOneOfUuid($taskUuid);

        $this->logger->info("Task of id `${taskUuid}` was viewed.");

        return $this->respondWithData($task);
    }
}
