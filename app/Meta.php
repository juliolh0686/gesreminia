<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'meta';

    protected $primaryKey ='m_cod_meta';

    protected $fillable = ['m_cod_meta','meta','descripcion'];
}
