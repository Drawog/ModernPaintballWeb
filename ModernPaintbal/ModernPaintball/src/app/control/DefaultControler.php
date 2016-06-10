<?php

namespace app\control;

use \utils\HttpRequest;
use \app\view\VueAccueil;
use \app\model\ProjetKick;
use \app\model\ProjetTipee;

class DefaultControler extends AbstractController{

	public function afficherAccueil(){
		$view = new VueAccueil($this->httpRequest);
		$view->render(VueAccueil::ACCUEIL);
	}

    public function afficherCatalogue(){
        $id = $this->httpRequest->request->get('recherche');
        
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::CATALOGUE, $id);
    }

    public function afficherProfil(){
    	$vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::PROFIL);
    }

    public function afficherDon(){
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::MESDONS);
    }

    public function afficherProjet(){
        $vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::MESPROJETS);
    }

}