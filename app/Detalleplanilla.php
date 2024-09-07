<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalleplanilla extends Model
{
    protected $table = 'detalle_planilla';

    protected $primaryKey ='cod_detalle_planilla';

    protected $fillable = ['cod_detalle_planilla','dpll_bruto','dpll_descuentos','dpll_liquido','dpll_aport','planilla_cod_planilla','contrato_cod_contrato'];

    public function Planilla_Conceptos()
    {
        return $this->hasMany('App\Planillaconceptos', 'detalle_planilla_cod_detalle_planilla','cod_detalle_planilla')->join('conceptos', 'planilla_conceptos.concepto_cod_concepto', '=', 'conceptos.cod_concepto');
    }
    
}
