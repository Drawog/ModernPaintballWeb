<?php
/**
 * Created by PhpStorm.
 * User: Drawog
 * Date: 25/02/2016
 * Time: 20:49
 */

namespace app\model;


use Illuminate\Database\Eloquent\Model;
class RecompenceTipee extends Model
{
    protected $table = 'recompencetipee';
    protected $primaryKey = 'id';
    public $timestamps = false;

}