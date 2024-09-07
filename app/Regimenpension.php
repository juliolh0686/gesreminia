<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regimenpension extends Model
{
    protected $table = 'reg_pensiones';

    protected $primaryKey ='cod_regimen_pension';
    public $incrementing = false;

    protected $fillable = ['cod_regimen_pension','rp_regimen_pension'];
}
