<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adminpension extends Model
{
    protected $table = 'admin_pensiones';

    protected $primaryKey ='cod_admin_pension';
    public $incrementing = false;

    protected $fillable = ['cod_admin_pension','ap_admin_pension','regimen_pension_cod_regimen_pension','ap_comision','ap_prima','ap_aporte','ap_aporte_fijo','ap_total_admpen','det_resumen'];
}
