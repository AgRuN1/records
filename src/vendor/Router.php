<?php

namespace vendor;

use errors\HttpError404;

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
        /* @var Response $response */
        $response = $this->controller->$method($arguments);
        $response->setHTTPStatus();
        print($response->toJson());
    }
}