<?php
/**
 * Created by PhpStorm.
 * User: triest
 * Date: 09.06.2018
 * Time: 9:34
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'id','datetime','sha1_hash','currency','lable','operation_id'
    ];
    /*
        public function girl()
        {
            return $this->belongsTo('App\Girl','girls_id');
        }
    */
}