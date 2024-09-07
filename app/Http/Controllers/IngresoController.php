<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingreso;

class IngresoController extends Controller
{
    public function listIngreso(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $cod_contrato=$request->cod_contrato;
 
         $ingreso = Ingreso::join('conceptos','ingresos.concepto_cod_concepto','=','conceptos.cod_concepto')
                ->where('contrato_cod_contrato','=',$cod_contrato)
                ->orderBy('cod_ingreso','asc')->get();

         return ['ingreso'=>$ingreso];
     }

     public function store(Request $request){

        if (!$request->ajax()) return redirect('/');

        //Validacion del Formulario

        $rules = [
            'i_monto'=>'required|numeric|min:1',
            'concepto_cod_concepto'=>'required|size:4',
        ];

        $messages = [
            'i_monto.required' => 'Ingresar Monto',
            'i_monto.numeric' => 'Ingresar datos numericos',
            'i_monto.min' => 'Ingresar un numero mayor a 0',
            'concepto_cod_concepto.required' =>'Debe Seleccionar un Concepto',
            'concepto_cod_concepto.size' =>'Debe Seleccionar un Concepto',
        ];

        $this->validate($request,$rules,$messages);

        //Fin validacion del formulario

        $ingreso= new Ingreso();
        $ingreso->i_monto = $request->i_monto;
        $ingreso->contrato_cod_contrato = $request->contrato_cod_contrato;
        $ingreso->concepto_cod_concepto = $request->concepto_cod_concepto;
        $ingreso->save();
    }

    public function update(Request $request){

        if (!$request->ajax()) return redirect('/');

        //Validacion del Formulario

        $rules = [
            'i_monto'=>'required|numeric|min:1',
            'concepto_cod_concepto'=>'required|size:4',
        ];

        $messages = [
            'i_monto.required' => 'Ingresar Monto',
            'i_monto.numeric' => 'Ingresar datos numericos',
            'i_monto.min' => 'Ingresar un numero mayor a 0',
            'concepto_cod_concepto.required' =>'Debe Seleccionar un Concepto',
            'concepto_cod_concepto.size' =>'Debe Seleccionar un Concepto',
        ];

        $this->validate($request,$rules,$messages);

        //Fin validacion del formulario

        $ingreso= Ingreso::findOrFail($request->cod_ingreso);
        $ingreso->i_monto = $request->i_monto;
        $ingreso->concepto_cod_concepto = $request->concepto_cod_concepto;
        $ingreso->save();
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $ingreso= Ingreso::find($request->cod_ingreso);
        $ingreso->delete();
    }

}
