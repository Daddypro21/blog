<?php
namespace Core;

class SuperGlobals 
{
    public static function fromPost($post)
    {
       if(!empty($_POST[$post])){
           return $_POST[$post];
       }
       return null ;
    }

    public static function fromGet($get)
    {
        if(!empty($_GET[$get])){
            return $_GET[$get];
        }
        return null;
    }

    public static function fromSession($session)
    {
        if(!empty($_SESSION[$session])){
            return $_SESSION[$session];
        }
        return null;
    }

    public static function saveSession($keys,$value)
    {
        if(!empty($value)){
            return $_SESSION[$keys] = $value;
        }
    }

    public static function destroySession()
    {
        return session_destroy();
    }

    public static function server()
    {
        if(!empty($_SERVER['REQUEST_METHOD'])){
            return $_SERVER['REQUEST_METHOD'];
        }
        return null;
    }

}
