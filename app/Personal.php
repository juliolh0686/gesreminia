<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table='personal';

    protected $primaryKey='cod_personal';

    protected $fillable = [
        'cod_personal','tipo_documento_cod_tipo_documento','p_num_doc','p_a_paterno','p_a_materno','p_nombres','foto','p_fech_nac','sexo_cod_sexo',
        'estado_civil_cod_estado_civil','p_ruc','distrito_cod_distrito','p_direccion','p_correo','p_telefono','p_celular','p_observacion',
        'admin_pension_cod_admin_pension','p_cuspp','p_fech_afiliacion','banco_cod_banco','p_num_cuenta'
    ];

}
