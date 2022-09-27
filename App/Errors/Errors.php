<?php

namespace App\Errors;

class Errors
{
    public static function NotFound()
    {
        return http_response_code(404);
    }

    public static function NotAllow()
    {
        return http_response_code(405);
    }
}