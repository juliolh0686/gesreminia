<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clasificador;

class ClasificadorController extends Controller
{
    public function selectClasificador(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $clasificador = Clasificador::select('idclasificador','clasificador','cla_descripcion')
            ->where('cl_vista', 1)
            ->orderBy('idclasificador','desc')
            ->get();

        return ['clasificador'=>$clasificador];
    }
}
