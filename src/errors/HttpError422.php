<?php

namespace errors;

use vendor\Response;

class HttpError422 extends HttpError
{
    function __construct(private string $message)
    {}
    public function show_message()
    {
        return new Response(null, false, 422, $this->message);
    }
}