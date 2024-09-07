<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanEps extends Model
{
    protected $table = 'plan_eps';

    protected $primaryKey ='cod_plan_eps';

    protected $fillable = ['cod_plan_eps','pe_des_plan_eps'];
}
