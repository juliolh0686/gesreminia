<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $table = 'planilla';

    protected $primaryKey ='cod_planilla';

    protected $fillable = ['cod_planilla','pll_periodo','pll_bruto','pll_desc','pll_liquido','pll_aport','pll_detalle','planilla_estado_cod_plla_estado','tipo_planilla_cod_tipo_planilla','clase_planilla_cod_clase_planilla'];
}
