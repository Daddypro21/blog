<?php
namespace Core;

class SuperGlobals 
{
    public function __construct()
    {

    }
    public static function fromPost($post)
    {
       if(!empty($_POST)){
           return $_POST[$post];
       }
       return null ;
    }

    public function fromGet($get)
    {
        if(!empty($_GET)){
            return $_GET[$get];
        }
        return null;
    }

    public function fromSession($session)
    {
        if(!empty($_SESSION[$session])){
            return $_SESSION[$session];
        }
        return null;
    }

    public function saveSession($keys,$value)
    {
        if(!empty($value)){
            return $_SESSION[$keys]= $value; 
        }
    }

    public function destroySession()
    {
        return session_destroy();
    }

    public function server()
    {
        if(!empty($_SERVER['REQUEST_METHOD'])){
            return $_SERVER['REQUEST_METHOD'];
        }
        return null;
    }

}
