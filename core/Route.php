<?php
namespace Core;

use App\Exceptions\NotFoundException;

/**
 * Creation de la class Route pour gerer nos routes : Routeur du site
 * 
 */

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
        if(isset($_SERVER['REQUEST_METHOD'])){
            foreach(self::$request[$_SERVER['REQUEST_METHOD']] as $route){
            
                if($route->matchs(trim($_GET['url']),'/')){
                    $route->execute();
                    die;
                }
            }

        }
       throw new NotFoundException("La page demandée n'existe pas !");
    }
}