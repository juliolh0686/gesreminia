<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadopersonal extends Model
{
    protected $table='estado_personal';

    protected $primaryKey='cod_estado_personal';
    public $incrementing = false;

    protected $fillable = [
        'cod_estado_personal', 'es_estado_personal'
    ];
}
