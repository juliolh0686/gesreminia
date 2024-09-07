<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'distritos';

    protected $primaryKey ='cod_distrito';
    public $incrementing = false;

    protected $fillable = ['cod_distrito','dis_distrito','provincia_cod_provincia'];
}
