<?php

require_once("autoload.php");
require_once("container.php");

use controllers\RecordController;
use controllers\UserController;
use errors\HttpError404;

 date_default_timezone_set('Europe/Moscow');
 
  class Router
  {
    private $controller = null;
    private ?string $method = null;
    private array $arguments;

    public function __construct($data, $controllers)
    {
        $this->arguments = [];
        if (count($data) < 2) {
            $this->controller = new HttpError404();
            $this->method = 'show_message';
        } else {
            foreach ($controllers as $controller) {
                if ($data[0] == $controller->name) {
                    $method = $data[1];
                    if (method_exists($controller, $method)) {
                        $this->controller = $controller;
                        $this->method = $method;
                        if (count($data) > 2) {
                            $this->arguments = array_slice($data, 2);
                        }
                    }
                }
            }
            if (!$this->controller && !$this->method) {
                $this->controller = new HttpError404();
                $this->method = 'show_message';
            }
        }
    }

    public function run()
    {
        $method = $this->method;
        $arguments = $this->arguments;
        $result = $this->controller->$method($arguments);
        print(json_encode($result));
    }
  }

  $container = new Container();

  $controllers = [
      $container->get(UserController::class),
      $container->get(RecordController::class)
  ];
  $router = new Router(explode('/', $_GET['path']), $controllers);
  $router->run();