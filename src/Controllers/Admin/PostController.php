<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use Core\Controller;

class PostController extends Controller
{

    public function index()
    {
        $posts = (new Post('posts'))->all();
        return $this->view('Default/admin/post/index',["posts"=>$posts,"title"=>"Administration"]);
    }

    public function destroy($object,$id)
    {
        $post = new Post('posts');
        $result = $post->destroy($id);

        if($result){
            return header('Location: blog/admin/posts');
        }
    }

    public function edit($id)
    {
        $posts = (new Post('posts'))->findById($id);

        return $this->view('Default/admin/post/edit',["posts"=>$posts,"id"=>$id,"title"=>"Modifier un article"]);
    }

    public function update($object,$id)
    {
        $post = new Post('posts');
        $result = $post->update($id, $_POST);

        if($result){

            header('Location: ../../../../blog/admin/posts');
        }
    }

}