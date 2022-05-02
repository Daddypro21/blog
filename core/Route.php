<?php
namespace Core;

use App\Exceptions\NotFoundException;

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
        if(SuperGlobals::server()){
            foreach(self::$request[SuperGlobals::server()] as $route){
                if($route->matchs(trim(SuperGlobals::fromGet('url')),'/')){
                    $route->execute();
                    die;
                }
            }
        }
        
       throw new NotFoundException("La page demandée n'existe pas !");
    }
}