<?php

namespace controllers;
use errors\HttpError404;
use errors\HttpError422;
use models\UserModel;
use repositories\UserRepository;
use services\AuthService;
use vendor\Response;

class UserController
{
    public string $name = 'users';

    public function __construct(
        private UserRepository $userRepository,
        private AuthService $authService
    )
    {}

    private function validate_login(string $login): bool
    {
        if (!preg_match('/^[a-z]{4,40}$/', $login)) {
            return false;
        }
        return true;
    }

    private function validate_password(string $password): bool
    {
        if (!preg_match('/^[a-zA-Z0-9]{4,40}$/', $password)) {
            return false;
        }
        return true;
    }

    public function get($params)
    {
        $login = $params[0] ?? null;
        if (!$this->validate_login($login)) {
            return (new HttpError422('Некорректный логин'))->show_message();
        }
        $user = $this->userRepository->get($login);
        if (!$user) {
            return (new HttpError422('Логин не найден'))->show_message();
        }
        return new Response($user->toArray());
    }

    public function add($params)
    {
        $login = $params[0] ?? null;
        $password = $params[1] ?? null;
        if (!$this->validate_login($login)) {
            return (new HttpError422('Некорректный логин'))->show_message();
        }
        if (!$this->validate_password($password)) {
            return (new HttpError422('Некорректный пароль'))->show_message();
        }
        $user_id = $this->userRepository->get_id_by_login($login);
        if ($user_id !== null) {
            return (new HttpError422('Логин уже занят'))->show_message();
        }
        $user = new UserModel($login, $password);
        $this->userRepository->create($user);
        if ($this->authService->login($login, $password)) {
            return new Response($user->toArray(), true);
        }
        return new Response($user->toArray(), false);
    }

    public function login($params)
    {
        $login = $params[0] ?? null;
        $password = $params[1] ?? null;
        if (!$this->validate_login($login)) {
            return (new HttpError422('Некорректный логин'))->show_message();
        }
        if (!$this->validate_password($password)) {
            return (new HttpError422('Некорректный пароль'))->show_message();
        }
        if ($this->authService->login($login, $password)) {
            return new Response(null, true, 200);
        }
        return new Response(null, false, 422);
    }

    public function logout($params)
    {
        $this->authService->logout();
        return new Response(null, true);
    }
}