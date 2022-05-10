<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Core\Controller;

/**
 * class NotFoundException extends de la class Exception pour gerer les erreur
 * 
 */

class NotFoundException extends Exception 
{
    public function __construct($message = "",$code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);

    }
    
    public function error404()
    {
        \http_response_code(404);
        $controllerView = new Controller();
        return $controllerView->view('Default/errors/error404',["title" => "error404"]);
    }
}