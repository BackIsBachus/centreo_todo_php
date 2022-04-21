<?php

declare(strict_types=1);

namespace App\Domain\Task;

use App\Domain\DomainException\DomainEmptyException;

class TaskEmptyException extends DomainEmptyException
{
    public $message = 'Specify at least a title or comment to create a task';
}
