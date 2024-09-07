<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Primaeps extends Model
{
    protected $table = 'prima_eps';

    protected $primaryKey ='cod_plan_eps';

    protected $fillable = ['cod_prima_eps','plan_eps_cod_plan_eps','comp_fam_cod_comp_fam','p_eps_monto'];
}
