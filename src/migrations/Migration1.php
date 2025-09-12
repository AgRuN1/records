<?php

namespace migrations;

class Migration1 extends BaseMigration
{
    public function up()
    {
        $sql = "CREATE TABLE `data`.`users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY, 
            `login` VARCHAR(40) NOT NULL UNIQUE, 
            `password` VARCHAR(40) NOT NULL)";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE `users`";
        $this->execute($sql);
    }
}