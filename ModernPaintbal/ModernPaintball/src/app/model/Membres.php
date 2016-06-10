<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Membres extends Model
{

        protected $table = 'membre';
        protected $primaryKey = 'id';
        public $timestamps = false;
    
    public function projetKick(){
        return $this->hasMany('\app\model\ProjetKick','idMembre');
    }
    
    public function projetTip(){
        return $this->hasMany('\app\model\ProjetTipee','idMembre');
    }

}
?>


