<?php

namespace App\Requests;

class Requests
{
    public static function SendPost($url, array $data)
    {
        $parameters = http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        //curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        var_dump($res);
    }
}