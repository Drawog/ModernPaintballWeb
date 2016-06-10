<?php


namespace app\model;


use Illuminate\Database\Eloquent\Model;

class CompteBancaire extends Model
{

        protected $table = 'compteBancaire';
        protected $primaryKey = 'NumCompte';
        public $timestamps = false;

}
?>