<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table='areas';

    protected $primaryKey='a_cod_area';
    public $incrementing = false;

    protected $fillable = [
        'a_cod_area','a_area'
    ];
}
