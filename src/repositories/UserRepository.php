<?php

namespace repositories;

use models\UserModel;

class UserRepository extends BaseRepository
{
    public function get($id): ?UserModel
    {
        $sql = "SELECT `login`,`password` FROM `users` WHERE `id`=?";
        $result = $this->db->query($sql, [$id]);
        return $this->parseData($result, UserModel::class)[0] ?? null;
    }

    public function get_by_login($login): ?UserModel
    {
        $sql = "SELECT `login`,`password` FROM `users` WHERE `login`=?";
        $result = $this->db->query($sql, [$login]);
        return $this->parseData($result, UserModel::class)[0] ?? null;
    }

    public function create(UserModel $user)
    {
        $sql = "INSERT INTO `users`(`login`, `password`) VALUES(?, ?)";
        $this->db->query($sql, [$user->login, $user->password]);
    }

    public function check(UserModel $user): bool
    {
        $sql = "SELECT * FROM `users` WHERE `login`=? AND `password`=?";
        $result = $this->db->query($sql, [$user->login, $user->password]);
        return $result->num_rows == 1;
    }
}