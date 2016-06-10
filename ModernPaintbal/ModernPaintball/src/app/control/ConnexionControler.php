<?php

namespace app\control;

use app\view\VueAccueil;
use utils\Authentication;
use PasswordLib\PasswordLib;
use PasswordPolicy\Policy;


class ConnexionControler extends AbstractController
{
	
	public function connexion(){
		$vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::CON);
	}

	public function auth(){
		$id = filter_var($this->httpRequest->request->post('username'), FILTER_SANITIZE_STRING);
        $mdp = filter_var($this->httpRequest->request->post('mdp'), FILTER_SANITIZE_STRING);

        $bool = Authentication::authenticate($id,$mdp);

        if($bool==0){
        	Authentication::loadProfile($id);
        	$vP = new VueAccueil($this->httpRequest);
        	$vP->render(VueAccueil::CONREU);
        }else{
        	if($bool==1){
        		$vP = new VueAccueil($this->httpRequest);
       			$vP->render(VueAccueil::CONMDP);
        	}else{
        		if($bool==2){
        			$vP = new VueAccueil($this->httpRequest);
        			$vP->render(VueAccueil::CONFAIL);	
        		}
        	}
        }

	}

	public function deco(){
		session_destroy();
		session_start();
		$vP = new VueAccueil($this->httpRequest);
        $vP->render(VueAccueil::DECO);
	}

}