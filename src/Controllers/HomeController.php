<?php
namespace App\Controllers;


use Core\Controller;
use App\HttpRequest\HttpRequest;

class HomeController extends Controller
{
    public function index()
    {
        

        return $this->view('Default/home/index',["title" => "Accueil"]);
    }

    public function show($id)
    {
        echo "Bonjour je suis ma page show : et voici les params : $id";
    }
    public function create(HttpRequest $request)
    {
        $request->all();
    }
}