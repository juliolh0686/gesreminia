<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planillajudicial extends Model
{
    protected $table = 'planilla_judicial';

    protected $primaryKey ='codplanilla_judicial';

    protected $fillable = ['codplanilla_judicial','pj_monto','beneficiarios_cod_beneficiario','detalleplanillas_cod_detalle_planilla'];
}
