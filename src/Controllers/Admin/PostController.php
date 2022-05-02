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
        (new SuperGlobals())->fromSession('confirm_admin') ?? header('Location:../../blog/login');
        $posts = (new Post())->all();
        return $this->view('Default/admin/post/index',["posts"=>$posts,"title"=>"Administration",
        "confirmAdmin"=>(new SuperGlobals())->fromSession('confirm_admin')]);
        
    }

    public function destroy($id)
    {
        (new SuperGlobals())->fromSession('confirm_admin') ?? header('Location:../../blog/login');
        $post = new Post();
        $result = $post->destroy($id);

        if($result){
            return header('Location:../../../../blog/admin/posts');
        }
    }

    public function edit($id)
    {
        (new SuperGlobals())->fromSession('confirm_admin') ?? header('Location:../../../../blog/login');
        $posts = (new Post())->findById($id);

        return $this->view('Default/admin/post/edit',["posts"=>$posts,"id"=>$id,"title"=>"Modifier un article",
        "confirmAdmin"=>(new SuperGlobals())->fromSession('confirm_admin')]);
    }

    public function update($id)
    {
        (new SuperGlobals())->fromSession('confirm_admin') ?? header('Location:../../blog/login');
        $post = new Post();
        $data=[
            "title"=>filter_input(INPUT_POST,'title'),
            "content"=>filter_input(INPUT_POST,'content'),
            "chapo"=>filter_input(INPUT_POST,'chapo')
            ];
        $result = $post->update($id, $data);

        if($result){

            header('Location: ../../../../blog/admin/posts');
        }
    }

    public function create()
    {
        (new SuperGlobals())->fromSession('confirm_admin') ?? header('Location:../../../blog/login');
        return $this->view('Default/admin/post/create',
        ["title"=>"Créer un nouvel article","confirmAdmin" =>(new SuperGlobals())->fromSession('confirm_admin')]);

    }

    public function createPost()
    {
        (new SuperGlobals())->fromSession('confirm_admin') ?? header('Location:../../../blog/login');
        $post = new Post();
        $data=[
        "title"=>filter_input(INPUT_POST,'title'),
        "content"=>filter_input(INPUT_POST,'content'),
        "chapo"=>filter_input(INPUT_POST,'chapo')
        ];
        $result = $post->createPost((new SuperGlobals())->fromSession('id'),$data);

        if($result){
            header('Location: ../../../../blog/admin/posts');
        }
    }

}