<?php

namespace migrations;

use models\UserModel;

class Migration3 extends BaseMigration
{
    public function up()
    {
        $user = new UserModel('test', 'test', true);
        $sql = "INSERT INTO `data`.`users`(login, password) VALUES(?, ?)";
        $this->execute($sql, [$user->login, $user->password]);
    }

    public function down()
    {
        $sql = "DELETE FROM `data`.`users` WHERE `id`=1";
        $this->execute($sql);
    }
}