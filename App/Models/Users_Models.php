<?php

namespace App\Models;

use App\Database\Mysql;
use App\Errors\Errors;
use App\Messages\Send;
use mysql_xdevapi\RowResult;
use mysql_xdevapi\SqlStatement;

class Users_Models
{
    protected static $id;
    protected static $name;
    protected static $email;
    protected static $pass;
    protected static $admin;
    protected static $prem;

    // Get Methods
    public static function getID()
    {
        return self::$id;
    }

    public static function getName()
    {
        return self::$name;
    }

    public static function getEamil()
    {
        return self::$email;
    }

    public static function getPass()
    {
        return self::$pass;
    }

    public static function getAdmin()
    {
        return self::$admin;
    }

    public static function getPrem()
    {
        return self::$prem;
    }

    // Set Methods
    public static function setId($id)
    {
        self::$id = $id;
    }

    public static function setName($name)
    {
        self::$name = $name;
    }

    public static function setEmail($email)
    {
        self::$email = $email;
    }

    public static function setPass($pass)
    {
        self::$pass = $pass;
    }

    public static function setAdmin($admin)
    {
        self::$admin = $admin;
    }

    public static function setPrem($prem)
    {
        self::$prem = $prem;
    }

    // CRUD OPERATIONS
    public static function create(array $data)
    {
        $data = Mysql::query('INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `premium`, `time`) VALUES (?, ?, ?, ?, ?, ?, ?);', $data);
        return $data;
    }

    public static function read($id)
    {
        $data = Mysql::queryAll("SELECT * FROM users WHERE id=?", array($id));
        if($data == null) return $data;
        self::setId($data[0]['id']);
        self::setName($data[0]['name']);
        self::setEmail($data[0]['email']);
        self::setPass($data[0]['password']);
        self::setPrem($data[0]['premium']);
        return $data;
    }

    public static function userExists($email, $password)
    {
        $data = Mysql::queryAll("SELECT * FROM users WHERE email=? AND password=?", array(htmlentities($email), htmlentities($password)));
        if($data == null) return $data;
        self::setId($data[0]['id']);
        self::setName($data[0]['name']);
        self::setEmail($data[0]['email']);
        self::setPass($data[0]['password']);
        self::setPrem($data[0]['premium']);
        return $data;
    }

    public static function update(int $id, array $data)
    {

    }

    public static function delete(int $id)
    {

    }


    public static function CheckAdmin($userInfo)
    {
        if($userInfo == null)
        {
            Send::SendNotFound();
            return Errors::NotFound();
        }
        if($userInfo['admin'] == 1)
            return true;
        else
            return false;
    }
}