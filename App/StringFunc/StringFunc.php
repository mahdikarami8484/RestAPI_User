<?php

namespace App\StringFunc;

class StringFunc
{

    public static function entities($string)
    {
        return htmlentities($string);
    }

    public static function generatePass($string)
    {
        return hash('sha256', $string);
    }
}