<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 07/10/2016
 * Time: 13:42
 */

namespace app\view;

use app\model\ProjetKick;
use app\model\ProjetTipee;
use app\model\Membres;
use utils\Authentication;
use app\model\RecompenceTipee;
use app\model\RecompenceKyck;
use app\view\VueAccueil;
class VueProjet extends abstractView
{

    public function formulaireCreation(){
        $user = Membres::find($_SESSION['id']);

        $pageFormu= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Création d'un projet</h2>
                                    </header>
                                    <p>
                                    <form method='POST' action='".$this->httpRequest->urlFor('addProjet',array("id"=>$_SESSION['id']))."' name='form1' >
                                    <input type='text' name=intitule placeholder='Titre du Projet' required><br><br>
                                    <textarea rows=6 COLS=20 wrap=off name='libelle' placeholder='Description' maxlength=50000 required text-align:justify ></textarea><br><br>
                                    Genre :
                                    <input type='checkbox' name='ckb[]' value='jeux video' onclick='chkcontrol(0)'>jeux vidéo
                                    <input type='checkbox' name='ckb[]' value='littérature' onclick='chkcontrol(1)'>littérature
                                    <input type='checkbox' name='ckb[]' value='musique' onclick='chkcontrol(2)'>musique
                                    <input type='checkbox' name='ckb[]' value='creation' onclick='chkcontrol(3)'>création
                                    <input type='checkbox' name='ckb[]' value='cinema' onclick='chkcontrol(4)'>cinéma
                                    <input type='checkbox' name='ckb[]' value='innovation' onclick='chkcontrol(5)'>inovation  <br><br>
                                    <input type='radio' name='gender' value='tipee' id='radioTipee' checked>Projet Permanent
                                    <input type='radio' name='gender' value='kick' id='radioKyck'>Projet à durée déterminée<br><br>
                                    <div id='blockKyck'>
                                    <script src='assets/js/formulaire.js'></script>
                                    </div>
                                    <input type='text' name=adresse value='".$user->adresse."' ><br><br>
                                    <input type='text' name=ville value='".$user->ville."'><br><br>
                                    <input type='number' name=code_postal value='".$user->codePostal."'><br><br>
                                    <button  class='button' name='creer'>Creer</button>
                                    <button  class='button' name='recompense' value='recomp'>Ajouter des récompenses</button>
                                    </form>
                                    <script src='assets/js/formulaire.js'></script>
                                    </p>
                                    </article>

                        </div>
                    </div>
                </section>";
        return $pageFormu;
    }
    public function formulaireCreationKick()
    {
        $user = Membres::find($_SESSION['id']);

        $pageFormu= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Création d'un projet de CrowdFunding</h2>
                                    </header>
                                    <p>
                                    <form method='POST' action='".$this->httpRequest->urlFor('addKick',array("id"=>$_SESSION['id']))."'>
                                    <input type='text' name=intitule value='intitulé' required><br><br>
                                    <textarea rows=6 COLS=20 wrap=off name='libelle' maxlength=50000 required text-align:justify>Description en 50 000 caractères max</textarea><br><br>
                                    <input type='date' name=dateCloture value='date de Cloturation' required><br><br>
                                    <input type='number' name=montantAttendu value='montant attendu' required><br><br>
                                    <input type='text' name=adresse value='".$user->adresse."' ><br><br>
                                    <input type='text' name=ville value='".$user->ville."'><br><br>
                                    <input type='number' name=code_postal value='".$user->codePostal."'><br><br>
                                    <button class='button' type='submit'>creer</button>
                                    </form>

                                    </p>
                                    </article>

                        </div>
                    </div>
                </section>";

        return $pageFormu;
    }

    public function formulaireCreationTipee(){
        $user = Membres::find($_SESSION['id']);

        $pageFormu = "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Création d'un projet Tips</h2>
                                    </header>
                                    <p>
                                    <form method='POST' action='".$this->httpRequest->urlFor('addTip',array("id"=>$_SESSION['id']))."'>
                                    <input type='text' name=intitule value='intitulé' required><br><br>
                                    <textarea rows=6 COLS=20 wrap=off name='libelle' maxlength=50000 required text-align:justify>Description</textarea><br><br>
                                    <input type='text' name=adresse value='".$user->adresse."' ><br><br>
                                    <input type='text' name=ville value='".$user->ville."'><br><br>
                                    <input type='number' name=code_postal value='".$user->codePostal."'><br><br>
                                    <button class='button' type='submit'>creer</button>
                                    </form> 
                                    </p>
                                    </article>

                        </div>
                    </div>
                </section>"
        ;

        return $pageFormu;
    }

    public function detailProjetKick($id){

        $proj=ProjetKick::where("id","=",$id)->first();
        $recKick=RecompenceKyck::where("idProjet","=",$id)->get();
        $testRecomp = RecompenceKyck::where("idProjet","=",$id)->count();
		$aut = $proj->auteurs()->get();
        
        //Calcul pour la Barre de chargement
        $calcul=$proj->montantActuel/$proj->montantAttendu*100;
        $taillefinale=0;
        if($calcul>=100){
            $taillefinale=198;
        }else{
            for($i=0; $i<$calcul ; $i++){
                $taillefinale+=2;
            }
        }

            $now  = time();
            $date = strtotime($proj->dateCloture);
            $jour = $this->dateDiff($date,$now);
			
        
        $html = "<section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Titre du projet : " . $proj->intitule . "</h2>
                                    </header>
                                    <div id = 'p1'>
                                    <h3>Temps restant : </h3>".$jour['day']." jour ".$jour['hour']." heure ".$jour['minute']." minute<br><br>
                                    <h3>Montant Actuel de financement / Montant Attendu pour le projet : </h3>". $proj->montantActuel ."€ / ". $proj->montantAttendu ."€ <br><br>";
									
									$html.="<section class='bar'>
                                    <div id='bar' style='width:".$taillefinale."px;'>
                                    </div>". ((int)($proj->montantActuel/$proj->montantAttendu*100*100))/100 ." % 
                                    </section> 
									<br>";
									
									 $html .= "<h3>Adresse du créateur :</h3> ". $proj->adresse . " " . $proj->codePostal . " " . $proj->ville ."<br><br>
                                    
									<h3>Nom du créateur</h3>";
                                    foreach($aut as $a){
                                        $html.=$a->prenom." ".$a->nom;
                                    };
									

                                    $description = VueAccueil::interpreteBBCODE($proj->libelle);
                                    $html.="<br><br>
                                    <h3>Description :</h3> <p id='pdesc'>". $description ."</p><br><br>";
                                    if($proj->montantActuel >= $proj->montantAttendu){
                                        $html .= "<h2> PROJET FINANCÉ !<h2>";
                                    } ;
									 $html.="</div>";
                                   

                                    if($testRecomp!=0){
                                    $html.="<div id='sidebar'>

                                    <h3>Compensation</h3>   ";
                                    foreach($recKick as $v){
                                     $html.="<h4>A partir de : ". $v->somme."€</h4>".VueAccueil::interpreteBBCODE($v->description)."<br><br>";
                                     }
                                    }

                                     $html.="<br><br>                                
                                   </div><br>
                                    
                                    <form method='POST' action='". $this->httpRequest->urlFor('donKick', array("id"=>$id)) ."'>
                                    <button class='button' id='bdon' type='submit'>Don</button>
                                    </form>
                                </article>


                        </div>
                    </div>                                     
                </section>";
                return $html;
    }

    public function detailProjetTip($id){


        $proj=ProjetTipee::where("id","=",$id)->first();
        $testRecomp = RecompenceTipee::where("idProjet","=",$id)->count();
        $recTipee=RecompenceTipee::where("idProjet","=",$id)->get();
		$aut = $proj->auteurs()->get();

        
        $html = "<section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Titre du projet : " . $proj->intitule . "</h2>
                                    </header>
                                    <div id='p1'>
                                    
                                     <h3>Date de création : </h3> ". $proj->dateCreation ."<br>
                                     <h3>Montant Actuel de financement : </h3> ". $proj->montantActuel ."€<br>
                                     <h3>Adresse du créateur : </h3> ". $proj->adresse . " " . $proj->codePostal . " " . $proj->ville ."
                                    <br>
									<h3>Nom du créateur</h3>";
                                    foreach($aut as $a){
                                        $html.=$a->prenom." ".$a->nom;
                                    }
                                    $html.="<br><br>";
                                    $description=VueAccueil::interpreteBBCODE($proj->libelle);

                                     $html.="<h3>Description :  </h3><div id='bddcode'>". $description."</div><br>
                                     </div>";


                                        if($testRecomp!=0){
                                        $html.="<div id='sidebar'>
                                    <h3>Compensation</h3>   ";
                                        foreach($recTipee as $v){
                                            $html.=" <h4>A partir de :  ". $v->somme."€</h4>".VueAccueil::interpreteBBCODE($v->description)."<br><br>";
                                        }

                                    }

                                     $html.="<br></div>";
                                 
                                    $html.="<form method='POST' action='". $this->httpRequest->urlFor('donTip', array("id"=>$id)) ."'>
                                    <button class='button' id='bdon' type='submit'>Don</button>
                                    </form>
                                    
                            </article>

                        </div>
                    </div>
                </section>";
                return $html;
    }

    function dateDiff($date1, $date2){
    $diff = $date1 - $date2; // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $retour = array();
 
    $tmp = $diff;
    $retour['second'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['second']) /60 );
    $retour['minute'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['minute'])/60 );
    $retour['hour'] = $tmp % 24;
 
    $tmp = floor( ($tmp - $retour['hour'])  /24 );
    $retour['day'] = $tmp;
 
    return $retour;
}

}