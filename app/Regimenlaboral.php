<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regimenlaboral extends Model
{
    protected $table = 'regimen_laboral';

    protected $primaryKey ='cod_regimen_laboral';
    public $incrementing = false;

    protected $fillable = ['cod_regimen_laboral','rl_regimen_laboral'];
}
