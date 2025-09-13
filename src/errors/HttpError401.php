<?php

namespace errors;

class HttpError401 extends HttpError
{
    public function show_message()
    {
        return [
            'error' => 401,
            'message' => 'not logged in'
        ];
    }
}