<?php

namespace app\control;

use app\model\SuivisProjet;
use \utils\HttpRequest;
use \app\view\VueAccueil;
use \app\model\ProjetKick;
use \app\model\ProjetTipee;
use \app\model\Donkick;
use \app\model\Dontip;
use \app\model\Membres;
use utils\Authentication;

class DonControler extends AbstractController{

    public function afficherDonKick($id){
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::DON_PROJET_KICK,$id);
    }

    public function afficherDonTip($id){
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::DON_PROJET_TIP,$id);
    }

    public function DonProjetKick($id){

        $don = filter_var($this->httpRequest->request->post('don'), FILTER_SANITIZE_NUMBER_FLOAT);

        $proj = ProjetKick::find($id);
        if($proj->montantActuel != 0){
            $ancienMontant =$proj->montantAttendu/$proj->montantActuel;
        }else{
            $ancienMontant =0;
        }

        $proj->montantActuel = $proj->montantActuel+$don;
        $proj->save();

        $d = new Donkick();
        $d->idProjet=$id;
        $d->montant=$don;

        if(Authentication::checkAccessRights(3)){
            $d->idMembre=$_SESSION['id'];
            $user = Membres::find($_SESSION['id']);
            $d->mail=$user->mail;
        }else{
            $mail = filter_var($this->httpRequest->request->post('mail'), FILTER_SANITIZE_STRING);
            $d->mail=$mail;
        }
        $d->save();
        
        // Ajout partie envoi email
        if($ancienMontant != 0){
            $progres = $proj->montantAttendu/$proj->montantActuel;
            $listeContactId =SuivisProjet::where("idProjet", "like", $proj->id);
            $listeContact = Array();
            if(Authentication::checkAccessRights(3)){
                foreach ($listeContactId as $item) {
                    $listeContact.push(Membres::find($item->idMembre));
                }
                if($ancienMontant<0.25 && $progres>=0.25){
                    foreach($listeContact as $value){
                        mail($value->mail,"Nouvelle du projet ".$proj->intitule,"Bonjour, nous avons le plaisir de vous dire que le projet ".$proj->intitule." a dépassé les 25% de financement!");
                    }
                }
                if($ancienMontant<0.5 && $progres>=0.5){
                    foreach($listeContact as $value){
                        mail($value->mail,"Nouvelle du projet ".$proj->intitule,"Bonjour, nous avons le plaisir de vous dire que le projet ".$proj->intitule." a dépassé les 50% de financement!");
                    }
                }
                if($ancienMontant<0.75 && $progres>=0.75){
                    foreach($listeContact as $value){
                        mail($value->mail,"Nouvelle du projet ".$proj->intitule,"Bonjour, nous avons le plaisir de vous dire que le projet ".$proj->intitule." a dépassé les 75% de financement!");
                    }
                }
            }
            else{
                $listeContact=SuivisProjet::where('idProjet', 'like', $id);
                if($ancienMontant<0.25 && $progres>=0.25){
                    foreach($listeContact as $value){
                        mail($value->mailNonMembre,"Nouvelle du projet ".$proj->intitule,"Bonjour, nous avons le plaisir de vous dire que le projet ".$proj->intitule." a dépassé les 25% de financement!");
                    }
                }
                if($ancienMontant<0.5 && $progres>=0.5){
                    foreach($listeContact as $value){
                        mail($value->mailNonMembre,"Nouvelle du projet ".$proj->intitule,"Bonjour, nous avons le plaisir de vous dire que le projet ".$proj->intitule." a dépassé les 50% de financement!");
                    }
                }
                if($ancienMontant<0.75 && $progres>=0.75){
                    foreach($listeContact as $value){
                        mail($value->mailNonMembre,"Nouvelle du projet ".$proj->intitule,"Bonjour, nous avons le plaisir de vous dire que le projet ".$proj->intitule." a dépassé les 75% de financement!");
                    }
                }

            }
        }



        //Suivie de projet
        if (isset($this->httpRequest->request->post('suivie_projet')[0]))
        {
            $suivie =new SuivisProjet();
            $suivie->idProjet=$id;
            if(Authentication::checkAccessRights(3)){
                $suivie->idMembre=$_SESSION['id'];
                $suivie->save();
            }
            else{
                $mail = filter_var($this->httpRequest->request->post('mail'), FILTER_SANITIZE_STRING);
                $suivie->mailNonMembre=$mail;
                $suivie->save();
            }
        }


        $vD=new VueAccueil($this->httpRequest);
        $vD->render(VueAccueil::DON);

    }

    public function DonProjetTips($id){
        $don = filter_var($this->httpRequest->request->post('don'), FILTER_SANITIZE_NUMBER_FLOAT);

        $proj = ProjetTipee::find($id);

        $proj->montantActuel = $proj->montantActuel+$don;
        $proj->save();

        $d = new Dontip();
        $d->idProjet=$id;
        $d->montant=$don;

        if(Authentication::checkAccessRights(3)){
            $d->idMembre=$_SESSION['id'];
            $user = Membres::find($_SESSION['id']);
            $d->mail=$user->mail;
        }else{
            $mail = filter_var($this->httpRequest->request->post('mail'), FILTER_SANITIZE_STRING);
            $d->mail=$mail;
        }
        $d->save();


        $vD=new VueAccueil($this->httpRequest);
        $vD->render(VueAccueil::DON);
    }

}