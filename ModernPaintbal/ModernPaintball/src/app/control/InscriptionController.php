<?php
namespace app\control;
use app\model\Membres;
use app\view\VueAccueil;
use utils\Authentication;

use PasswordLib\PasswordLib;
use PasswordPolicy\Policy;

class InscriptionController extends AbstractController
{

    public function creation_client(){
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::INSCRIPTION);
    }

    public function inscription(){
        $user = filter_var($this->httpRequest->request->post('username'), FILTER_SANITIZE_STRING);
        $mdp = filter_var($this->httpRequest->request->post('mdp'), FILTER_SANITIZE_STRING);

		$nom = filter_var($this->httpRequest->request->post('nom'), FILTER_SANITIZE_STRING);
		$prenom = filter_var($this->httpRequest->request->post('prenom'), FILTER_SANITIZE_STRING);		
		$mail = filter_var($this->httpRequest->request->post('mail'), FILTER_SANITIZE_EMAIL);
        $tel = filter_var($this->httpRequest->request->post('tel'), FILTER_SANITIZE_STRING);
        $cp = filter_var($this->httpRequest->request->post('cp'), FILTER_SANITIZE_STRING);
        $ville = filter_var($this->httpRequest->request->post('ville'), FILTER_SANITIZE_STRING);
        $adresse = filter_var($this->httpRequest->request->post('adresse'), FILTER_SANITIZE_STRING);

        $policy = new Policy;
        $policy->length($policy->atLeast(2));

        if($policy->test($mdp)->result) {
            $passLib = new PasswordLib;
            $hash = $passLib->createPasswordHash($mdp);

            if($passLib->verifyPasswordHash($mdp, $hash)) {	
				$m = Membres::where('username',"=",$user)->first();
        		if(empty($m)){
                    $cl = new Membres();
                    $cl->username = $user;
                    $cl->passwords = $hash;
                    $cl->nom= $nom;
                    $cl->prenom =$prenom;
                    $cl->mail =$mail;
                    $cl->adresse = $adresse;
                    $cl->ville = $ville;
                    $cl->codePostal = $cp;
                    $cl->telephone = $tel;
                    $cl->accessRight=Authentication::MEMBRE;
                    $cl->save();

                    $vP = new VueAccueil($this->httpRequest);
                    $vP->render(VueAccueil::INSREU);
                }else{
                    $vP = new VueAccueil($this->httpRequest);
                    $vP->render(VueAccueil::INSFAIL);
                }
            }
        }

    }
}