<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uejecutora extends Model
{
    protected $table = 'unidad_ejecutora';

    protected $primaryKey ='ue_id';

    protected $fillable = ['ue_id','ue_ruc','ue_nombre','ue_direccion','ue_logo'];
}
