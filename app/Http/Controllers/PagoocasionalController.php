<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pagoocasional;

class PagoocasionalController extends Controller
{
    public function listPagoocasional(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $cod_contrato=$request->cod_contrato;
 
         $pagoocasional = Pagoocasional::join('conceptos','pago_ocasional.concepto_cod_concepto','=','conceptos.cod_concepto')
                ->where('contrato_cod_contrato','=',$cod_contrato)
                ->orderBy('po_termino','asc')->get();

         return ['pagoocasional'=>$pagoocasional];
     }

    public function store(Request $request){

        if (!$request->ajax()) return redirect('/');

        //Validacion del Formulario

        $rules = [
            'po_monto'=>'required|numeric|min:1',
            'concepto_cod_concepto'=>'required|size:4',
            'po_inicio'=>'required|size:6',
            'po_termino'=>'required|size:6',
        ];

        $messages = [
            'po_monto.required' => 'Ingresar Monto',
            'po_monto.numeric' => 'Ingresar datos numericos',
            'po_monto.min' => 'Ingresar un numero mayor a 0',
            'concepto_cod_concepto.required' =>'Debe Seleccionar un Concepto',
            'concepto_cod_concepto.size' =>'Debe Seleccionar un Concepto',
            'po_inicio.required' =>'Ingresar Periodo',
            'po_inicio.size' =>'Periodo invalido',
            'po_termino.required' =>'Ingresar Periodo',
            'po_termino.size' =>'Periodo invalido',
        ];

        $this->validate($request,$rules,$messages);

        //Fin validacion del formulario


        $ocasional= new Pagoocasional();
        $ocasional->po_monto = $request->po_monto;
        $ocasional->po_inicio = $request->po_inicio;
        $ocasional->po_termino = $request->po_termino;
        $ocasional->contrato_cod_contrato = $request->contrato_cod_contrato;
        $ocasional->concepto_cod_concepto = $request->concepto_cod_concepto;
        $ocasional->save();
    }

    public function update(Request $request){

        if (!$request->ajax()) return redirect('/');

        //Validacion del Formulario

        $rules = [
            'po_monto'=>'required|numeric|min:1',
            'concepto_cod_concepto'=>'required|size:4',
            'po_inicio'=>'required|size:6',
            'po_termino'=>'required|size:6',
        ];

        $messages = [
            'po_monto.required' => 'Ingresar Monto',
            'po_monto.numeric' => 'Ingresar datos numericos',
            'po_monto.min' => 'Ingresar un numero mayor a 0',
            'concepto_cod_concepto.required' =>'Debe Seleccionar un Concepto',
            'concepto_cod_concepto.size' =>'Debe Seleccionar un Concepto',
            'po_inicio.required' =>'Ingresar Periodo',
            'po_inicio.size' =>'Periodo invalido',
            'po_termino.required' =>'Ingresar Periodo',
            'po_termino.size' =>'Periodo invalido',
        ];

        $this->validate($request,$rules,$messages);

        //Fin validacion del formulario

        $ocasional= Pagoocasional::findOrFail($request->cod_pago_ocasional);
        $ocasional->po_monto = $request->po_monto;
        $ocasional->po_inicio = $request->po_inicio;
        $ocasional->po_termino = $request->po_termino;
        $ocasional->concepto_cod_concepto = $request->concepto_cod_concepto;
        $ocasional->save();
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $ocasional= Pagoocasional::find($request->cod_pago_ocasional);
        $ocasional->delete();
    }
}
