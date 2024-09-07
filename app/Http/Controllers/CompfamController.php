<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Compfam;

class CompfamController extends Controller
{
    public function selectCompfam(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $compfam = Compfam::select('cod_comp_fam','cf_des_comp_fam')->orderBy('cod_comp_fam','asc')->get();
        return ['compfam'=>$compfam];
    }
}
