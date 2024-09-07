<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipodocumento extends Model
{
    protected $table = 'tipo_documento';

    protected $primaryKey ='cod_tipo_documento';
    public $incrementing = false;

    protected $fillable = [
        'cod_tipo_documento', 'td_documento',
    ];
}
