<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipopago extends Model
{
    protected $table = 'tipo_pago';

    protected $primaryKey ='cod_tipo_pago';
    public $incrementing = false;

    protected $fillable = ['cod_tipo_pago','tp_tipo_pago'];
}
