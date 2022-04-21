<?php

namespace App\Controllers\Admin;


use Core\Controller;
use Core\Models\Post;

class PostController extends Controller
{

    public function index()
    {
        $posts = (new Post())->all();
        return $this->view('Default/admin/post/index',["posts"=>$posts,"title"=>"Administration"]);
    }

    public function destroy($object,$id)
    {
        $post = new Post();
        $result = $post->destroy($id);

        if($result){
            return header('Location: blog/admin/posts');
        }
    }

    public function edit($id)
    {
        $posts = (new Post())->findById($id);

        return $this->view('Default/admin/post/edit',["posts"=>$posts,"id"=>$id,"title"=>"Modifier un article"]);
    }

    public function update($object,$id)
    {
        $post = new Post();
        $result = $post->update($id, $_POST);

        if($result){

            header('Location: ../../../../blog/admin/posts');
        }
    }

    public function create()
    {
        return $this->view('Default/admin/post/create',
        ["title"=>"Créer un nouvel article"]);

    }

    public function createPost()
    {
        
    }

}