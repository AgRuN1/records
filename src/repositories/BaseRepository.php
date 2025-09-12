<?php

namespace repositories;

use database\MysqliSession;
use models\BaseModel;
use models\RecordModel;

abstract class BaseRepository
{
    protected MysqliSession $db;

    public function __construct(MysqliSession $session)
    {
        $this->db = $session;
    }

    protected function parseData(\mysqli_result $data, $model): array
    {
        $result = [];
        for ($i = 0; $i < $data->num_rows; ++$i) {
            $record = $model::fromAssoc($data->fetch_assoc());
            $result[] = $record;
        }
        return $result;
    }
}