<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    use HasFactory;

    protected $table='estacion';

    protected $primaryKey='est_id';

    protected $fillable = [
        'est_id','e_cod_est','est_nombre','ejecutora_e_id'
    ];
}
