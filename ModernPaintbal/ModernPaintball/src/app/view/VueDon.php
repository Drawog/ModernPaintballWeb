<?php
namespace app\view;

use app\view\VueProjet;
use app\model\ProjetKick;
use app\model\ProjetTipee;
use utils\Authentication;

class VueDon extends abstractView{

    public function DonKick($id){
       
            $proj=ProjetKick::find($id);
     
        $html = "<!-- Main -->
        <section class='wrapper style1'>
        <div class='container'>
        <div id='content'>

        <!-- Content -->

        <article>
        <header>
        <h2>Don pour le projet : " . $proj->intitule  . "</h2>
        </header>
        <p>
        <form method='POST' action='". $this->httpRequest->urlFor('donKickConf', array("id"=>$id)) ."'>
        <input type='number' name=don value='1'><br><br>";
        if(!Authentication::checkAccessRights(3)){
            $html .= "<input type='mail' name=mail value='Mail'><br><br>";
        }
        $html .="<button class='button' type='submit'>Donner</button>";
        $html.=" <INPUT type='checkbox' name='suivie_projet[]'  value='0'checked> Souhaitez vous suivre l'avancement du projet ?
        </form>
        </p>
        </article>

        </div><br><br><br><br><br><br><br><br>
        </div>
        </section>";
        return $html;
    }

    public function DonTip($id){
       
            $proj=ProjetTipee::find($id);
     
        $html = "<!-- Main -->
        <section class='wrapper style1'>
        <div class='container'>
        <div id='content'>

        <!-- Content -->

        <article>
        <header>
        <h2>Don pour le projet : " . $proj->intitule  . "</h2>
        </header>
        <p>
        <form method='POST' action='". $this->httpRequest->urlFor('donTipConf', array("id"=>$id)) ."'>
        <input type='number' name=don value='1'><br><br>";
        if(!Authentication::checkAccessRights(3)){
            $html .= "<input type='mail' name=mail value='Mail'><br><br>";
        }
        $html .="<button class='button' type='submit'>Donner</button>
        </form>
        </p>
        </article>

        </div><br><br><br><br><br><br><br><br>
        </div>
        </section>";
        return $html;
    }


}

