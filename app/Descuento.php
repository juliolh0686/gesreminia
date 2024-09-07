<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $table = 'descuentos';

    protected $primaryKey ='cod_descuento';

    protected $fillable = ['cod_descuento','d_monto','d_inicio','d_termino','contrato_cod_contrato','concepto_cod_concepto'];
}
