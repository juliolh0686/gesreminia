<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
    protected $table = 'parametros';

    protected $primaryKey ='pm_id';

    protected $fillable = ['pm_id','pm_nombre','pm_nombre_abrev','pm_monto','pm_porcentaje','pm_descripcion'];
}
