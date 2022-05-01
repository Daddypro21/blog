<?php

namespace App\Controllers;

use Core\Controller;
use Core\Models\Admin;

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
        if(isset($_SERVER['REQUEST_METHOD']) === "POST"){

            $users = (new Admin())->getByEmail(isset($_POST['email'])); 
            foreach($users as $user){
                    //var_dump($user['password']);die;
            if(password_verify(isset($_POST['password']),$user['password'])){

                    $_SESSION['id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['confirm_admin'] = $user['confirm_admin'];
                    header('Location:../blog/admin/posts');die;
                  
            }else{
                
                $this->error = "Mot de passe invalide";
                return $this->view('Default/admin/auth/login',["error"=>$this->error,"title" => "Connection"]);
            }
         }

        }
        

        return $this->view('Default/admin/auth/login',["error"=>$this->error,"title" => "Connection"]);

    }

    public function logout(){
        session_destroy();
        header('Location:../../blog/login');
    }


    
}