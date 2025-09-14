<?php

namespace controllers;
use errors\HttpError401;
use errors\HttpError422;
use repositories\RecordRepository;
use repositories\UserRepository;
use services\AuthService;
use vendor\Response;

class RecordController
{
    public string $name = 'records';

    public function __construct(
        private RecordRepository $recordRepository,
        private UserRepository $userRepository,
        private AuthService $authService
    )
    {}

    public function all($params)
    {
        $login = $this->authService->auth();
        if ($login === null) {
            return (new HttpError401())->show_message();
        }
        $page = intval($params[0] ?? 1);
        $pageSize = intval($params[1] ?? 1);

        if ($page <= 0 || $pageSize <= 0) {
            return (new HttpError422('Некорректная пагинация'))->show_message();
        }
        $author_id = $this->userRepository->get_id_by_login($login);
        $data = $this->recordRepository->all($author_id, $page, $pageSize);
        $records = [];
        foreach ($data as $record) {
            $records[] = $record->toArray();
        }
        $count = $this->recordRepository->count($author_id);
        $pages = ceil($count / $pageSize);
        return new Response(['records' => $records, 'pages' => $pages]);
    }
}