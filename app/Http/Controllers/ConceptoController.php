<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Concepto;

class ConceptoController extends Controller
{
    public function selectConcepto(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $tipo_concepto= $request->tipo_concepto;

        $concepto = Concepto::select('cod_concepto','con_abrev')
        ->where('con_auto','=',0)
        ->where('tipo_concepto_cod_tip_concepto','=',$tipo_concepto)
        ->orderBy('cod_concepto','asc')->get();
        return ['concepto'=>$concepto];
    }
}
