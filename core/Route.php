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
        if((new SuperGlobals())->server() ){
            foreach(self::$request[(new SuperGlobals())->server()] as $route){
                
                $getUrl = ((new SuperGlobals())->fromGet('url')) ?? null ;
                if($route->matchs(trim($getUrl),'/')){
                    $route->execute();
                    die;
                }
            }

        }
        
       throw new NotFoundException("La page demandée n'existe pas !");
    }
}