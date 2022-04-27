<?php

namespace App\Controllers;

use Core\Mail\Mail;
use Core\Controller;
use Core\Models\Member;
use Core\Mail\MailMessage;

class MemberController extends Controller 
{
    public $error = null;
    

    public function connection()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $email = \htmlspecialchars($_POST['email']);
            $password = \htmlspecialchars($_POST['password']);
            $members = (new Member())->getByEmail($email);
            foreach($members as $member);
            if(!empty($member)){
                if(password_verify($password,$member['passwords'])){

                    $_SESSION['id'] = $member['id'];
                    $_SESSION['email'] = $member['email'];
                   
                    header('Location:../blog');die;
                  
                }else{ 
                $this->error = "Mot de passe invalide";
                return $this->view('Default/connection',["error"=>$this->error,"title" => "Se connecter"]);
                }
            }else{
                $this->error = "Cet utilisateur n'existe pas !!";
                return $this->view('Default/connection',["error"=>$this->error,"title" => "Se connecter"]);
            }
            

        }
        

        return $this->view('Default/connection',["error"=>$this->error,"title" => "Se connecter"]);

    }

    public function register()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $email = \htmlspecialchars($_POST['email']);
            $firstName = \htmlspecialchars($_POST['first_name']);
            $lastName = \htmlspecialchars($_POST['last_name']);
            $password = \htmlspecialchars($_POST['password']);
            $password = \password_hash($password,null);

            $cle = $password;
            $member = (new Member())->getByEmail($email);
    
            if(empty($member)){
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
                return $this->view('Default/register',["error"=>$this->error,"title" => "S'inscrire"]);
            }

        }
        

        return $this->view('Default/register',["error"=>$this->error,"title" => " S'inscrire"]);


    }

    public function logout()
    {
        session_destroy();
        header('Location:/blog');
    }


    
}