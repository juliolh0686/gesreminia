<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compfam extends Model
{
    protected $table = 'comp_fam';

    protected $primaryKey ='cod_comp_fam';

    protected $fillable = ['cod_comp_fam','cf_des_comp_fam'];
}
