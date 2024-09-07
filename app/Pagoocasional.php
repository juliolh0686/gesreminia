<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagoocasional extends Model
{
    protected $table = 'pago_ocasional';

    protected $primaryKey ='cod_pago_ocasional';

    protected $fillable = ['cod_pago_ocasional','po_monto','po_inicio','po_termino','contrato_cod_contrato','concepto_cod_concepto'];
}
