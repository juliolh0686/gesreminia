<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conceptoairhsp extends Model
{
    use HasFactory;

    protected $table='concepto_airhsp';

    protected $primaryKey='ca_id';

    protected $fillable = [
        'ca_id','ca_cod_concepto','ca_descripcion','ca_detalle','tipo_concepto_airhsp_tca_id'
    ];
}
