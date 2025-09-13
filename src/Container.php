<?php

use controllers\RecordController;
use controllers\UserController;
use database\MysqliSession;
use repositories\RecordRepository;
use repositories\UserRepository;
use services\CryptService;

class Container
{

    private array $objects = [];

    public function __construct()
    {
        $this->objects = [
            MysqliSession::class => fn() => new MysqliSession(),
            CryptService::class => fn() => new CryptService(),
            RecordRepository::class => fn() => new RecordRepository($this->get(MysqliSession::class)),
            UserRepository::class => fn() => new UserRepository(
                $this->get(MysqliSession::class),
                $this->get(CryptService::class)
            ),
            UserController::class => fn() => new UserController($this->get(UserRepository::class)),
            RecordController::class => fn() => new RecordController(
                $this->get(RecordRepository::class),
                $this->get(UserRepository::class)
            ),
        ];
    }

public function has(string $id): bool
    {
        return isset($this->objects[$id]);
    }

    public function get(string $id): mixed
    {
        return $this->objects[$id]();
    }
}