<?php
namespace App\Controllers;


use App\Models\Post;
use Core\Controller;
use DB\DBConnection;
use App\HttpRequest\HttpRequest;

class BlogController extends Controller 
{

    public function index()
    {
        $linkPost = ' posts ';
        $linkHome = ' /blog/ ';

        $db = new DBConnection();
        $req = $db->getPDO()->query("SELECT * FROM posts");          
        $posts = $req->fetchAll();

        return $this->view('Default/home/index',["title" => "post","posts"=>$posts,
        "linkPost"=>$linkPost,"linkHome"=>$linkHome]);
        
    }

    public function show($id)
    {
        $linkPost = ' ../posts ';
        $linkHome = ' /blog/ ';

        $post = new Post();
        $posts = $post->findById($id);

        return $this->view('Default/post',["title"=>"post","posts"=>$posts,"linkPost"=>$linkPost,"linkHome"=>$linkHome]);
    }
    public function create(HttpRequest $request)
    {
        $request->all();
    }

    public function showAll()
    {
        $linkPost = ' posts ';
        $linkHome = ' /blog/ ';

        $post = new Post();
        $posts = $post->all();

        return $this->view('Default/posts',["title" => "posts","posts"=>$posts,"linkPost"=>$linkPost,"linkHome"=>$linkHome]);

    }
}