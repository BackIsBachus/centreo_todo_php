<?php

declare(strict_types=1);

use App\Application\Actions\Task\CreateTaskAction;
use App\Application\Actions\Task\DeleteTaskAction;
use App\Application\Actions\Task\ListTasksAction;
use App\Application\Actions\Task\TodoTasksAction;
use App\Application\Actions\Task\UpdateTaskAction;
use App\Application\Actions\Task\ViewTaskAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    // Todo App routes
    $app->get('/', TodoTasksAction::class);

    $app->group('/task', function (Group $group) {
        $group->get(   '',        ListTasksAction::class);
        $group->post(  '',        CreateTaskAction::class);
        $group->get(   '/{uuid}', ViewTaskAction::class);
        $group->put(   '/{uuid}', UpdateTaskAction::class);
        $group->delete('/{uuid}', DeleteTaskAction::class);
    });
};
