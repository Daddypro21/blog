<?php

namespace App\Controllers;

use Core\Mail\Mail;
use Core\Controller;
use Core\Models\Member;
use Core\Mail\MailMessage;

/**
 * Creation de la class MemberController pour gerer l'authentification
 * methode connection pour gerer la connection au Blog si on est dejà membre
 * methode register pour gerer l'inscription d'un nouveau membre
 * methode logout pour la deconnection /suppression des variables de session
 */
class MemberController extends Controller 
{
    public $error = null;
    

    public function connection()
    {

        $linkContact = 'contact';
        $linkPost = ' posts ';
        $linkHome = ' /blog/ ';

        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $email = \htmlspecialchars($_POST['email']);
            $password = \htmlspecialchars($_POST['password']);
            $members = (new Member())->getByEmail($email);
            foreach($members as $member);
            if(!empty($member)){
                if(password_verify($password,$member['passwords'])){

                    $_SESSION['id'] = $member['id'];
                    $_SESSION['email'] = $member['email'];
                    $_SESSION['confirm_member'] = $member['confirm_member'];
                   
                    header('Location:../blog');die;
                  
                }
                $this->error = "Mot de passe invalide";
                return $this->view('Default/connection',["error"=>$this->error,"title" => "Se connecter",
                "linkHome"=>$linkHome,"linkPost"=>$linkPost,"linkContact"=>$linkContact]);
                
            }else{
                $this->error = "Cet utilisateur n'existe pas !!";
                return $this->view('Default/connection',["error"=>$this->error,"title" => "Se connecter",
                "linkHome"=>$linkHome,"linkPost"=>$linkPost,"linkContact"=>$linkContact]);
            }
        }
        return $this->view('Default/connection',["error"=>$this->error,"title" => "Se connecter",
        "linkHome"=>$linkHome,"linkPost"=>$linkPost,"linkContact"=>$linkContact]);
    }

    public function register()
    {
        $linkContact = 'contact';
        $linkPost = ' posts ';
        $linkHome = ' /blog/ ';

        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $email = \htmlspecialchars($_POST['email']);
            $firstName = \htmlspecialchars($_POST['first_name']);
            $lastName = \htmlspecialchars($_POST['last_name']);
            $password = \htmlspecialchars($_POST['password']);
            $password = \password_hash($password,null);

            $cle = $password;
            $member = (new Member())->getByEmail($email);
    
            if(empty($member) && filter_var($email, FILTER_VALIDATE_EMAIL)){
                $mailMessage = new MailMessage();

                $url = "http://localhost/blog/verification";
                $codeConfirmation = $cle ;
                $name = $firstName;
                $email = $email;

                $message = $mailMessage->message($url,$codeConfirmation,$name);

                //Send mail
                $mail = new Mail();

                $to = $email;
                $subject = "Email de validation de compte";
                $message = $message;
                $headers ="";
                $headers .= "From: Sndemapro@gmail.com" . "\r\n" ;
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                "CC:". $email;
                $response = $mail->sendMail($to,$subject,$message,$headers);

                if($response){
                    $member = new Member();
                   $response = $member->register([
                        "first_name"=>$firstName,
                        "last_name"=>$lastName,
                        "email"=>$email,
                        "password"=>$password,
                        "cle"=>$cle ]);
                        if($response){

                            header('Location:../blog/verification');die;
                        }
                }      
            }else{
                $error = "Cet email existe déjà !!";
                $this->error = "Cet email existe déjà";
                return $this->view('Default/register',["error"=>$this->error,"title" => "S'inscrire",
            "linkHome"=>$linkHome,"linkPost"=>$linkPost,"linkContact"=>$linkContact]);
            }

        }
        return $this->view('Default/register',["error"=>$this->error,"title" => " S'inscrire",
        "linkHome"=>$linkHome,"linkPost"=>$linkPost,"linkContact"=>$linkContact]);
    }

    public function logout()
    {
        session_destroy();
        header('Location:/blog');
    }


    
}