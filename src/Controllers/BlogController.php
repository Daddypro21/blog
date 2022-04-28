<?php
namespace App\Controllers;

use Core\Controller;
use Core\Models\Post;
use Core\Models\Comment;
use Core\Mail\ContactMail\MailMessage;
use Core\Database\DBConnection;
use Core\Mail\ContactMail\Mail;

class BlogController extends Controller 
{
    public $comments ;
    public $error = null;

    public function index()
    {
        $linkContact = 'contact';
        $linkPost = ' posts ';
        $linkHome = ' /blog/ ';

        $firstname = $_SESSION['first_name'] ?? null ;
        $idMember = $_SESSION['id'] ?? null ;
        $db = new DBConnection();
        $req = $db->getPDO()->query("SELECT * FROM posts");          
        $posts = $req->fetchAll();

        return $this->view('Default/home/index',["idMember"=>$idMember,"firstname"=>$firstname,"title" => "Accueil",
        "linkPost"=>$linkPost,"linkHome"=>$linkHome,"linkContact"=>$linkContact]);
        
    }

    public function show($id)
    {
        $linkContact = '../../blog/contact';
        $linkPost = ' ../posts ';
        $linkHome = ' /blog/ ';
        $idMember = $_SESSION['id'] ?? null ;

        $confirm = $_SESSION['confirm_member'] ?? null ;
        $firstname = $_SESSION['first_name'] ?? null ;
        $post = new Post();
        $posts = $post->findByIdRelationPostAdmin($id);

        $comment = new Comment();

        if($_SERVER['REQUEST_METHOD'] === "POST"){
                
            if(!empty($_POST['comment']) ){
                var_dump($_POST['comment']);die;
                $commentPost = htmlspecialchars($_POST['comment']);
                $idMember = htmlspecialchars($_SESSION['id']);
                $data =[
                    "comment"=>$commentPost,"id_members"=>$idMember,"id_post"=>$id
                ];
                $comments = $comment->comment($data);
            }else{
                $this->error = "Ce champs ne peut pas être vide";
            }
            
        }
         $comments = $comment->getComment($id);
         $this->comments = $comments;
         
        return $this->view('Default/post',[
            "error"=>$this->error,
            "comments"=>$this->comments,"id"=>$id,
            "firstname"=>$firstname ,
            "title"=>"post","idMember"=>$idMember,
            "posts"=>$posts,"linkPost"=>$linkPost,"linkHome"=>$linkHome,"linkContact"=>$linkContact,"confirm"=>$confirm]);
        
    }

    public function showAll()
    {
        $linkContact = '../blog/contact';
        $linkPost = ' ../posts ';
        $linkHome = ' /blog/ ';

        $idMember = $_SESSION['id'] ?? null ;
        $firstname = $_SESSION['first_name'] ?? null ;
        $post = new Post();
        $posts = $post->postAdminRelation();

        //var_dump($posts);die;

        return $this->view('Default/posts',["idMember"=>$idMember,"title" => "posts","posts"=>$posts,
        "linkPost"=>$linkPost,"linkHome"=>$linkHome,"linkContact"=>$linkContact]);

    }

    public function contact()
    {
        $linkContact = 'contact';
        $linkPost = ' ../blog/posts ';
        $linkHome = ' /blog/ ';

        $idMember = $_SESSION['id'] ?? null ;
        $firstname = $_SESSION['first_name'] ?? null ;

        if($_SERVER['REQUEST_METHOD'] === "POST"){

           if(!empty($_POST['message'] && $_POST['name'] && $_POST['email'] && $_POST['subject'])){
               $email = $_POST['email'];
               if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $message = htmlspecialchars($_POST['message']);
                $name = htmlspecialchars($_POST['name']);
                $subject = htmlspecialchars($_POST['subject']);
                
                $EmailMessage = new MailMessage();
                $messageMail = $EmailMessage->message($email,$message,$name);

                $mail = new Mail();
                $to = "sndemapro@gmail.com";
                $subject = $subject;
                $message = $messageMail;
                $headers ="";
                $headers .= "From: {$email}" . "\r\n" ;
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                "CC:". $email;
                $response = $mail->sendMail($to,$subject,$message,$headers);
                if($response){
                    $response ="Votre message a été envoyé !";
                    return $this->view('Default/contact',["idMember"=>$idMember,"title" => "Contact",
                    "linkPost"=>$linkPost,"linkHome"=>$linkHome,"linkContact"=>$linkContact,"response"=>$response]);
                }
               }
           }

            

               
        }

        return $this->view('Default/contact',["idMember"=>$idMember,"title" => "Contact",
        "linkPost"=>$linkPost,"linkHome"=>$linkHome,"linkContact"=>$linkContact]);
    }

    
}