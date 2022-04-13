<?php
namespace Core;

class Route
{
    private static $request;

    public static function get(string $path , string $action)
    {
        $routes = new Request($path,$action);
        self::$request['GET'][] = $routes;
        return $routes;
    }
    public static function post(string $path,string $action)
    {
        $routes = new Request($path,$action);
        self::$request['POST'][] = $routes;
        return $routes;

    }
    public static function run()
    {
        foreach(self::$request[$_SERVER['REQUEST_METHOD']] as $route){
            
            if($route->matchs(trim($_GET['url']),'/')){
                $route->execute();
                die;
            }
        }
        header('HTTP/1.0 404 not found');
    }
}