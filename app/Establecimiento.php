<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    protected $table = 'establecimientos';

    protected $primaryKey ='est_codigo';
    public $incrementing = false;

    protected $fillable = ['est_codigo','est_establecimiento','nivel_educ_cod_nivel'];
}
