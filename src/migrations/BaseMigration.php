<?php

namespace migrations;

use database\MysqliSession;

abstract class BaseMigration
{
    private MysqliSession $db;
    public function __construct()
    {
        $this->db = new MysqliSession();
    }

    protected function execute($sql, $params = [])
    {
        $this->db->query($sql, $params);
    }

    abstract public function up();

    abstract public function down();
}