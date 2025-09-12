<?php

namespace controllers;
use errors\HttpError404;
use models\UserModel;
use repositories\UserRepository;

class UserController extends BaseController
{
    public string $name = 'users';

    public function __construct(
        private UserRepository $userRepository
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
        $user = new UserModel($login, $password, true);
        $current_user = $this->userRepository->get_by_login($user->login);
        if ($current_user) {
            return [
                'error' => 'user already exists'
            ];
        }
        $this->userRepository->create($user);
        return [
            'user' => $user->toArray()
        ];
    }

    public function check($params)
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
        $user = new UserModel($login, $password, true);
        $result = $this->userRepository->check($user);
        if ($result) {
            setcookie('login', $login, time()+3600, "/api/*");
        }
        return [
            'result' => $result
        ];
    }
}