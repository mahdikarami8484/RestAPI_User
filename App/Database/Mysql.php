<?php

namespace App\Database;

use PDO;

class Mysql
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $name = DB_NAME;


    private static $connection;

    private static $setting = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    public static function connect($host = DB_HOST, $user = DB_USER , $password = DB_PASS , $database = DB_NAME)
    {
        if(!isset(self::$connection))
        {
            self::$connection = @new PDO("mysql:host=$host;dbname=$database",
                $user, $password, self::$setting);
        }
    }

    public static function queryOne($query, $params = array())
    {
        self::connect();
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function queryAll($query, $params = array())
    {
        self::connect();
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function querySingle($query, $params = array())
    {
        $result = self::queryOne($query, $params);
        if(!$result)
            return false;
        return $result[0];
    }

    public static function query($query, $params = array())
    {
        self::connect();
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->rowCount();
    }

}