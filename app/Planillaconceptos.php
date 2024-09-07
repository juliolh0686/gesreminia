<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planillaconceptos extends Model
{
    protected $table = 'planilla_conceptos';

    protected $primaryKey ='cod_planilla_conceptos';
    public $incrementing = false;

    protected $fillable = [
        'cod_planilla_conceptos', 'pll_id_monto', 'concepto_cod_concepto', 'detalle_planilla_cod_detalle_planilla'
    ];
}
