<?php
        namespace app\view;

use app\view\VueProjet;
use app\model\ProjetKick;
use app\model\ProjetTipee;
use app\model\MiseEnAvant;
use app\model\MiseEnAvantTip;
use app\model\Membres;
use utils\Authentication;
use app\model\Donkick;
use app\model\Dontip;

class VueAccueil extends abstractView{


    /*
     * constante d'affichage de l'accueil
     */
    const ACCUEIL = 1;

    const CREAKICK = 2;

    const CREATIP = 3;

    const DETAILKICK = 4;

    const DETAILTIP = 5;

    const PROJETCREA = 6;

    const DON_PROJET_KICK = 7;

    const DON_PROJET_TIP = 8;

    const DON = 9;

    const CATALOGUE = 10;

    const CREAPROJET = 11;

    const INSCRIPTION = 12;

    const INSREU = 13;

    const INSFAIL = 14;

    const CON = 15;

    const CONREU = 16;

    const CONMDP = 17;

    const CONFAIL = 18;

    const DECO = 19;

    const PROFIL = 20;

    const MESDONS = 21;

    const MESPROJETS = 22;


    public function render($n,$id=null,$idProject=null,$typeProject=null){
        $html = "
                <!DOCTYPE HTML>
        <html>
        <head>
        <title>ModernPaintball</title>
        <link rel='shortcut icon' href='images/icon.ico' />
        <meta charset='utf-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1' />
        <!--[if lte IE 8]><script src='assets/js/ie/html5shiv.js'></script><![endif]-->
        <link rel='stylesheet' href='" . $this->httpRequest->urlFor('accueil') . "/assets/css/main.css' />
        <!--[if lte IE 8]><link rel='stylesheet' href='assets/css/ie8.css' /><![endif]-->
        <!--[if lte IE 9]><link rel='stylesheet' href='assets/css/ie9.css' /><![endif]-->
        </head>
        <body>";

        $html .= "<div id='page-wrapper'>";

        $html .= $this->genererHeader();

        switch ($n) {
        case 1 :
            $html .= $this->genererBanner();
            $html .= $this->genererPosts();
            break;
        case 2 :
            $vue = new VueProjet($this->httpRequest);
            $html .= $vue->formulaireCreation();
            break;
        case 3 :
            $vue = new VueProjet($this->httpRequest);
            $html .= $vue->formulaireCreationTipee();
            break;
        case 4 :
            $vue = new VueProjet($this->httpRequest);
            $html .= $vue->detailProjetkick($id);
            break;
        case 5 :
            $vue = new VueProjet($this->httpRequest);
            $html .= $vue->detailProjetTip($id);
            break;
        case 6 :
            $html .= $this->genererProjetCreaReussi($id,$idProject,$typeProject);
            break;
        case 7 :
            $vue = new VueDon($this->httpRequest);
            $html .= $vue->DonKick($id);
            break;
        case 8 :
            $vue = new VueDon($this->httpRequest);
            $html .= $vue->DonTip($id);
            break;
        case 9 :
            $html .= $this->genererDonReussi();
            break;
        case 10 :
            $html .= $this->genererCatalogue($id);
            break;
        case 11 :
            $html .= $this->genererChoixProjet();
            break;
        case 12 :
            $html .= $this->formulaireInscription();
            break;
        case 13 :
            $html .= $this->inscriptionReussi();
            break;
        case 14 :
            $html .= $this->membreExistant();
            break;
        case 15 : 
            $html .= $this->Connexion();
            break;
        case 16 :
            $html .= $this->connexionReussi();
            break;
        case 17 :
            $html .= $this->connexionMdp();
            break;
        case 18 : 
            $html .= $this->connexionFail();
            break;
        case 19 :
            $html .= $this->deconnexion();
            break;
        case 20 :
            $html .= $this->profil();
            break;
        case 21 :
            $html .= $this->mesDons();
            break;
        case 22 :
            $html .= $this->mesProjet();
            break;
        default:
            break;
        }

        $html .= $this->genererFooter();

        $html .= "</div>";

        $html .= "
                <!-- Scripts -->
                <link rel=\"stylesheet\" href='assets/css/bootstrap.css'>
                <script src='assets/js/jquery.min.js'></script>
                <script src='assets/js/jquery.dropotron.min.js'></script>
                <script src='assets/js/skel.min.js'></script>
                <script src='assets/js/util.js'></script>
                <!--[if lte IE 8]><script src='assets/js/ie/respond.min.js'></script><![endif]-->
                <script src='assets/js/main.js'></script>
                <script src='assets/js/new1.js'></script>
                <script src='assets/js/filtres.js'></script>
                <script src='assets/js/bootstrap.js'></script>
                <script type='text/javascript' src='assets/bbcode/minified/jquery.sceditor.bbcode.min.js'></script>
                <script src='assets/js/scriptbb.js'></script>
		  
		<link rel='stylesheet' href='assets/bbcode/minified/themes/default.min.css' type='text/css' media='all' />

		<script>



          <style>
          .carousel-inner > .item > img,
          .carousel-inner > .item > a > img {
              width: 70%;
              margin: auto;
          }
          </style>

        </body>
        </html>
        ";

        echo $html;
    }

    /*
     * Methode permettant de generer le header du fichier html
     */
    private function genererHeader() {
        $html = "<!-- Header -->
                <div id='header'>

        <!-- Logo -->
        <h1><a href='" . $this->httpRequest->urlFor('accueil') . "' id='logo'><img src='images/logor.png'></a></h1>

        <!-- Nav -->
        <nav id='nav'>
        <ul>";
        if($this->httpRequest->request->getResourceUri()=="/"){
            $html .= "<li class='current'><a href='" . $this->httpRequest->urlFor('accueil') . "'>Accueil</a></li>";
        }else{
            $html .= "<li><a href='" . $this->httpRequest->urlFor('accueil') . "'>Accueil</a></li>";
        }

        if($this->httpRequest->request->getResourceUri()=="/catalogue"){
            $html .= "<li class='current'><a href='" . $this->httpRequest->urlFor('catalogue') . "'>Catalogue</a></li>";
        }else{
            $html .= "<li><a href='" . $this->httpRequest->urlFor('catalogue') . "'>Catalogue</a></li>";
        }

        if(Authentication::checkAccessRights(3)){
            if($this->httpRequest->request->getResourceUri()=="/creaProjet"||$this->httpRequest->request->getResourceUri()=="/creaTip"||$this->httpRequest->request->getResourceUri()=="/creaKick"){
                $html .= "<li class='current'><a href='" . $this->httpRequest->urlFor('creaproj') . "'>Création projet</a></li>";
            }else{
                $html .= "<li><a href='" . $this->httpRequest->urlFor('creaproj') . "'>Création projet</a></li>";
            }
        }

        if(Authentication::checkAccessRights(3)){
            if($this->httpRequest->request->getResourceUri()=="/profil"){
                $html .= "<li class='current'><a href='".$this->httpRequest->urlFor('profil')."'>Profil</a></li>";
            }else{
                $html .= "<li><a href='".$this->httpRequest->urlFor('profil')."'>Profil</a></li>";
            };
        }

        if(!Authentication::checkAccessRights(3)){
            if($this->httpRequest->request->getResourceUri()=="/inscription"){
                $html .= "<li class='current'><a href='".$this->httpRequest->urlFor('inscription')."'>Inscription</a></li>";
            }else{
                $html .= "<li><a href='".$this->httpRequest->urlFor('inscription')."'>Inscription</a></li>";
            }
        }

        if(!Authentication::checkAccessRights(3)){
            if($this->httpRequest->request->getResourceUri()=="/connexion"){
                $html .= "<li class='current'><a href='".$this->httpRequest->urlFor('connexion')."'>Connexion</a></li>";
            }else{
                $html .= "<li><a href='".$this->httpRequest->urlFor('connexion')."'>Connexion</a></li>";
            }
        }else{
            $html .= "<li><a href='".$this->httpRequest->urlFor('deconnexion')."'>Deconnexion</a></li>";
        }

        $html .= "</ul>
        </nav>

        </div>"

        ;
        return $html;
    }

    private function genererBanner(){
        //recup projet :
        $listeKick = MiseEnAvant::all();

        $listeTip = MiseEnAvantTip::all();

        $projetKick1 = ProjetKick::where("id","like",$listeKick[0]->id)->get();
        $projetKick2 = ProjetKick::where("id","like",$listeKick[1]->id)->get();
        $projetTip1 = ProjetTipee::where("id","like",$listeTip[0]->id)->get();
        $projetTip2 = ProjetTipee::where("id","like",$listeTip[1]->id)->get();


        $calcul1=$projetKick1[0]->montantActuel/$projetKick1[0]->montantAttendu*100;
        $taillefinale=0;
        if($calcul1>=100){
            $taillefinale=198;
        }else{
            for($i=0; $i<$calcul1 ; $i++){
                $taillefinale+=2;
            }
        }

        $now   = time();
        $date = strtotime($projetKick1[0]->dateCloture);
        $jour = $this->dateDiff($date,$now);

        $calcul2=$projetKick2[0]->montantActuel/$projetKick2[0]->montantAttendu*100;
        $taillefinale2=0;
        if($calcul2>=100){
            $taillefinale2=198;
        }else{
            for($i=0; $i<$calcul2 ; $i++){
                $taillefinale2+=2;
            }
        }

        $now2   = time();
        $date2 = strtotime($projetKick2[0]->dateCloture);
        $jour2 = $this->dateDiff($date2,$now2);

        $html =  " <!-- Banner -->
                <section id='banner'>
                <div class=\"container1\">
  <div id=\"myCarousel\" class=\"carousel slide\" data-ride=\"carousel\">
    
    <!-- Wrapper for slides -->
    <div class=\"carousel-inner\" role=\"listbox\">
      <div class=\"item active\">

            <arcticle class='ban'>";
        $html .= "<section class='6u 12u(narrower)'>
                    <div class='box post'>
                    <form method='POST' name='id' value=".$projetTip1[0]->id." action=".$this->httpRequest->urlFor('affProjetTip', array("id"=>$projetTip1[0]->id))." >
            <input type='image' src='images/logot.png' alt='' class='image left' />
            </form>
            <div class='inner'>
            <h3>" . $projetTip1[0]->intitule . "</h3>
            <p align='justify'>". $projetTip1[0]->montantActuel ." € Collecté!<br>
            ";
        $description =VueAccueil::interpreteBBCODE($projetTip1[0]->libelle);
        $html.= mb_strimwidth($description,0,250,'...'). "</p>
            </div>
            </div>
            </section>";

           $html.=" </arcticle>
      </div>

      <div class=\"item\">

            <arcticle class='ban'>";
        $html .= "<section class='6u 12u(narrower)'>
                            <div class='box post'>
                        <form method='POST' name='id' value=".$projetKick1[0]->id." action=".$this->httpRequest->urlFor('affProjetKick',array("id"=>$projetKick1[0]->id)).">
                        <input type='image' src='images/logok.png' alt='' class='image left' />
                        </form>
                    <div class='inner'>
                    <h3>" . $projetKick1[0]->intitule . "</h3>
                    <p>Temps restant : ".$jour['day']." jours ".$jour['hour']." heures ".$jour['minute']." minutes</p>
                    <section class='bar' style='width:200px; height:20px; border : solid 1px; color : black; text-align : center; border-radius : 4px 4px;'>
                    <div class='bar' style='width:".$taillefinale."px;height:18px;background:#651c1b; border-radius : 4px 4px;'>
                    </div>". ((int)($projetKick1[0]->montantActuel/$projetKick1[0]->montantAttendu*100*100))/100 ." % <br>
                    </section>
                    <p align='justify'><br>";
        $description=VueAccueil::interpreteBBCODE($projetKick1[0]->libelle);
        $html.= mb_strimwidth($description,0,250,'...') . "</p>
                    </div>
                    </div>
                    </section>";

           $html.="

            </arcticle>
      </div>

      <div class=\"item\">

            <arcticle class='ban'>";
        $html .= "<section class='6u 12u(narrower)'>
                    <div class='box post'>
                    <form method='POST' name='id' value=".$projetTip2[0]->id." action=".$this->httpRequest->urlFor('affProjetTip', array('id'=>$projetTip2[0]->id))." >
            <input type='image' src='images/logot.png' alt='' class='image left' />
            </form>
            <div class='inner'>
            <h3>". $projetTip2[0]->intitule ."</h3>
            <p align='justify'>". $projetTip2[0]->montantActuel ." € Collecté!<br>
            ";
        $description=VueAccueil::interpreteBBCODE($projetTip2[0]->libelle);
        $html.= mb_strimwidth($description,0,250,"</font>...") ."</p>
            </div>
            </div>
            </section>";

           $html.="

            </arcticle>
      </div>

      <div class=\"item\">

            <arcticle class='ban'>";
            $html .= "<section class='6u 12u(narrower)'>
                            <div class='box post'>
                        <form method='POST' name='id' value=".$projetKick2[0]->id." action=".$this->httpRequest->urlFor('affProjetKick',array("id"=>$projetKick2[0]->id)).">
                        <input type='image' src='images/logok.png' alt='' class='image left' />
                        </form>
                    <div class='inner'>
                    <h3>" . $projetKick2[0]->intitule . "</h3>
                    <p>Temps restant : ".$jour2['day']." jours ".$jour2['hour']." heures ".$jour2['minute']." minutes</p>
                    <section class='bar' style='width:200px; height:20px; border : solid 1px; color : black; text-align : center; border-radius : 4px 4px;'>
                    <div class='bar' style='width:".$taillefinale2."px;height:18px;background:#651c1b; border-radius : 4px 4px;'>
                    </div>". ((int)($projetKick2[0]->montantActuel/$projetKick2[0]->montantAttendu*100*100))/100 ." % <br>
                    </section>
                    <p align='justify'><br>";
        $description=VueAccueil::interpreteBBCODE($projetKick2[0]->libelle);
        $html.= mb_strimwidth($description,0,250,'...') . "</p>
                    </div>
                    </div>
                    </section>";

            $html.="</arcticle>
      </div>
    </div>

    <!-- Left and right controls -->
    <a class=\"left carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"prev\">
      <span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>
      <span class=\"sr-only\">Previous</span>
    </a>
    <a class=\"right carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"next\">
      <span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>
      <span class=\"sr-only\">Next</span>
    </a>
  </div>
</div>


                <header>
                <h2>Nos Coups De Coeur!</h2>
			
                </header><br><br>
				
				
				
                </section>";
				

        return $html;
    }

    public function genererProjetCreaReussi($n,$id=null,$type=null){
        if($n==1){
            $html = "<!-- Main -->
                <section class='wrapper style1'>
        <div class='container'>
        <div id='content'>

        <!-- Content -->

        <article>
        <header>
        <h2>Création de votre projet Réussi!</h2>
        </header>
        <p>
        La création de votre projet est réussi et a été enregistré!
        </p>
        <a href='" . $this->httpRequest->urlFor('accueil') . "' class='button'>Retour à l'accueil</a>
        </article>

        </div>
        </div>
        </section>";
        return $html;
        }
        if($n==2){
            $html="
                <section class='wrapper style1'>
                <div class='container'>
                <div id='content'>
                <form method='POST' action='".$this->httpRequest->urlFor('finRecompense',array('id'=>$id,'type'=>$type))."'  class='monster'>
                <br><p>Pour ajouter une récompense, cliquez sur le button \"ajouter des récompenses\" et remplissez les champs. Vous pouvez ajouter autant de récompenses que vous le souhaitez. Pour finaliser la création de votre projet clickez sur \"Finir la création\"</p><br>
                <br><p>Liste de compensation :</p>
                <br><p id='monster'></p>


                <input id='b1' type='button' value='Ajouter une compensation'  />
                <input type='submit' class='button' value='Finir la création'/>
                </form>
                </div>
                </div>
                </section>

            ";
            return $html;
            }

    }

    public function genererDonReussi(){
        $html = "<!-- Main -->
                <section class='wrapper style1'>
        <div class='container'>
        <div id='content'>

        <!-- Content -->

        <article>
        <header>
        <h2>Don réussi!!</h2>
        </header>
        <p>
        Votre don a été réalisé.
        </p>
        <a href='" . $this->httpRequest->urlFor('accueil') . "' class='button'>Retour à l'accueil</a>
        </article><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

        </div>
        </div>
        </section>";

        return $html;
    }


    /*
     * Méthode qui génere le Highlights
     */
    public function genererHighlights (){
        $html= "<section class='wrapper style1'>
                <div class='container'>
        <div class='row 200%'>
        <section class='4u 12u(narrower)'>
        <div class='box highlight'>
        <i class='icon major fa-paper-plane'></i>
        <h3>This Is Important</h3>
        <p>Duis neque nisi, dapibus sed mattis et quis, nibh. Sed et dapibus nisl amet mattis, sed a rutrum accumsan sed. Suspendisse eu.</p>
        </div>
        </section>
        <section class='4u 12u(narrower)'>
        <div class='box highlight'>
        <i class='icon major fa-pencil'></i>
        <h3>Also Important</h3>
        <p>Duis neque nisi, dapibus sed mattis et quis, nibh. Sed et dapibus nisl amet mattis, sed a rutrum accumsan sed. Suspendisse eu.</p>
        </div>
        </section>
        <section class='4u 12u(narrower)'>
        <div class='box highlight'>
        <i class='icon major fa-wrench'></i>
        <h3>Probably Important</h3>
        <p>Duis neque nisi, dapibus sed mattis et quis, nibh. Sed et dapibus nisl amet mattis, sed a rutrum accumsan sed. Suspendisse eu.</p>
        </div>
        </section>
        </div>
        </div>
        </section>";
        return $html;
    }

    /*
     * Méthode qui génère le Gigantic Heading
     */ 

    public function genererGiganticHeading() {
        $html= "<section class='wrapper style2'>
                <div class='container'>
        <header class='major'>
        <h2>A gigantic heading you can use for whatever</h2>
        <p>With a much smaller subtitle hanging out just below it</p>
        </header>
        </div>
        </section>";
                return $html;
    }

    /**
     * Méthode qui génère le Posts
     */

    public function genererPosts(){
        

        $html="<section class='wrapper style1'>
                <div class='container'>
        <div class='pres'>
		
		<h3>ModernPaintBall c'est quoi ?</h3>
		<p>Il est vrai que le nom choisit « modern paintball » peut sans doute susciter un intérêt, une curiosité. on est alors amené à se poser et même à poser cette question : pourquoi avoir choisi d’appeler le terrain de la sorte ?</p>
        <p>Certains diront que le paintball est quelque chose de moderne et donc que le nom a été choisi comme cela pour « coller » à l’image du paintball. En soi, ils n’auraient pas vraiment tort mais le choix du nom n’a pas été conditionné par ce facteur-là.</p>




";
	
     
                  

        $html .= "</div>
                </div>
        </section>";            

        return $html;
    }

    /*
     *Méthode qui génère le CTA
     */

    private function genererCTA() {
        $html="<section id='cta' class='wrapper style3'>
                <div class='container'>
        <header>
        <h2>Are you ready to continue your quest?</h2>
        <a href='#' class='button'>Insert Coin</a>
        </header>
        </div>
        </section>";
        return $html;
    }

    /*
     * Méthode qui génère le footer
     */

    private function genererFooter(){
        $html="<div id='footer'>

                <!-- Icons -->
        <ul class='icons'>
        <li><a href='#' class='icon fa-twitter'><span class='label'>Twitter</span></a></li>
        <li><a href='#' class='icon fa-facebook'><span class='label'>Facebook</span></a></li>
        <li><a href='#' class='icon fa-google-plus'><span class='label'>Google+</span></a></li>
        </ul>

        <!-- Copyright -->
        <div class='copyright'>
        <ul class='menu'>
        <li>Template Arcana</li><li>Design:HTML5 UP</a></li>
        </ul>
        </div>

        </div>

        </div>";
        return $html;
    }

    private function genererCatalogue($id=null){
        
        if($id == null){
            $catKick = ProjetKick::all();
            $catTip = ProjetTipee::all();
        }else{
            $catKick = ProjetKick::where('intitule','like','%'.$id.'%')
                ->orWhere('libelle','like','%'.$id.'%')
                ->get();
            $catTip = ProjetTipee::where('intitule','like','%'.$id.'%')
                ->orWhere('libelle','like','%'.$id.'%')
                ->get();
            
            
            if(Membres::where('nom','like',$id)){
            $proj = Membres::where('nom','like',$id)
                ->get();

            foreach($proj as $pv){
                $catKick = $pv->projetKick;
                $catTip = $pv->projetTip;
            }
        }
        } 
        
        

         $html = "<section class='wrapper style1'>
                <div class='container'>
                
                <h1>Votre recherche :</h1>
                <div>
                <form action='".$this->httpRequest->urlFor('catalogue1')."' methode='POST'>
                   
                    <article id='searchbar'><input name='recherche' type='text' value='".$id."'/></article>
                    <div id='pb'><input type='submit' value='Rechercher'/></div>
                     
                </form>
                </div>
                
                <div class='filtres'>
                <h1>Filtres</h1>
                <p>
                <div id='gentyp'>Genre :</div><select id='genre1' width=200>
                    <option value=''>TOUS</option>
                    <option value='musique'>Musique</option>
                    <option value='jeux video'>Jeux Vidéo</option>
                    <option value='littérature'>Littérature</option>
                    <option value='creation'>Création</option>
                    <option value='cinema'>Cinéma</option>
                    <option value='inovation'>Inovation</option>
                </select>
                
                <div id='gentyp'>Type : </div><select id='type'>
                    <option value=''>TOUS</option>
                    <option value='permanent'>A durée déterminée</option>
                    <option value='indeterminee'>A durée indéterminée</option>
                </select>
                </p>
                </div>

                
                
                <div class='row'>";

        foreach ($catKick as $key) {

            $calcul=$key->montantActuel/$key->montantAttendu*100;
            $taillefinale=0;
            if($calcul>=100){
                $taillefinale=198;
            }else{
                for($i=0; $i<$calcul ; $i++){
                    $taillefinale+=2;
                }
            }

            $now   = time();
            $date = strtotime($key->dateCloture);
            $jour = $this->dateDiff($date,$now);

            if($jour['day']>0){
                $html .= "
                        <section class='6u 12u(narrower)'>
                <div class='box post' genre1='".$key->genre1."' type='permanent'>
               <form method='POST' name='id' value=".$key->id." action=".$this->httpRequest->urlFor('affProjetKick',array("id"=>$key->id)).">
                    <input type='image' src='images/logok.png' alt='' class='image left' />
               </form>
                <div class='inner'>
                <h3>". $key->intitule ."</h3>
                <p>Temps restant : ".$jour['day']." jour ".$jour['hour']." heure ".$jour['minute']." minute</p>
                <section class='bar'>
                <div id='bar' style='width:".$taillefinale."px;'>
                </div>". ((int)($key->montantActuel/$key->montantAttendu*100*100))/100 ." % <br>
                </section> 
                <p><br>". mb_strimwidth(VueAccueil::interpreteBBCODE($key->libelle),0,250,"...") ."</p>
                </div>
                </div>
                </section>";
            }
        }

        $html .= "</div>
                <div class='row'>";

        foreach ($catTip as $key) {

            $html .= "
            
                    <section class='6u 12u(narrower)'>
            <div class='box post' genre1='".$key->genre1."' type='indeterminee'>
            <form method='POST' name='id' value=".$key->id." action=".$this->httpRequest->urlFor('affProjetTip', array("id"=>$key->id))." >
            <input type='image' src='images/logot.png' alt='' class='image left' />
            </form>
           <!-- <a href='\".  . \"' class='image left'> alt='' /></a>-->
            <div class='inner'>
            <h3>". $key->intitule ."</h3>                   
            <p>". $key->montantActuel ." € Collecté!<br>
            ". mb_strimwidth(VueAccueil::interpreteBBCODE($key->libelle),0,250," ...") ."</p>
            </div>
            </div>
            </section>";

        }

        $html .= "</div>
                </div>
        </section>";

        return $html;
    }

    private function genererChoixProjet(){
        $html="
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content' >
                            <!-- Content -->
                            <p style='margin-left:43%'><a href='" . $this->httpRequest->urlFor('formulaireCreation') . "' class='button'>Créer un projet !</a></p>
                            <article>
							<div id='proj'>
                                <div class='imageleft'>
                                    <h3>Projet à durée déterminée</h3>
                                    <img src='images/logok.png' alt='' /><br><br>
                                </div>
                                    <p align='justify'>RuTips est une plateforme de financement participatif qui accueille des projets créatifs dans de nombreux domaines : cinéma, jeux, musique, art, design, technologie, etc. Originaux, ambitieux et innovants, les projets RuTips voient le jour grâce au soutien des contributeurs.</p>
                                    <h4>Comment ça marche ?</h4>
                                    <p align='justify'>Chaque créateur de projet choisit son objectif de financement et sa date de fin de campagne. Si le projet a du succès, les contributeurs s'engagent à le financer en fin de campagne. Les cartes bancaires des contributeurs ne sont débitées que si l'objectif de financement est atteint. Sur RuTips, le financement repose sur le principe du « tout ou rien » : si l'objectif de financement n'est pas atteint, personne ne paie.</p><br>
                                <br>
								</div>
								<div id='proj'>
                                <div class='imageleft'>
                                    <h3>Projet à durée indéterminée</h3>
                                    <img src='images/logot.png' alt='' /><br><br>
                                </div>
                                    <p align='justify'>Ici les créateurs sont des passionnés, qui fournissent déjà des contenus réguliers et gratuits à destination de leurs communautés. Or, contrairement à un site de financement participatif traditionnel, ils ne viennent pas sur RuTips pour demander de gros montants nécessaires à la réalisation d'un projet spécifique. Non ! Sur RuTips,les créateurs sollicitent leurs fans pour qu'ils les soutiennent dans ce qu'ils font déjà !</p>
                                    <h4>Comment ça marche ?</h4>
                                    <p align='justify'>Sur Rutips chaque créateur a une fiche. Il y présente son travail, sa démarche, le type de contenu qu'il fournit et à quel rythme il le fait. Pour devenir Tipeur d'un projet, l'internaute doit indiquer un montant (à partir de 1€) qu'il souhaite donner au créateur de contenu. Et pour rester dans des montants raisonnables, l'internaute peut indiquer dans tous les cas un maximum mensuel à ne pas dépasser.
                                    <br>
                                    Pour un humoriste sur youtube par exemple, il pourrait s'agir de donner 3€ par nouvelle vidéo réalisée, dans une limite de 9€ par mois. 
                                    Pour un streamer, il pourra s'agir de donner 5€ par mois. Sur Rutips, un tipser peut à tout moment modifier ou annuler ses promesses de don. Il n'y a donc ni obligation d'achat, ni objectif à atteindre, ni durée de collecte. Ici chacun participe à hauteur de ce qu'il souhaite, s'il le souhaite et pour la durée qu'il souhaite.</p></div>
                                
                            </article>
                        </div>
                    </div>
                </section>";


        return $html;
    }

        public function deconnexion(){
        $html= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Déconnexion Réussie !</h2>
                                    </header>
                                    <p>
                                    
                                    Vous venez de vous déconnecter!<br>
                                    Bonne journée.<br><br>
                                    <a href='" . $this->httpRequest->urlFor('accueil') . "' class='button'>Retour à l'accueil</a>
       
                                    </p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                    </article>

                        </div>
                    </div>
                </section>";
            return $html;
    }

    public function connexionReussi(){
        $html= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Connexion réussie</h2>
                                    </header>
                                    <p>
                                    Vous vous êtes connecté avec succès. Vous pouvez dès à présent vous déplacer sur le site.
                                    <br><br><a href='" . $this->httpRequest->urlFor('accueil') . "' class='button'>Accueil</a>
       
                                    </p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                    </article>

                        </div>
                    </div>
                </section>";
            return $html;
    }

    public function connexionFail(){
        $html= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Connexion échouée</h2>
                                    </header>
                                    <p>
                                    Votre identifiant est faux.
                                    <br><br><a href='" . $this->httpRequest->urlFor('connexion') . "' class='button'>Réssayer</a>
       
                                    </p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                    </article>

                        </div>
                    </div>
                </section>";
            return $html;
    }

    public function connexionMdp(){
        $html= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Connexion échouée</h2>
                                    </header>
                                    <p>
                                    Votre mot de passe est faux.
                                    <br><br><a href='" . $this->httpRequest->urlFor('connexion') . "' class='button'>Réssayer</a>
       
                                    </p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                    </article>

                        </div>
                    </div>
                </section>";
            return $html;
    }

    public function membreExistant(){
         $html= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Inscription échouée</h2>
                                    </header>
                                    <p>
                                    Votre identifiant existe déjà.
                                    <br><br><a href='" . $this->httpRequest->urlFor('inscription') . "' class='button'>Réssayer</a>
       
                                    </p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                    </article>

                        </div>
                    </div>
                </section>";
            return $html;
    }

    public function inscriptionReussi(){
        $html= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Inscription Réussie!!</h2>
                                    </header>
									<br><br>
                                    <a href='" . $this->httpRequest->urlFor('accueil') . "' class='button'>Retour à l'accueil</a>
                                    </article><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                        </div>
                    </div>
                </section>";
            return $html;
    }


    public function formulaireInscription()
    {
        $pageFormu= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2>Inscription au site</h2>
                                    </header>
                                    <p>
                                    <form method='POST' action='".$this->httpRequest->urlFor('add')."'>    
                                    <input type='text' name='username' placeholder='Identifiant' required /><br><br>
                                    <input type='password' name='mdp' placeholder='Mot de passe' required/><br><br>
                                    <input type='text' name='nom' placeholder='Nom' required/><br><br>
                                    <input type='text' name='prenom' placeholder='Prénom' required/><br><br>
                                    <input type='mail' name='mail' placeholder='Adresse Mail' required/><br><br>
                                    <input type='String' name='tel' placeholder='Numéro de Téléphone' required/><br><br>
                                    <input type='text' name='adresse' placeholder='Adresse' required/><br><br>
                                    <input type='String' name='cp' placeholder='Code postale' required/><br><br>
                                    <input type='text' name='ville' placeholder='Ville' required/><br><br>
                                    <button class='button' type='submit'>Creer</button>
                                    </form>

                                    </p>
                                    </article>

                        </div>
                    </div>
                </section>";
            return $pageFormu;
    }

    public function Connexion()
    {
        $pageFormu= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->
                                <article>
                                    <header>
                                        <h2>Connexion</h2>
                                    </header>
                                    <p>
                                    <form method='POST' action='".$this->httpRequest->urlFor('auth')."'>    
                                    <input type='text' name='username' placeholder='identifiant' required /><br><br>
                                    <input type='password' name='mdp' placeholder='mot de passe' required/><br><br>
                                    <button class='button' type='submit'>Connexion</button>
                                    </form>

                                    </p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                    </article>

                        </div>
                    </div>
                </section>";
            return $pageFormu;
    }

    public function profil(){
         $html= "<!-- Main -->
                <section class='wrapper style1'>
                    <div class='container'>
                        <div id='content'>

                            <!-- Content -->

                                <article>
                                    <header>
                                        <h2 style='text-align:center;'>Votre profil :</h2></div>
                                    </header>
                                    <p>";

                                    $user = Membres::where("id","=",$_SESSION['id'])->first();
                                    
                                    $html .= "<div class='profil'>
                                            <span style='float:left'>Identifiant : </span><span style='float:right'>". $user->username ."</span><br>
                                            <span style='float:left'>Nom : </span><span style='float:right'>". $user->nom ."</span><br>
                                            <span style='float:left'>Prénom : </span><span style='float:right'>". $user->prenom ."</span><br>
                                            <span style='float:left'>Adresse mail : </span><span style='float:right'>" .$user->mail."</span><br>                       
                                            <span style='float:left'>Adresse :  </span><span style='float:right'>" .$user->adresse." ".$user->codePostal." ".$user->ville."</span><br>
                                            <span style='float:left'>Téléphone :  </span><span style='float:right'>" .$user->telephone."</span><br><br>
                                            </div>
                                            <br>
                                            <ul>
                                                <li><h3 style='text-align:center'><a href='".$this->httpRequest->urlFor('mesdons')."'>Mes Dons</a></h3></li>";

                                            if(Authentication::checkAccessRights(4)){
                                                $html.="<li><h3 style='text-align:center'><a href='".$this->httpRequest->urlFor('mesprojets')."'>Mes Projets</a></h3></li>";
                                            }


                                            $html.="</ul><br><br><br><br><br><br><br><br>
                                    </p>
                                </article>

                        </div>
                    </div>
                </section>";
            return $html;
    }

    public function mesDons(){
        $id = $_SESSION['id'];
        $donkick = Donkick::where('idMembre','=',$id)->get();
        $dontip = Dontip::where('idMembre','=',$id)->get();



        $html = "<section class='wrapper style1'>
                    <div class='container'>
                        <div id='content' >
                            <!-- Content -->
                            <article>";

            if(empty($donkick[0])&&empty($dontip[0])){

                $html.="<br><br><br><p>Vous n'avez encore fais aucun don.</p><br><br><br><br><br>";

            }else{
                $html.="<p>";
                if(isset($donkick[0])){
                    foreach ($donkick as $key) {

                        $projetkick = ProjetKick::where('id','=',$key->idProjet)->get();
                        $html .= "J'ai donné ".$key->montant."€ au projet ".$projetkick[0]->intitule.".<br>";

                    }
                }

                        $html.="</p><p>";
                if(isset($dontip[0])){
                    foreach ($dontip as $key) {

                        $projettip = ProjetTipee::where('id','=',$key->idProjet)->get();
                        $html .= "J'ai donné ".$key->montant."€ au projet ".$projettip[0]->intitule.".<br>";

                    }
                }

                $html.="</p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
            }


        $html .=        "</article>
                        </div>
                    </div>
                </section>";

        return $html;
    }
    
    public function mesProjet(){
        $id = $_SESSION['id'];
        $kick = ProjetKick::where('idMembre','=',$id)->get();
        $tip = ProjetTipee::where('idMembre','=',$id)->get();

        $html="<section class='wrapper style1'>
                <div class='container'>
        <div class='row'>";

        foreach ($kick as $key) {

            $calcul=$kick[0]->montantActuel/$key->montantAttendu*100;
            $taillefinale=0;
            if($calcul>=100){
                $taillefinale=198;
            }else{
                for($i=0; $i<$calcul ; $i++){
                    $taillefinale+=2;
                }
            }

            $now  = time();
            $date = strtotime($key->dateCloture);
            $jour = $this->dateDiff($date,$now);

                $html .= "<section class='6u 12u(narrower)'>
                        <div class='box post'>
                       <form method='POST' name='id' value=".$key->id." action=".$this->httpRequest->urlFor('affProjetKick',array("id"=>$key->id)).">
                       <input type='image' src='images/logok.png' alt='' class='image left' />
                       </form>
                   <div class='inner'>
                   <h3>" . $key->intitule . "</h3>";
				   if($jour['day']<0&&$jour['hour']<0&&$jour['minute']<0){
						$html .= "Projet Cloturé";
						$jour['day']=0;
						$jour['hour']=0;
						$jour['minutes']=0;
				   }else{
						$html .= "<p>Temps restant : ".$jour['day']." jours ".$jour['hour']." heures ".$jour['minute']." minutes</p>";
				   }
				   
                   $html .= "<section class='bar' style='width:200px; height:20px; border : solid 1px; color : black; text-align : center; border-radius : 4px 4px;'>
                   <div class='bar' style='width:".$taillefinale."px;height:18px;background:#651c1b; border-radius : 4px 4px;'>
                   </div>". ((int)($key->montantActuel/$key->montantAttendu*100*100))/100 ." % <br>
                   </section> 
                   <p align='justify'><br>" . mb_strimwidth(VueAccueil::interpreteBBCODE($key->libelle),0,250,"...") . "</p>
                   </div>
                   </div>
                   </section>";    
            }

        $html .= "</div>
                <div class='row'>";

        foreach ($tip as $key) {
            $html .= "<section class='6u 12u(narrower)'>
                    <div class='box post'>
                    <form method='POST' name='id' value=".$key->id." action=".$this->httpRequest->urlFor('affProjetTip', array("id"=>$key->id))." >
            <input type='image' src='images/logot.png' alt='' class='image left' />
            </form>
            <div class='inner'>
            <h3>" . $key->intitule . "</h3>
            <p align='justify'>". $key->montantActuel ." € Collecté!<br>
            " . mb_strimwidth(VueAccueil::interpreteBBCODE($key->libelle),0,250,"...") . "</p>
            </div>
            </div>
            </section>";
        };

        $html .= "</div>
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

    static function  interpreteBBCODE($string){
        $string = str_replace("[b]","<strong>",$string);
        $string = str_replace("[/b]","</strong>",$string);
        $string = str_replace("[i]","<i>",$string);
        $string = str_replace("[/i]","</i>",$string);
        $string = str_replace("[center]","<center>",$string);
        $string = str_replace("[/center]","</center>",$string);
        $string = str_replace("[u]","<u>",$string);
        $string = str_replace("[/u]","</u>",$string);
        $string = str_replace("[right]","<p align='right'>",$string);
        $string = str_replace("[/right]","</p>",$string);
        $string = str_replace("[justify]","<p align='justify'>",$string);
        $string = str_replace("[/justify]","</p>",$string);
        $string = str_replace("[youtube]","<p><a href='https://www.youtube.com/watch?v=",$string);
        $string = str_replace("[/youtube]","'>lien de la video</a></p>",$string);

        $string = str_replace("[sub]","<sub>",$string);
        $string = str_replace("[/sub]","</sub>",$string);
        $string = str_replace("[sup]","<sup>",$string);
        $string = str_replace("[/sup]","</sup>",$string);
        $string = str_replace("[s]","<s>",$string);
        $string = str_replace("[/s]","</s>",$string);



        $string = str_replace('[rl]','<br>',$string);
        $string = str_replace("[font=","<font face='",$string);
        $string = str_replace("[/font]","</font>",$string);
        $string = str_replace("[size=","<font size='",$string);
        $string = str_replace("[/size]","</font>",$string);
        $string = str_replace("]","'>",$string);

        return $string;
    }
}
