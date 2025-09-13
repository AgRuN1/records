<?php

namespace controllers;
use errors\HttpError401;
use repositories\RecordRepository;
use repositories\UserRepository;

class RecordController extends BaseController
{
    public string $name = 'records';

    public function __construct(
        private RecordRepository $recordRepository,
        private UserRepository $userRepository
    )
    {}

    public function all($params)
    {
        session_start();
        $login = $_SESSION['login'] ?? null;
        if ($login === null) {
            return (new HttpError401())->show_message();
        }
        $author_id = $this->userRepository->get_id_by_login($login);
        if ($author_id === null) {
            return (new HttpError401())->show_message();
        }
        $page = intval($params[0] ?? 1);
        $pageSize = intval($params[1] ?? 1);

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