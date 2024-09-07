<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tiporegistroairhsp;

class TiporegistroairhspController extends Controller
{
    public function selectTiporegistroairhsp(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $tipoRegistroairhsp = Tiporegistroairhsp::select('tra_id','tra_descripcion')->orderBy('tra_id','asc')->get();
        return ['tipoRegistroairhsp'=>$tipoRegistroairhsp];
    }
}
