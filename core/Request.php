<?php
namespace Core;
use App\Controllers;


/**
 * La class Request gere la logique de notre routeur 
 */

class Request
{
    private $path;
    private $action;
    private $params=[];
    

    public function __construct(string $path,string $action)
    {
        $this->path = trim($path,'/');
        $this->action = $action;
    }

    public function matchs($url)
    {
        $path = preg_replace("#({[\w]+})#","([^/]+)",$this->path);
        $pathToMatch = "#^$path$#";
        if(preg_match($pathToMatch,$url,$results)){
            array_shift($results);
            $this->params = $results;
            return true;
        }else{
            return false;
        }
    }

    public function execute()
    {

        if((new SuperGlobals)->server() === "GET"){

           $this->getRequest();

        }else{

           $this->postRequest();

        }
    }

    public function getRequest()
    {
        if(is_string($this->action)){
            $action = explode('@',$this->action);
            $controller = $action[0];
            $controller = new $controller();
            $method = $action[1];

            return isset($this->params) ? $controller->$method(implode($this->params)) : $controller->$method();
        }else{
            call_user_func_array($this->action,$this->params);
        }
    }

    public function postRequest()
    {
        if(is_string($this->action)){
            $action = explode('@',$this->action);
            $controller = $action[0];
            $controller = new $controller();
            $method = $action[1];  
            
            return isset($this->params) ? $controller->$method(implode($this->params)) : $controller->$method();
        }else{
            call_user_func_array($this->action,$this->params);
        }
    }
}