<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingresos';

    protected $primaryKey ='cod_ingreso';
    public $incrementing = false;

    protected $fillable = ['cod_ingreso','i_monto','contrato_cod_contrato','concepto_cod_concepto'];
}
