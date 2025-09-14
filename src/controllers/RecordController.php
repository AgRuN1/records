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
        $login = $_SESSION['login'] ?? null;
        if ($login === null || !$this->authService->auth($login)) {
            return (new HttpError401())->show_message();
        }
        $page = intval($params[0] ?? 1);
        $pageSize = intval($params[1] ?? 1);

        if ($page <= 0 || $pageSize <= 0) {
            return (new HttpError422('invalid pagination'))->show_message();
        }
        $author_id = $this->userRepository->get_id_by_login($login);
        $data = $this->recordRepository->all($author_id, $page, $pageSize);
        $records = [];
        foreach ($data as $record) {
            $records[] = $record->toArray();
        }
        return new Response($records);
    }
}