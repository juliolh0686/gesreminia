<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aseguradora extends Model
{
    use HasFactory;

    protected $table='aseguradora';

    protected $primaryKey='cod_aseguradora';
    public $incrementing = false;

    protected $fillable = [
        'cod_aseguradora','aseguradora'
    ];
}
