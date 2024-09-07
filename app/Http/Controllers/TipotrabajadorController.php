<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipotrabajador;

class TipotrabajadorController extends Controller
{
    public function selectTipotrabajador(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $tipotrabajador = Tipotrabajador::select('cod_tipo_trabajador','tt_tipo_trabajador')->orderBy('cod_tipo_trabajador','asc')->get();
        return ['tipotrabajador'=>$tipotrabajador];
    }
}
