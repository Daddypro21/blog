<?php
namespace App\Controllers;

use Core\Controller;
use Core\Models\Post;
use Core\SuperGlobals;
use Core\Models\Comment;
use Core\Database\DBConnection;
use Core\Mail\ContactMail\Mail;
use Core\Mail\ContactMail\MailMessage;

/**
 * Creation de la class BlogController pour gerer le blog
 * methode index pour gerer la page accueil
 * methode show pour afficher un article et ces commentaires
 * methode showAll pour afficher la liste des derniers arcticles
 * methode contact pour gerer la page contact
 */
class BlogController extends Controller 
{
    public $comments ;
    public $error = null;

    public function index()
    {
        $linkContact = 'contact';
        $linkPost = ' posts ';
        $linkHome = ' /blog/ ';

        $firstname = (new SuperGlobals())->fromSession('firstname') ?? null ;
        $idMember = (new SuperGlobals())->fromSession('id')?? null ;
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
        $idMember = (new SuperGlobals())->fromSession('id') ?? null ;

        $confirm = (new SuperGlobals())->fromSession('confirm_member') ?? null ;
        $firstname = (new SuperGlobals())->fromSession('first_name') ?? null ;
        $post = new Post();
        $posts = $post->findByIdRelationPostAdmin($id);

        $comment = new Comment();

        if((new SuperGlobals())->server() === "POST"){
                
            if(!empty((new SuperGlobals())->fromPost('comment')) ){
                $commentPost = htmlspecialchars((new SuperGlobals())->fromPost('comment'));
                $idMember = htmlspecialchars((new SuperGlobals())->fromSession('id'));
                $data =[
                    "comment"=>$commentPost,"id_members"=>$idMember,"id_post"=>$id
                ];
                $comments = $comment->comment($data);
                header("location:../../blog/posts/{$id}");
            }else{
                $this->error = "Ce champs ne peut pas ??tre vide";
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

        $idMember = (new SuperGlobals())->fromSession('id') ?? null ;
        $firstname =(new SuperGlobals())->fromSession('first_name') ?? null ;
        $post = new Post();
        $posts = $post->postAdminRelation();
        return $this->view('Default/posts',["idMember"=>$idMember,"title" => "posts","posts"=>$posts,
        "linkPost"=>$linkPost,"linkHome"=>$linkHome,"linkContact"=>$linkContact]);

    }

    public function contact()
    {
        $linkContact = 'contact';
        $linkPost = ' ../blog/posts ';
        $linkHome = ' /blog/ ';

        $idMember = (new SuperGlobals())->fromSession('id') ?? null ;
        $firstname = (new SuperGlobals())->fromSession('first_name') ?? null ;

        if((new SuperGlobals())->server()=== "POST"){
           if(!empty((new SuperGlobals())->fromPost('message') && (new SuperGlobals())->fromPost('name') && (new SuperGlobals())->fromPost('email') && (new SuperGlobals())->fromPost('subject'))){
               $email =(new SuperGlobals())->fromPost('email');
               if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $message = htmlspecialchars((new SuperGlobals())->fromPost('message'));
                $name = htmlspecialchars((new SuperGlobals())->fromPost('name'));
                $subject = htmlspecialchars((new SuperGlobals())->fromPost('subject'));
                
                $EmailMessage = new MailMessage();
                $messageMail = $EmailMessage->message($email,$message,$name);

                $mail = new Mail();
                $too = "sndemapro@gmail.com";
                $subject = $subject;
                $message = $messageMail;
                $headers ="";
                $headers .= "From: {$email}" . "\r\n" ;
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                "CC:". $email;
                $response = $mail->sendMail($too,$subject,$message,$headers);
                if($response){
                    $response ="Votre message a ??t?? envoy?? !";
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