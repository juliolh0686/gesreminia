<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiporegistroairhsp extends Model
{
    use HasFactory;

    protected $table='tipo_registro_airhsp';

    protected $primaryKey='tra_id';

    protected $fillable = [
        'tra_id','tra_descripcion'
    ];
}
