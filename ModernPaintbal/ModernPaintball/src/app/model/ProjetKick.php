<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 07/10/2016
 * Time: 14:22
 */

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class ProjetKick extends Model
{
	protected $table = 'projetkick';
	protected $primaryKey = 'id';
	public $timestamps = false;
    
    public function auteurs(){
        return $this->belongsTo('\app\model\Membres','idMembre');
    }
}