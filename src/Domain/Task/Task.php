<?php

declare(strict_types=1);

namespace App\Domain\Task;

use JsonSerializable;

class Task implements JsonSerializable
{
    private string $uuid;
    private string $title;
    private string $comment;
    private string $createdAt;
    private string $lastUpdated;
    private bool $done;

    public function __construct(string $uuid, string $title, string $comment, string $createdAt, string $lastUpdated, bool $done)
    {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->comment = $comment;
        $this->createdAt = $createdAt;
        $this->lastUpdated = $lastUpdated;
        $this->done = $done;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getLastUpdate(): string
    {
        return $this->lastUpdated;
    }

    public function getDone(): bool
    {
        return $this->done;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    public function setLastUpdate(string $lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;
    }

    public function setDone(bool $done)
    {
        $this->done = $done;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'comment' => $this->comment,
            'createdAt' => $this->createdAt,
            'lastUpdated' => $this->lastUpdated,
            'done' => $this->done,
        ];
    }
}
