<?php

namespace repositories;

use database\MysqliSession;
use models\UserModel;
use services\CryptService;

class UserRepository extends BaseRepository
{
    private CryptService $cryptService;

    function __construct(MysqliSession $session, CryptService $cryptService)
    {
        $this->cryptService = $cryptService;
        parent::__construct($session);
    }

    public function get($id): ?UserModel
    {
        $sql = "SELECT `login`,`password` FROM `users` WHERE `id`=?";
        $result = $this->db->query($sql, [$id]);
        if ($result->num_rows > 0) {
            $user = $this->parseData(
                $result,
                UserModel::class
            )[0];
            return $this->cryptService->decrypt_user($user);
        }
        return null;
    }

    public function get_id_by_login(string $login): ?int
    {
        $sql = "SELECT `id` FROM `users` WHERE `login`=?";
        $result = $this->db->query($sql, [$this->cryptService->encrypt($login)]);
        return $result->fetch_assoc()['id'] ?? null;
    }

    public function create(UserModel $user)
    {
        $login = $this->cryptService->encrypt($user->getLogin());
        $password = $this->cryptService->encrypt($user->getPassword());
        $sql = "INSERT INTO `users`(`login`, `password`) VALUES(?, ?)";
        $this->db->query($sql, [$login, $password]);
    }

    public function check(UserModel $user): bool
    {
        $sql = "SELECT * FROM `users` WHERE `login`=? AND `password`=?";
        $result = $this->db->query($sql, [
            $this->cryptService->encrypt($user->getLogin()),
            $this->cryptService->encrypt($user->getPassword())
        ]);
        return $result->num_rows == 1;
    }
}