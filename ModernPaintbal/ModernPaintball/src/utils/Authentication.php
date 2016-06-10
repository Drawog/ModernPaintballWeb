<?php

namespace utils;

use app\model\Membres;
use PasswordLib\PasswordLib;
use PasswordPolicy\Policy;

class Authentication {

	const SUCCESS = 0;
	const MAUVAIS_MOTDEPASSE = 1;
	const UTILISATEUR_INEXISTANT = 2;

	const MEMBRE = 3;
	const CREATEURPROJET = 4;
	const ADMIN = 5;

	public static function checkAccessRights($required) {
		if(isset($_SESSION['accessRight']) && $_SESSION['accessRight'] >= $required)
			return true;
		else 
			return false;
	}

	public static function loadProfile($uid) {
		$user = Membres::where('username', '=', $uid)->first();

		$_SESSION['id'] = $user->id;
		$_SESSION['accessRight'] = $user->accessRight;
 	}

	public static function authenticate($username, $password) {
		$passLib = new PasswordLib;

		$user = Membres::where('username', '=', $username)->first();

		if(empty($user))
			return Authentication::UTILISATEUR_INEXISTANT;
		else if($passLib->verifyPasswordHash($password, $user->passwords))
			return Authentication::SUCCESS;
		else
			return Authentication::MAUVAIS_MOTDEPASSE;
	}

}