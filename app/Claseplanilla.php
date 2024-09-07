<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Claseplanilla extends Model
{
    protected $table = 'clase_planilla';

    protected $primaryKey ='cod_clase_planilla';
    public $incrementing = false;

    protected $fillable = ['cod_clase_planilla','cpll_clase_planilla'];
}
