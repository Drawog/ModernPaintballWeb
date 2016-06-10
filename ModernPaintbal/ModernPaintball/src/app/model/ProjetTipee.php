<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 07/10/2016
 * Time: 14:27
 */

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class ProjetTipee extends Model
{

	protected $table = 'projettipee';
	protected $primaryKey = 'id';
	public $timestamps = false;

    public function auteurs(){
        return $this->belongsTo('\app\model\Membres','idMembre');
    }
}