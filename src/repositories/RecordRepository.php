<?php

namespace repositories;

use models\RecordModel;

class RecordRepository extends BaseRepository
{
    public function all($author_id, $page, $pageSize): array
    {
        $sql = "SELECT `author_id`, `text` FROM `records` WHERE `author_id` = ? LIMIT ?, ?";
        $result = $this->db->query($sql, [$author_id, ($page - 1) * $pageSize, $pageSize]);
        return $this->parseData($result, RecordModel::class);
    }

    public function count($author_id): int
    {
        $sql = "SELECT COUNT(*) as c FROM `records` WHERE `author_id` = ?";
        $result = $this->db->query($sql, [$author_id]);
        return $result->fetch_assoc()['c'];
    }
}