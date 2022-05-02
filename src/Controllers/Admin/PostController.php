<?php

namespace App\Controllers\Admin;


use Core\Controller;
use Core\Models\Post;
use Core\SuperGlobals;

/**
 * Creation de la class PostController pour gerer l'administration
 * methode index affiche la liste des articles créés
 * methode destroy qui pourrait etre un delete à la place supprime un article
 * methode edit crée un nouvel article
 * methode update modifie un article
 */

class PostController extends Controller
{
    

    public function index()
    {
        SuperGlobals::fromSession('confirm_admin') ?? header('Location:../../blog/login');
        $posts = (new Post())->all();
        return $this->view('Default/admin/post/index',["posts"=>$posts,"title"=>"Administration",
        "confirmAdmin"=>SuperGlobals::fromSession('confirm_admin')]);
        
    }

    public function destroy($id)
    {
        SuperGlobals::fromSession('confirm_admin') ?? header('Location:../../blog/login');
        $post = new Post();
        $result = $post->destroy($id);

        if($result){
            return header('Location:../../../../blog/admin/posts');
        }
    }

    public function edit($id)
    {
        SuperGlobals::fromSession('confirm_admin') ?? header('Location:../../../../blog/login');
        $posts = (new Post())->findById($id);

        return $this->view('Default/admin/post/edit',["posts"=>$posts,"id"=>$id,"title"=>"Modifier un article",
        "confirmAdmin"=>SuperGlobals::fromSession('confirm_admin')]);
    }

    public function update($id)
    {
        SuperGlobals::fromSession('confirm_admin') ?? header('Location:../../blog/login');
        $post = new Post();
        $result = $post->update($id, $_POST);

        if($result){

            header('Location: ../../../../blog/admin/posts');
        }
    }

    public function create()
    {
        SuperGlobals::fromSession('confirm_admin') ?? header('Location:../../../blog/login');
        return $this->view('Default/admin/post/create',
        ["title"=>"Créer un nouvel article","confirmAdmin" =>SuperGlobals::fromSession('confirm_admin')]);

    }

    public function createPost()
    {
        SuperGlobals::fromSession('confirm_admin') ?? header('Location:../../../blog/login');
        $post = new Post();
        $result = $post->createPost(SuperGlobals::fromSession('id'),$_POST);

        if($result){
            header('Location: ../../../../blog/admin/posts');
        }
    }

}