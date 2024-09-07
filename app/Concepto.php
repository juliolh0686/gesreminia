<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    protected $table = 'conceptos';

    protected $primaryKey ='cod_concepto';
    public $incrementing = false;

    protected $fillable = ['cod_concepto','con_nombre','con_abrev','con_afecto','tipo_concepto_cod_tip_concepto'];
}
