<?php
namespace Core;


class Controller 
{
    
    public function view($path, $data=[])
    {
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        
        print_r( $twig->render($path.'.html.twig',  $data));
    }

    
}