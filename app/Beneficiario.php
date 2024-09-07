<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    protected $table = 'beneficiario';

    protected $primaryKey ='cod_beneficiario';

    protected $fillable = ['cod_beneficiario','b_paterno','b_materno','	b_nombres','tipo_documento_cod_tipo_documento','b_numdoc','b_resjudicial','b_fechjudicial','b_fijo','b_porcentaje','tipo_pago_cod_tipo_pago','banco_cod_banco','b_cuenta','b_observacion','contrato_cod_contrato','estado_idestado'];
}
