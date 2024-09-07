<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';

    protected $primaryKey ='cod_provincia';
    public $incrementing = false;

    protected $fillable = ['cod_provincia','pro_provincia','departamento_cod_departamento'];
}
