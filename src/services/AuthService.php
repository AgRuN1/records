<?php

namespace services;

use models\UserModel;
use repositories\UserRepository;

class AuthService
{
    function __construct(
        private UserRepository $userRepository
    )
    {
        @session_start();
    }

    public function login(string $login, string $password)
    {
        if ($this->userRepository->check(new UserModel($login, $password))) {
            $_SESSION['login'] = $login;
            return true;
        }
        return false;
    }

    public function auth(): ?string
    {
        $login = $_SESSION['login'] ?? null;
        if ($login === null) {
            return null;
        }
        $user_id = $this->userRepository->get_id_by_login($login);
        if ($user_id === null) {
            return null;
        }
        return $login;
    }

    public function logout()
    {
        unset($_SESSION['login']);
    }
}