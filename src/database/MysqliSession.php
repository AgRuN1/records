<?php

namespace database;

class MysqliSession
{
    private $link = null;
    public function __construct()
    {
        $host = getenv('MYSQL_HOST');
        $port = getenv('MYSQL_PORT');
        $user = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');
        $database = getenv('MYSQL_DATABASE');

        $this->link = new \mysqli($host, $user, $password, $database, $port);
        if ($this->link->connect_error) {
            die($this->link->connect_error);
        }
    }

    public function query($sql, $params = [])
    {
        return $this->link->execute_query($sql, $params);
    }

    public function __destruct()
    {
        $this->link->close();
    }
}

?>