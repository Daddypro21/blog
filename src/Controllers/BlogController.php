<?php
namespace App\Controllers;


use Core\Controller;
use DB\DBConnection;
use App\HttpRequest\HttpRequest;

class BlogController extends Controller 
{
    public function index()
    {
        $db = new DBConnection();
        $req = $db->getPDO()->query("SELECT * FROM posts");          
        $posts = $req->fetchAll();

        return $this->view('Default/home/index',["title" => "post","posts"=>$posts]);
        
    }

    public function show($id)
    {
        return $this->view('Default/post',["title"=>"post","id"=>$id]);
    }
    public function create(HttpRequest $request)
    {
        $request->all();
    }

    public function showAll()
    {
        $db = new DBConnection();
        $req = $db->getPDO()->query("SELECT * FROM posts");          
        $posts = $req->fetchAll();

        return $this->view('Default/posts',["title" => "posts","posts"=>$posts]);

    }
}