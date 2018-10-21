<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{

    protected $fillable = [
        'name','id_country','id_region '
    ];

}
