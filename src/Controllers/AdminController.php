<?php

namespace App\Controllers;

use Core\Controller;
use Core\Models\Admin;
use Core\SuperGlobals;

/**
 * Creation de la class AdminController pour l'authentification des administrateur
 * methode login pour se connecter à l'administration
 * methode logout pour se deconnecter et suppression des variables de session
 */

class AdminController extends Controller 
{
    public $error = null;
    public function login()
    {
        if((new SuperGlobals())->server() === "POST"){

            $users = (new Admin())->getByEmail((new SuperGlobals())->fromPost('email')); 
            foreach($users as $user){
            if(password_verify((new SuperGlobals())->fromPost('password'),$user['password'])){

                    (new SuperGlobals())->saveSession('id',$user['id']) ;
                    (new SuperGlobals())->saveSession('email',$user['email']);
                    (new SuperGlobals())->saveSession('first_name',$user['first_name']);
                    (new SuperGlobals())->saveSession('confirm_admin',$user['confirm_admin']);

                    $token =(new SuperGlobals())->saveSession('token',md5(rand(100,10000)));
                    $data =[
                        'token'=>$token,
                        'id'=>$user['id']
                    ];
                    $users = (new Admin())->addToken($data);
                    if(!empty($users)){
                        header('Location:../blog/admin/posts');
                        exit();
                        //var_dump($_SESSION['token']);die;
                    }
                    
            }else{
                
                $this->error = "Mot de passe invalide";
                return $this->view('Default/admin/auth/login',["error"=>$this->error,"title" => "Connection"]);
            }
         }

        }
        

        return $this->view('Default/admin/auth/login',["error"=>$this->error,"title" => "Connection"]);

    }

    public function logout(){
        (new SuperGlobals())->destroySession();
        header('Location:../../blog/login');
    }


    
}