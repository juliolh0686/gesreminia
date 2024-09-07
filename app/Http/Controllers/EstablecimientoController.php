<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Establecimiento;

class EstablecimientoController extends Controller
{
    public function selectEstablecimiento(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $cod_nivel= $request->cod_nivel;

        $establecimiento=Establecimiento::select('est_codigo','est_establecimiento')->where('nivel_educ_cod_nivel','=',$cod_nivel)->orderBy('est_establecimiento','asc')->get();
        return ['establecimiento'=>$establecimiento];
    }
}
