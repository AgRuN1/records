<?php

namespace services;

use models\UserModel;

class CryptService
{
    private string $secret;
    private string $iv;
    private string $algo;
    function __construct()
    {
        $this->secret = getenv('SECRET_KEY');
        $this->iv = getenv('SECRET_IV');
        $this->algo = 'aes-256-cbc';
    }

    public function encrypt(string $data): string
    {
        return openssl_encrypt($data, $this->algo, $this->secret, 0, $this->iv);
    }

    public function decrypt_user(UserModel $user): UserModel
    {
        $login = $this->decrypt($user->getLogin());
        $password = $this->decrypt($user->getPassword());
        return new UserModel($login, $password);
    }

    public function decrypt(string $data): string
    {
        return openssl_decrypt($data, $this->algo, $this->secret, 0, $this->iv);
    }
}