<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipoplanilla extends Model
{
    protected $table = 'tipo_planilla';

    protected $primaryKey ='cod_tipo_planilla';
    public $incrementing = false;

    protected $fillable = ['cod_tipo_planilla','tpll_tipo_planilla'];
}
