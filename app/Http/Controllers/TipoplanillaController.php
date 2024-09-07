<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoPlanilla;

class TipoplanillaController extends Controller
{
    public function selectTipoplanilla(Request $request){
        
        //if (!$request->ajax()) return redirect('/');

        $tipoplanilla = Tipoplanilla::select('cod_tipo_planilla','tpll_tipo_planilla')->orderBy('cod_tipo_planilla','asc')->get();
        return ['tipoplanilla'=>$tipoplanilla];
    }
}
