<?php
/**
 * Created by PhpStorm.
 * User: triest
 * Date: 09.06.2018
 * Time: 9:34
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
         'id','photo_name','girl_id','update_at','create_at'
    ];
/*
    public function girl()
    {
        return $this->belongsTo('App\Girl','girls_id');
    }
*/
}