<?php

namespace controllers;
use repositories\RecordRepository;

class RecordController extends BaseController
{
    public string $name = 'records';

    public function __construct(
        private RecordRepository $recordRepository
    )
    {}

    public function all($params)
    {
        var_dump($_COOKIE);
        $author_id = $params[0] ?? null;
        $page = intval($params[1] ?? 1);
        $pageSize = intval($params[2] ?? 1);

        if(!$this->validate_int($author_id)) {
            return [
                'error' => 'invalid author_id'
            ];
        }
        if ($page <= 0 || $pageSize <= 0) {
            return [
                'error' => 'invalid pagination'
            ];
        }
        $data = $this->recordRepository->all($author_id, $page, $pageSize);
        $records = [];
        foreach ($data as $record) {
            $records[] = $record->toArray();
        }
        return [
            'data' => $records
        ];
    }
}