<?php

declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteTaskAction extends TaskAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $taskUuid = (string) $this->resolveArg('uuid');
        $this->taskRepository->deleteOneOfUuid($taskUuid);

        $this->logger->info("Task of id `${taskUuid}` was deleted.");

        return $this->respondWithData(null, 204);
    }
}
