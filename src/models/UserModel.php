<?php

namespace models;


class UserModel extends BaseModel
{
    function __construct(
        private string $login,
        private string $password
    )
    {}

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
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