<?php

namespace migrations;

class Migration2 extends BaseMigration
{
    public function up()
    {
        $sql = "CREATE TABLE `data`.`records` (
            `id` INT AUTO_INCREMENT PRIMARY KEY, 
            `author_id` INT NOT NULL, 
            `text` TEXT NOT NULL,
            FOREIGN KEY (author_id) REFERENCES users (id)
            ON DELETE CASCADE)";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE `records`";
        $this->execute($sql);
    }
}