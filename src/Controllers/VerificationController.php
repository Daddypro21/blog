<?php

namespace App\Controllers;

use Core\Controller;
use Core\SuperGlobals;
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
        $idMember = SuperGlobals::fromSession('id')?? null ;
        if(SuperGlobals::server() === "POST"){

            $cle = htmlspecialchars(SuperGlobals::fromPost('cle'));
            $member = new Member();
            $datas = $member->findByCle($cle);
            if(!empty($datas)){
               $tab=["confirm_member"=> 1 ,"cle"=>$cle];
               $response = $member->addConfirmCode($tab);
               if($response){
                   foreach($datas as $data);
                   SuperGlobals::saveSession('first_name',$data['first_name']);
                   SuperGlobals::saveSession('last_name',$data['last_name']);
                   SuperGlobals::saveSession('confirm_member',$data['confirm_member']);
                   SuperGlobals::saveSession('id',$data['id']);
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