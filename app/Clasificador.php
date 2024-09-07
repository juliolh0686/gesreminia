<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clasificador extends Model
{
    use HasFactory;

    protected $table = 'clasificador';

    protected $primaryKey ='idclasificador';
    public $incrementing = false;

    protected $fillable = ['idclasificador','clasificador','cla_descripcion','cl_vista'];

}
