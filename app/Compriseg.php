<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compriseg extends Model
{
    protected $table = 'compriseg';

    protected $primaryKey ='cod_compriseg';

    protected $fillable = ['cod_compriseg','cpsperiodo','cpscomision','spsprima','cpsaporte','admin_pension_cod_admin_pension'];
}
