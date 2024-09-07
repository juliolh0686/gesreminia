<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipotrabajador extends Model
{
    protected $table = 'tipo_trabajador';

    protected $primaryKey ='cod_tipo_trabajador';
    public $incrementing = false;

    protected $fillable = ['cod_tipo_trabajador','tt_tipo_trabajador'];
}
