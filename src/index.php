<?php

require_once("autoload.php");

use controllers\RecordController;
use controllers\UserController;
use vendor\Container;
use vendor\Router;

header('Content-type: application/json');

(function()
{
    $container = new Container();

    $controllers = [
        $container->get(UserController::class),
        $container->get(RecordController::class)
    ];
    $router = new Router(explode('/', $_GET['path']), $controllers);
    $router->run();
})();
