<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $table = 'variables';

    protected $primaryKey ='cod_variable';
    public $incrementing = false;

    protected $fillable = ['cod_variable','var_nombre','var_monto','var_detalle'];
}
