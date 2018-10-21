<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
       'id' ,'name','id_region','id_country','id_city'
    ];

}
