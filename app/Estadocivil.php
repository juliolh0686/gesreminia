<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estadocivil extends Model
{
    protected $table = 'estado_civil';

    protected $primaryKey ='cod_estado_civil';
    public $incrementing = false;

    protected $fillable = [
        'cod_estado_civil', 'ec_estado_civil',
    ];
}
