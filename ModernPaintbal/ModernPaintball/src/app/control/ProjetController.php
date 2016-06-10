<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 07/10/2016
 * Time: 13:34
 */

namespace app\control;


use \app\view\VueAccueil;
use \app\model\ProjetKick;
use \app\model\ProjetTipee;
use \app\model\Membres;
use \app\model\RecompenceKyck;
use \app\model\RecompenceTipee;
use \utils\Authentication;

class ProjetController extends AbstractController
{

    public function afficherChoixCreation(){
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::CREAPROJET);
    }

    public function affichercreationKick(){
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::CREAKICK);
    }
    /**
    public function affichercreationTipee(){
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::CREATIP);
    }*/

    public function  postProjet($id){
        $id;
        $types;

        if($this->httpRequest->request->post('gender')==='tipee') {
            $intitule = filter_var($this->httpRequest->request->post('intitule'), FILTER_SANITIZE_STRING);
            $libelle = filter_var($this->httpRequest->request->post('libelle'), FILTER_SANITIZE_STRING);
            $adresse = filter_var($this->httpRequest->request->post('adresse'), FILTER_SANITIZE_STRING);
            $ville = filter_var($this->httpRequest->request->post('ville'), FILTER_SANITIZE_STRING);
            $code_postal = filter_var($this->httpRequest->request->post('code_postal'), FILTER_SANITIZE_NUMBER_INT);
            $pT = new ProjetTipee();
            $pT->intitule = $intitule;
            $pT->libelle = $libelle;
            $pT->adresse = $adresse;
            $pT->ville = $ville;
            $pT->codePostal = $code_postal;
            $pT->idMembre = $id;
            if(isset($this->httpRequest->request->post('ckb')[0])){}
                $pT->genre1=$this->httpRequest->request->post('ckb')[0];
            if(isset($this->httpRequest->request->post('ckb')[1]))
                $pT->genre2=$this->httpRequest->request->post('ckb')[1];
            if(isset($this->httpRequest->request->post('ckb')[2]))
                $pT->genre3=$this->httpRequest->request->post('ckb')[2];
            $pT->save();
            $id=$pT->id;
            $type=1;
        }
        if($this->httpRequest->request->post('gender')==='kick'){
            $intitule = filter_var($this->httpRequest->request->post('intitule'), FILTER_SANITIZE_STRING);
            $libelle = filter_var($this->httpRequest->request->post('libelle'));
            $dateClo = filter_var($this->httpRequest->request->post('dateCloture'), FILTER_SANITIZE_STRING);
            $montantAttendu = filter_var($this->httpRequest->request->post('montantAttendu'), FILTER_SANITIZE_NUMBER_FLOAT);
            if($montantAttendu<=0)
                $montantAttendu=1;
            $adresse = filter_var($this->httpRequest->request->post('adresse'), FILTER_SANITIZE_STRING);
            $ville = filter_var($this->httpRequest->request->post('ville'), FILTER_SANITIZE_STRING);
            $code_postal = filter_var($this->httpRequest->request->post('code_postal'), FILTER_SANITIZE_NUMBER_INT);

            $pK = new ProjetKick();
            $pK->idMembre=$id;
            $pK->intitule = $intitule;
            $pK->libelle=$libelle;
            $pK->dateCloture=$dateClo;
            $pK->montantAttendu=$montantAttendu;
            $pK->adresse = $adresse;
            $pK->ville = $ville;
            $pK->codePostal=$code_postal;
            if(isset($this->httpRequest->request->post('ckb')[0]))
                $pK->genre1=$this->httpRequest->request->post('ckb')[0];
            if(isset($this->httpRequest->request->post('ckb')[1]))
                $pK->genre2=$this->httpRequest->request->post('ckb')[1];
            if(isset($this->httpRequest->request->post('ckb')[2]))
                $pK->genre3=$this->httpRequest->request->post('ckb')[2];
            $pK->save();
            $id=$pK->id;
            $type=2;
        }
        if(Authentication::checkAccessRights(4)){
        }else{
            $membre = Membres::find($_SESSION['id']);
            $membre->accessRight = Authentication::CREATEURPROJET;
            $_SESSION['accessRight'] = Authentication::CREATEURPROJET;
            $membre->save();
        }

        $test=$this->httpRequest->request->post('recompense');
        if(isset($test)){
            $vP = new VueAccueil($this->httpRequest);
            $vP->render(VueAccueil::PROJETCREA,2,$id,$type);
        }else{
            $vP = new VueAccueil($this->httpRequest);
            $vP->render(VueAccueil::PROJETCREA,1);
        }

    }

    public function affFinRecompense($id,$type){

        //1 pour tipee

        if($type==1){
            for($i=1;$i<=sizeof($this->httpRequest->request->post())/2;$i++){


                $somme = filter_var($this->httpRequest->request->post('recompense'.$i),FILTER_SANITIZE_STRING);
                $descri= filter_var($this->httpRequest->request->post('description'.$i),FILTER_SANITIZE_STRING);
                if($somme !=0 && $descri!=""){
                    $recompenceTipee = new RecompenceTipee();
                    $recompenceTipee->idProjet=$id;
                    $recompenceTipee->somme=$somme;
                    $recompenceTipee->description=$descri;
                    $recompenceTipee->save();
                }

            }
        }else{
            for($i=0;$i<=sizeof($this->httpRequest->request->post())/2;$i++){


                $somme = filter_var($this->httpRequest->request->post('recompense'.$i),FILTER_SANITIZE_STRING);
                $descri= filter_var($this->httpRequest->request->post('description'.$i),FILTER_SANITIZE_STRING);
                if($somme !=0 && $descri!=""){
                    $recompenceKyck = new RecompenceKyck();
                    $recompenceKyck->idProjet=$id;
                    $recompenceKyck->somme=$somme;
                    $recompenceKyck->description=$descri;
                    $recompenceKyck->save();
                }

            }
        }


        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::PROJETCREA,1);
    }

    
    public function affDetKick($id){
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::DETAILKICK,$id);
    }

    public function affDetTip($id){
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::DETAILTIP,$id);
    }

}