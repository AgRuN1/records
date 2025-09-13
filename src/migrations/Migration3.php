<?php

namespace migrations;

use models\UserModel;
use services\CryptService;

class Migration3 extends BaseMigration
{
    public function up()
    {
        $cryptService = new CryptService();
        $sql = "INSERT INTO `data`.`users`(login, password) VALUES(?, ?)";
        $this->execute($sql, [$cryptService->encrypt('test'), $cryptService->encrypt('test')]);
    }

    public function down()
    {
        $sql = "DELETE FROM `data`.`users` WHERE `id`=1";
        $this->execute($sql);
    }
}