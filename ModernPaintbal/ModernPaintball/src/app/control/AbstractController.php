<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 07/10/2016
 * Time: 13:32
 */

namespace app\control;


abstract class AbstractController
{
    protected $httpRequest;

    function __construct($http)
    {
        $this->httpRequest=$http;
    }

    /**
	 * Accesseur get magique
	 * @param string[$attName] nom de l'attribut
	 */
	public function __get($attName) {
		if(property_exists($this, $attName))
			return $this->$attName;
		else throw new \Exception("Erreur : attribut ".$attName." inexistant.", 1);
	}

	/**
	 * Accesseur set magique
	 * @param string[$attName] nom de l'attribut
	 * @param string[$value] valeur de l'attribut
	 */
	public function __set($attName, $value) {
		if(property_exists($this, $attName))
			$this->$attName = $value;
		else throw new \Exception("Erreur : attribut ".$attName." inexistant.", 1);
	}

    
}