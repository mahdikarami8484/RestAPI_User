<?php

namespace App\Messages;

class Send
{
    public static function SendMessage($message, bool $status)
    {
        echo json_encode(["message" => $message, "status" => $status], JSON_PRETTY_PRINT);
    }

    public static function SendNotFound()
    {
        self::SendMessage("Not Found", false);
    }
}