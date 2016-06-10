<?php
session_start();

require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager;

use app\control\DefaultControler;
use app\control\ProjetController;
use app\control\DonControler;
use app\control\ConnexionControler;
use app\control\InscriptionController;

use app\view\abstractView;
use app\view\VueAccueil;
use app\view\VueProjet;

$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('/src/conf/db.etuapp.conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

$app = new \Slim\slim();

		//CONTROL ACCUEIL
		$app->get('/',function() use ($app){
			$control = new DefaultControler($app);
			$control->afficherAccueil();
		})->name('accueil');

		$app->get('/catalogue',function() use ($app){
			$control = new DefaultControler($app);
			$control->afficherCatalogue();
		})->name('catalogue');

		$app->get('/profil',function() use ($app){
			$control = new DefaultControler($app);
			$control->afficherProfil();
		})->name('profil');

        $app->post('/catalogue',function() use ($app){
			$control = new DefaultControler($app);
			$control->afficherCatalogue();
		})->name('catalogue1');

		$app->get('/mesDons',function() use ($app){
			$control = new DefaultControler($app);
			$control->afficherDon();
		})->name('mesdons');

		$app->get('/mesProjets',function() use ($app){
			$control = new DefaultControler($app);
			$control->afficherProjet();
		})->name('mesprojets');



		//PROJET
		$app->get('/creaProjet',function() use ($app){
			$controlProjet = new ProjetController($app);
			$controlProjet->afficherChoixCreation();
		})->name('creaproj');

		$app->get('/creerProjet',function() use ($app){
			$controlProjet = new ProjetController($app);
			$controlProjet->affichercreationKick();
		})->name('formulaireCreation');
		/**
		$app->get('/creaKick',function() use ($app){
			$controlProjet = new ProjetController($app);
			$controlProjet->affichercreationKick();
		})->name('creaKick');

		$app->get('/creaTip',function() use ($app){
			$controlProjet = new ProjetController($app);
			$controlProjet->affichercreationTipee();
		})->name('creaTip');
		*/

		$app->post('/Projet:id',function($id) use ($app){
			$controlProjet = new ProjetController($app);
			$controlProjet->postProjet($id);
		})->name('addProjet');

		$app->post('/ProjetKick/add/:id',function($id) use ($app){
			$controlProjet = new ProjetController($app);
			$controlProjet->postKick($id);
		})->name('addKick');

		$app->post('/ProjetTip/add/:id',function($id) use ($app){
			$controlProjet = new ProjetController($app);
			$controlProjet->postTip($id);
		})->name('addTip');

		$app->post('/affProjetKick:id',function($id) use ($app){
			$controlProjet = new ProjetController($app);
			$controlProjet->affDetKick($id);
		})->name('affProjetKick');

		$app->post('/affProjetTip:id',function($id) use ($app){
			$controlProjet = new ProjetController($app);
			$controlProjet->affDetTip($id);
		})->name('affProjetTip');

		$app->post('/finRecompense:id:type', function($id,$type) use($app){
			$controlProjet = new ProjetController($app);
			$controlProjet->affFinRecompense($id,$type);
		})->name('finRecompense');

		


		//DON
		$app->post('/ProjetKick/don/:id',function($id) use ($app){
			$controlDon = new DonControler($app);
			$controlDon->afficherDonKick($id);
		})->name('donKick');

		$app->post('/ProjetTip/don/:id',function($id) use ($app){
			$controlDon = new DonControler($app);
			$controlDon->afficherDonTip($id);
		})->name('donTip');

		$app->post('/ProjetKick/don/confirm/:id',function($id) use ($app){
			$controlDon = new DonControler($app);
			$controlDon->DonProjetKick($id);
		})->name('donKickConf');
		
		$app->post('/ProjetTip/don/confirm/:id',function($id) use ($app){
			$controlDon = new DonControler($app);
			$controlDon->DonProjetTips($id);
		})->name('donTipConf');





		//CONNEXION ET INSCRIPTION
		$app->get('/inscription',function() use ($app){
			$control = new InscriptionController($app);
			$control->creation_client();
		})->name('inscription');

		$app->post('/inscription/add',function() use ($app){
			$control = new InscriptionController($app);
			$control->inscription();
		})->name('add');

		$app->get('/connexion',function() use ($app){
			$control = new ConnexionControler($app);
			$control->connexion();
		})->name('connexion');

		$app->post('/auth',function() use ($app){
			$control = new ConnexionControler($app);
			$control->auth();
		})->name('auth');

		$app->get('/deconnexion',function() use ($app){
			$control = new ConnexionControler($app);
			$control->deco();
		})->name('deconnexion');

$app->run();
		
?>
