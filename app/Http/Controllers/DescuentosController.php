<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Descuento;

class DescuentosController extends Controller
{
    public function listDescuentos(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $cod_contrato=$request->cod_contrato;
 
         $descuentos = Descuento::join('conceptos','descuentos.concepto_cod_concepto','=','conceptos.cod_concepto')
                    ->where('contrato_cod_contrato','=',$cod_contrato)
                    ->orderBy('d_termino','asc')->get();

         return ['descuentos'=>$descuentos];
     }

     public function store(Request $request){

        if (!$request->ajax()) return redirect('/');

        //Validacion del Formulario

        $rules = [
            'd_monto'=>'required|numeric|min:1',
            'concepto_cod_concepto'=>'required|size:4',
            'd_inicio'=>'required|size:6',
            'd_termino'=>'required|size:6',
        ];

        $messages = [
            'd_monto.required' => 'Ingresar Monto',
            'd_monto.numeric' => 'Ingresar datos numericos',
            'd_monto.min' => 'Ingresar un numero mayor a 0',
            'concepto_cod_concepto.required' =>'Debe Seleccionar un Concepto',
            'concepto_cod_concepto.size' =>'Debe Seleccionar un Concepto',
            'd_inicio.required' =>'Ingresar Periodo',
            'd_inicio.size' =>'Periodo invalido',
            'd_termino.required' =>'Ingresar Periodo',
            'd_termino.size' =>'Periodo invalido',
        ];

        $this->validate($request,$rules,$messages);

        //Fin validacion del formulario

        $descuento= new Descuento();
        $descuento->d_monto = $request->d_monto;
        $descuento->d_inicio = $request->d_inicio;
        $descuento->d_termino = $request->d_termino;
        $descuento->contrato_cod_contrato = $request->contrato_cod_contrato;
        $descuento->concepto_cod_concepto = $request->concepto_cod_concepto;
        $descuento->save();
    }

    public function update(Request $request){

        if (!$request->ajax()) return redirect('/');

        //Validacion del Formulario

        $rules = [
            'd_monto'=>'required|numeric|min:1',
            'concepto_cod_concepto'=>'required|size:4',
            'd_inicio'=>'required|size:6',
            'd_termino'=>'required|size:6',
        ];

        $messages = [
            'd_monto.required' => 'Ingresar Monto',
            'd_monto.numeric' => 'Ingresar datos numericos',
            'd_monto.min' => 'Ingresar un numero mayor a 0',
            'concepto_cod_concepto.required' =>'Debe Seleccionar un Concepto',
            'concepto_cod_concepto.size' =>'Debe Seleccionar un Concepto',
            'd_inicio.required' =>'Ingresar Periodo',
            'd_inicio.size' =>'Periodo invalido',
            'd_termino.required' =>'Ingresar Periodo',
            'd_termino.size' =>'Periodo invalido',
        ];

        $this->validate($request,$rules,$messages);

        //Fin validacion del formulario

        $descuento= Descuento::findOrFail($request->cod_descuento);
        $descuento->d_monto = $request->d_monto;
        $descuento->d_inicio = $request->d_inicio;
        $descuento->d_termino = $request->d_termino;
        $descuento->concepto_cod_concepto = $request->concepto_cod_concepto;
        $descuento->save();
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $descuento= Descuento::find($request->cod_descuento);
        $descuento->delete();
    }
}
