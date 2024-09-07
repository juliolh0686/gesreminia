<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estadopersonal;

class EstadopersonalController extends Controller
{
    public function selectEstadopersonal(Request $request){
        
        if (!$request->ajax()) return redirect('/');
 
         $estadopersonal = Estadopersonal::select('cod_estado_personal','es_estado_personal')->orderBy('cod_estado_personal','asc')->get();
         return ['estadopersonal'=>$estadopersonal];
     }
}
