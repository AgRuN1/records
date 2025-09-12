<?php

namespace migrations;

class Migration4 extends BaseMigration
{
    public function up()
    {
        $sql = "INSERT INTO `data`.`records`(author_id, text) 
            VALUES(1, 'test1'), (1, 'test2')";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DELETE FROM `data`.`records` WHERE `authtor_id`=1";
        $this->execute($sql);
    }
}