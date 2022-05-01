<?php

namespace App\Controllers;

use Core\Controller;
use Core\Models\Member;

/**
 * Creation de la class VerificationController pour gerer la confirmation d'un membre
 * methode verification / On verifie si la cle entré par le client correspond à celle dans la BD
 */

class VerificationController extends Controller
{
    public $error = null;
    public function verification()
    {
        $linkContact = 'contact';
        $linkPost = ' posts ';
        $linkHome = ' /blog/ ';
        $idMember = $_SESSION['id'] ?? null ;
        if($_SERVER['REQUEST_METHOD'] === "POST"){

            $cle = htmlspecialchars($_POST['cle']);
            $member = new Member();
            $datas = $member->findByCle($cle);
            if(!empty($datas)){
               $tab=["confirm_member"=> 1 ,"cle"=>$cle];
               $response = $member->addConfirmCode($tab);
               if($response){
                   foreach($datas as $data);
                    $_SESSION['first_name'] = $data['first_name'];
                    $_SESSION['last_name'] = $data['last_name'];
                    $_SESSION['confirm_member'] = $data['confirm_member'];
                    $_SESSION['id'] = $data['id'];
                    header("Location:../blog");exit();
               }
            }
                $this->error = "Le code entré ne correspond pas !";
                return $this->view('Default/verification',["error"=>"Le code entré ne correspond pas !","title"=>"Je suis la page de verification ",
                "linkHome"=>$linkHome,"linkPost"=>$linkPost,"linkContact"=>$linkContact,"idMember"=>$idMember]); 
            
        }

        return $this->view('Default/verification',["title"=>"Je suis la page de verification ",
        "linkHome"=>$linkHome,"linkPost"=>$linkPost,"linkContact"=>$linkContact,"idMember"=>$idMember]);
    }
}