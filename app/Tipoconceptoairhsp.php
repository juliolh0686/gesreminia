<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoconceptoairhsp extends Model
{
    use HasFactory;

    protected $table='tipo_concepto_airhsp';

    protected $primaryKey='tca_id';

    protected $fillable = [
        'tca_id','tca_descripcion'
    ];
}
