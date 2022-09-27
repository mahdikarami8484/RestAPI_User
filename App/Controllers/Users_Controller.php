<?php

namespace App\Controllers;

use App\Checks\CheckHost;
use App\Checks\CheckPost;
use App\Errors\Errors;
use App\Messages\Send;
use App\Models\Users_Models;
use App\Models\Users_Models as user;
use App\Database\Mysql;
use App\Requests\Requests;
use App\StringFunc\StringFunc;
use App\Tokens\TokenJwt;

class Users_Controller
{

    public function index($function, $user_hash)
    {
        if(!method_exists($this, $function))
        {
            Send::SendNotFound();
            return Errors::NotFound();
        }
        return $this->$function($user_hash);
    }

    public function test(){
        $parameters = [
            "email" => "mahdi",
            "password" => "1234"
        ];
        Requests::SendPost("http://localhost/MusicAPI/user/login", $parameters);
        echo("http://".$_SERVER['HTTP_HOST']."/MusicAPI/user/login");
    }

    public function login()
    {
        if(CheckHost::checkHost()) return;
        if(CheckPost::checkPost(['email', 'password'])) return;
        $password = hash('sha256',htmlentities($_POST['password']));
        $email = htmlentities($_POST['email']);
        $check = Users_Models::userExists($email, $password);
        if($check == null || count($check) > 1)
        {
            Send::SendNotFound();
            return Errors::NotFound();
        }

        Send::SendMessage(TokenJwt::createToken($check[0]), true);
        return 1;
    }

    public function register()
    {
        if(CheckHost::checkHost()) return;
        if(CheckPost::checkPost(['name', 'email', 'password'])) return;
        $name = StringFunc::entities($_POST['name']);
        $email = StringFunc::entities($_POST['email']);
        $password = StringFunc::generatePass($_POST['password']);
        $data = array(null, $name, $email, $password, 0, 0, time());
        $row = Mysql::query('SELECT * FROM users WHERE email=?', array($email));
        if($row > 0)
        {
            Send::SendMessage("This email is already registered.", false);
            return Errors::NotFound();
        }
        $parameters = [
            "email" => $email,
            "password" => htmlentities($_POST["password"])
        ];
        if(Users_Models::create($data))
        {
            Requests::SendPost("http://".$_SERVER['HTTP_HOST']."/MusicAPI/user/login", $parameters);
            return 1;
        }
        Send::SendNotFound();
        return Errors::NotFound();
    }

    public function showAllUsers()
    {
        if(!Users_Models::CheckAdmin(self::getUserInfo()))
        {
            Send::SendNotFound();
            return Errors::NotFound();
        }
        $data = Mysql::queryAll("SELECT * FROM users ORDER BY name");
        Send::SendMessage($data, true);
    }

    public function showUserInfo()
    {
        Send::SendMessage(self::getUserInfo(), true);
    }

    private static function getUserInfo()
    {
        if(CheckHost::checkHost()) return;
        if(CheckPost::checkPost(['token'])) return;
        $token = $_POST['token'];
        $userInfo = TokenJwt::decodeToken($token);
        if($userInfo == null)
        {
            Send::SendNotFound();
            return http_response_code(404);
        }
        if($userInfo == "expired")
        {
            Send::SendMessage("The token has expired", false);
            return Errors::NotFound();
        }
        return Users_Models::userExists($userInfo->email, $userInfo->password)[0];
    }

}