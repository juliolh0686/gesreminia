<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table='departamentos';

    protected $primaryKey='cod_departamento';
    public $incrementing = false;

    protected $fillable = [
        'cod_departamento', 'dep_departamento'
    ];
}
