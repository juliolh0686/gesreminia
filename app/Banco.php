<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'bancos';

    protected $primaryKey ='cod_banco';
    public $incrementing = false;

    protected $fillable = ['cod_banco','b_banco'];
}
