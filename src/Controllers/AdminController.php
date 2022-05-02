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
        if(SuperGlobals::server() === "POST"){

            $users = (new Admin())->getByEmail(SuperGlobals::fromPost('email')); 
            foreach($users as $user){
            if(password_verify(SuperGlobals::fromPost('password'),$user['password'])){

                    SuperGlobals::saveSession('id',$user['id']) ;
                    SuperGlobals::saveSession('email',$user['email']);
                    SuperGlobals::saveSession('first_name',$user['first_name']);
                    SuperGlobals::saveSession('confirm_admin',$user['confirm_admin']);
                    header('Location:../blog/admin/posts');exit();
                  
            }else{
                
                $this->error = "Mot de passe invalide";
                return $this->view('Default/admin/auth/login',["error"=>$this->error,"title" => "Connection"]);
            }
         }

        }
        

        return $this->view('Default/admin/auth/login',["error"=>$this->error,"title" => "Connection"]);

    }

    public function logout(){
        SuperGlobals::destroySession();
        header('Location:../../blog/login');
    }


    
}