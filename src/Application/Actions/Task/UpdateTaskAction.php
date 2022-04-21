<?php

declare(strict_types=1);

namespace App\Application\Actions\Task;

use Psr\Http\Message\ResponseInterface as Response;

use DateTime;
use DateTimeInterface;

class UpdateTaskAction extends TaskAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $taskUuid = (string) $this->resolveArg('uuid');
        $task = $this->taskRepository->findOneOfUuid($taskUuid);

        $body = (array) $this->getFormData();
        $now = new DateTime();
        $formattedTime = $now->format(DateTimeInterface::RFC3339);

        $changed = false;

        if (array_key_exists('title', $body) and ($body['title'] != $task->getTitle()))
        {
            $task->setTitle($body['title']);
            $changed = true;
        }
        if (array_key_exists('comment', $body) and ($body['comment'] != $task->getComment()))
        {
            $task->setComment($body['comment']);
            $changed = true;
        }
        if (array_key_exists('done', $body) and ($body['done'] != $task->getDone()))
        {
            $task->setDone((bool)$body['done']);
            $changed = true;
        }

        $uuid = $task->getUuid();
        if($changed)
        {
            $task->setLastUpdate($formattedTime);
            $this->taskRepository->updateOne($task);
            $this->logger->info("Task of id `${uuid}` was updated.");
        }
        else
        {
            $this->logger->info("Task of id `${uuid}` was not updated, nothing new.");
        }



        return $this->respondWithData($task, 201);
    }
}
