<?php

namespace App\Tokens;

use App\Messages\Send;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenJwt
{
    public static function createToken(array $data)
    {
        $payload = $data;
        $payload['iss'] = "";
        $payload['createdTime'] = time();
        $payload['expirationTime'] = time()+60*60*24*30;
        $token = JWT::encode($payload, HASH_KEY,'HS256');
        return $token;
    }

    public static function decodeToken(string $token)
    {
        $userInfo = JWT::decode($token, new Key(HASH_KEY, "HS256"));
        if($userInfo->expirationTime <= time())
        {
            return "expired";
        }
        return $userInfo;
    }
}