<?php

namespace errors;

class HttpError404 extends HttpError
{
    public function show_message()
    {
        return [
            'error' => 404,
            'message' => 'Not Found'
        ];
    }
}