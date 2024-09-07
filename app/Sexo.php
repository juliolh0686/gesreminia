<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $table='sexo';

    protected $primaryKey='cod_sexo';
    public $incrementing = false;

    protected $fillable = [
        'cod_sexo', 's_sexo'
    ];
}
