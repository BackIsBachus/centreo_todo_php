<?php

declare(strict_types=1);

namespace App\Application\Actions\Task;
use App\Domain\Task\Task;

use Psr\Http\Message\ResponseInterface as Response;

use Ramsey\Uuid\Uuid;

use DateTime;
use DateTimeInterface;

class CreateTaskAction extends TaskAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = (array) $this->getFormData();
        $uuid = Uuid::uuid4()->toString();
        $title = "";
        $comment = "";
        $now = new DateTime();
        $formattedTime = $now->format(DateTimeInterface::RFC3339);
        $done = false;

        if (array_key_exists('title', $body))
        {
            $title = $body['title'];
        }
        if (array_key_exists('comment', $body))
        {
            $comment = $body['comment'];
        }

        $task = new Task($uuid, $title, $comment, $formattedTime, $formattedTime, $done);

        $this->taskRepository->insertOne($task);

        $this->logger->info("New Task of id `${uuid}` was created.");

        return $this->respondWithData($task, 201);
    }
}
