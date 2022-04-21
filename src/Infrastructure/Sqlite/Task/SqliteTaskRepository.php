<?php

declare(strict_types=1);

namespace App\Infrastructure\Sqlite\Task;

use App\Domain\Task\Task;
use App\Domain\Task\TaskNotFoundException;
use App\Domain\Task\TaskEmptyException;
use App\Domain\Task\TaskRepository;


use PDO;

class SqliteTaskRepository implements TaskRepository
{
    /**
     * @var Task[]
     */
    private PDO $db;

    /**
     * @param User[]|null $users
     */
    public function __construct()
    {
        $this->db = new PDO('sqlite:'.__DIR__.'/../../../../task.db');
        $this->db->exec("CREATE TABLE IF NOT EXISTS tasks (uuid text, title text, comment text, created_at text, last_updated text, done integer)");
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM tasks";
        
        $req = $this->db->prepare($query);
        $req->execute();
        $results = $req->fetchAll(PDO::FETCH_ASSOC);

        $tasks = array();
        foreach ($results as $res)
        {
            $tasks[] = $this->makeTaskFromResult($res);
        }

        return $tasks;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllOfDone(bool $done): array
    {
        $query = "SELECT * FROM tasks WHERE done = :done";
        
        $req = $this->db->prepare($query);
        $doneInt = (int)$done;
        $req->bindParam(':done', $doneInt, PDO::PARAM_BOOL);
        $req->execute();
        $results = $req->fetchAll(PDO::FETCH_ASSOC);

        $tasks = array();
        foreach ($results as $res)
        {
            $tasks[] = $this->makeTaskFromResult($res);
        }

        return $tasks;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneOfUuid(string $uuid): Task
    {
        $query = "SELECT * FROM tasks WHERE uuid=:uuid LIMIT 1";
        $req = $this->db->prepare($query);
        $req->bindParam(':uuid', $uuid, PDO::PARAM_STR);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);

        if ($result == false)
        {
            throw new TaskNotFoundException();
        }

        return $this->makeTaskFromResult($result);
    }

        /**
     * {@inheritdoc}
     */
    public function insertOne(Task $task): bool
    {
        $this->throwIfEmptyTask($task);

        $query = "INSERT INTO tasks VALUES (:uuid, :title, :comment, :created_at, :last_updated, :done)";
        $req = $this->db->prepare($query);

        $uuid = $task->getUuid();
        $title = $task->getTitle();
        $comment = $task->getComment();
        $createdAt = $task->getCreatedAt();
        $lastUpdated = $task->getLastUpdate();
        $done = (int)$task->getDone();

        $req->bindParam(':uuid',         $uuid,        PDO::PARAM_STR);
        $req->bindParam(':title',        $title,       PDO::PARAM_STR);
        $req->bindParam(':comment',      $comment,     PDO::PARAM_STR);
        $req->bindParam(':created_at',   $createdAt,   PDO::PARAM_STR);
        $req->bindParam(':last_updated', $lastUpdated, PDO::PARAM_STR);
        $req->bindParam(':done',         $done,        PDO::PARAM_BOOL);
        $result = $req->execute();

        return $result;
    }

    public function updateOne(Task $task): bool
    {
        $this->throwIfEmptyTask($task);

        $query = "UPDATE tasks SET title = :title, comment = :comment, last_updated = :last_updated, done = :done WHERE uuid = :uuid";
        $req = $this->db->prepare($query);

        $uuid = $task->getUuid();
        $title = $task->getTitle();
        $comment = $task->getComment();
        $lastUpdated = $task->getLastUpdate();
        $done = (int)$task->getDone();

        $req->bindParam(':title',        $title,       PDO::PARAM_STR);
        $req->bindParam(':comment',      $comment,     PDO::PARAM_STR);
        $req->bindParam(':last_updated', $lastUpdated, PDO::PARAM_STR);
        $req->bindParam(':done',         $done,        PDO::PARAM_BOOL);
        $req->bindParam(':uuid',         $uuid,        PDO::PARAM_STR);
        $result = $req->execute();
        if ($result == false)
        {
            throw new TaskNotFoundException();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteOneOfUuid(string $uuid): bool
    {
        $query = "DELETE FROM tasks WHERE uuid = :uuid";
        $req = $this->db->prepare($query);
        $req->bindParam(':uuid', $uuid, PDO::PARAM_STR);
        $result = $req->execute();

        if ($result == false)
        {
            throw new TaskNotFoundException();
        }

        return $result;
    }

    

    private function makeTaskFromResult(array $res): Task
    {
        return new Task($res['uuid'], $res['title'], $res['comment'], $res['created_at'], $res['last_updated'], (bool)$res['done']);
    }

    private function throwIfEmptyTask(Task $task)
    {
        if (empty($task->getTitle()) and  empty($task->getComment()))
        {
            throw new TaskEmptyException();
        }
    }
}
