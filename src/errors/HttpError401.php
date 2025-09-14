<?php

namespace errors;

use vendor\Response;

class HttpError401 extends HttpError
{
    public function show_message()
    {
        return new Response(null, false, 401, 'Not logged in');
    }
}