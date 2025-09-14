<?php

namespace errors;

use vendor\Response;

class HttpError404 extends HttpError
{
    public function show_message()
    {
        return new Response(null, false, 404, 'Страница не найдена');
    }
}