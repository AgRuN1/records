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

    public function login(string $login, string $password) {
        return $this->userRepository->check(new UserModel($login, $password));
    }

    public function auth(string $login) {
        $user_id = $this->userRepository->get_id_by_login($login);
        return $user_id !== null;
    }

    public function logout() {
        unset($_SESSION['login']);
    }
}