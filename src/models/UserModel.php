<?php

namespace models;


class UserModel extends BaseModel
{
    public string $login;
    public string $password;
    private string $secret;
    private string $iv;
    private string $algo;
    function __construct(string $login, string $password, $encrypt=false)
    {
        $this->secret = getenv('SECRET_KEY');
        $this->iv = getenv('SECRET_IV');
        $this->algo = 'aes-256-cbc';
        if ($encrypt) {
            $this->login = openssl_encrypt($login, $this->algo, $this->secret, 0, $this->iv);
            $this->password = openssl_encrypt($password, $this->algo, $this->secret, 0, $this->iv);
        } else {
            $this->login = $login;
            $this->password = $password;
        }
    }

    public function getLogin(): string
    {
        return openssl_decrypt($this->login, $this->algo, $this->secret, 0, $this->iv);
    }

    public function getPassword(): string
    {
        return openssl_decrypt($this->password, $this->algo, $this->secret, 0, $this->iv);
    }

    public function toArray(): array
    {
        return [
            'login' => $this->getLogin(),
            'password' => $this->getPassword()
        ];
    }

    static public function fromAssoc($data): UserModel
    {
        return new UserModel(
            $data['login'],
            $data['password']
        );
    }
}