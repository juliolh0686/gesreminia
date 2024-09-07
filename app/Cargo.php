<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargos';

    protected $primaryKey ='cod_cargo';
    public $incrementing = false;

    protected $fillable = ['cod_cargo','c_nomcar','c_abrev_cargo'];
}
