<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Claseplanilla;

class ClaseplanillaController extends Controller
{
    public function selectClaseplanilla(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $claseplanilla = Claseplanilla::select('cod_clase_planilla','cpll_clase_planilla')->orderBy('cod_clase_planilla','asc')->get();
        return ['claseplanilla'=>$claseplanilla];
    }
}
