<?php

namespace controllers;
use errors\HttpError404;
use models\UserModel;
use repositories\UserRepository;
use services\AuthService;

class UserController extends BaseController
{
    public string $name = 'users';

    public function __construct(
        private UserRepository $userRepository,
        private AuthService $authService
    )
    {}

    public function get($params)
    {
        $id = $params[0] ?? null;
        if (!$this->validate_int($id)) {
            return [
                'error' => 'invalid id'
            ];
        }
        $user = $this->userRepository->get($id);
        if (!$user) {
            return (new HttpError404())->show_message();
        }
        return [
            'user' => $user->toArray()
        ];
    }

    public function add($params)
    {
        $login = $params[0] ?? null;
        $password = $params[1] ?? null;
        if (!$this->validate_string($login, 40)) {
            return [
                'error' => 'invalid login'
            ];
        }
        if (!$this->validate_string($password, 40)) {
            return [
                'error' => 'invalid login'
            ];
        }
        $user_id = $this->userRepository->get_id_by_login($login);
        if ($user_id !== null) {
            return [
                'error' => 'user already exists'
            ];
        }
        $user = new UserModel($login, $password);
        $this->userRepository->create($user);
        return [
            'user' => $user->toArray()
        ];
    }

    public function login($params)
    {
        $login = $params[0] ?? null;
        $password = $params[1] ?? null;
        if (!$this->validate_string($login, 40)) {
            return [
                'error' => 'invalid login'
            ];
        }
        if (!$this->validate_string($password, 40)) {
            return [
                'error' => 'invalid login'
            ];
        }
        $success = false;
        if ($this->authService->login($login, $password)) {
            $_SESSION['login'] = $login;
            $success = true;
        }
        return [
            'result' => $success
        ];
    }

    public function logout($params)
    {
        $this->authService->logout();
        return [
            'result' => true
        ];
    }
}