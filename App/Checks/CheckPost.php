<?php

namespace App\Checks;

use App\Errors\Errors;
use App\Messages\Send;

class CheckPost
{
    public static function checkPost(array $value)
    {
        foreach ($value as $v)
        {
            if (!isset($_POST[$v])) {
                echo Send::SendNotFound();
                return Errors::NotFound();
            }
            return false;
        }
    }
}