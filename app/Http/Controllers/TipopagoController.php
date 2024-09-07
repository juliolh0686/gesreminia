<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipopago;

class TipopagoController extends Controller
{
    public function selectTipopago(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $tipopago = Tipopago::select('cod_tipo_pago','tp_tipo_pago')->orderBy('cod_tipo_pago','asc')->get();
        return ['tipopago'=>$tipopago];
    }
}
