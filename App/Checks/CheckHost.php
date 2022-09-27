<?php

namespace App\Checks;

use App\Errors\Errors;
use App\Messages\Send;

class CheckHost
{
    public static function checkHost()
    {
        if($_SERVER['HTTP_HOST'] != DB_HOST)
        {
            echo Send::SendNotFound();
            return Errors::NotFound();
        }
        return false;
    }
}