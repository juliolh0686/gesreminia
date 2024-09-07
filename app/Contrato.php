<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table='contratos';

    protected $primaryKey='cod_contrato';

    protected $fillable = [
        'cod_contrato','c_numero','c_plaza','c_cod_reg_airhsp','c_fech_contrato','c_fech_ini','c_fech_ter','area_a_cod_area',
        'cargo_cod_cargo','regimen_laboral_cod_regimen_laboral','tipo_trabajador_cod_tipo_trabajador',
        'tipo_planilla_cod_tipo_planilla','clasificador_id','meta_m_cod_meta','c_horas','sus_renta','num_operacion',
        'c_eps','plan_eps_cod_plan_eps','comp_fam_cod_comp_fam','c_dias_lab','c_dias_lic','c_desc_dias',
        'c_desc_horas','c_desc_min','c_desc_perm','c_observacion','personal_cod_personal',
        'tipo_pago_cod_tipo_pago','estado_personal_cod_estado_personal','tipo_registro_airhsp_tra_id'
    ];
}
