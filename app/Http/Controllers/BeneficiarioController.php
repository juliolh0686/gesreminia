<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Beneficiario;

class BeneficiarioController extends Controller
{
    public function listBeneficiarios(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $cod_contrato=$request->cod_contrato;
 
         $beneficiario = Beneficiario::where('contrato_cod_contrato','=',$cod_contrato)
         ->orderBy('b_fechjudicial','asc')->get();
         return ['beneficiario'=>$beneficiario];
     }

     public function store(Request $request){

        if (!$request->ajax()) return redirect('/');

        //Validacion del Formulario

        $rules = [
            'b_paterno'=>'required',
        ];

        $messages = [
            'b_paterno.required' => 'Ingresar Apellido Paterno',
        ];

        $this->validate($request,$rules,$messages);

        //Fin validacion del formulario

        $fechjudicial = date('Y-m-d', strtotime($request->b_fechjudicial));

        $beneficiario= new Beneficiario();
        $beneficiario->b_paterno = $request->b_paterno;
        $beneficiario->b_materno = $request->b_materno;
        $beneficiario->b_nombres = $request->b_nombres;
        $beneficiario->tipo_documento_cod_tipo_documento = $request->tipo_documento_cod_tipo_documento;
        $beneficiario->b_numdoc = $request->b_numdoc;
        $beneficiario->b_resjudicial = $request->b_resjudicial;
        $beneficiario->b_fechjudicial = $fechjudicial;
        $beneficiario->b_fijo = $request->b_fijo;
        $beneficiario->b_porcentaje = $request->b_porcentaje;
        $beneficiario->tipo_pago_cod_tipo_pago = $request->tipo_pago_cod_tipo_pago;
        $beneficiario->banco_cod_banco = $request->banco_cod_banco;
        $beneficiario->b_cuenta = $request->b_cuenta;
        $beneficiario->b_observacion = $request->b_observacion;
        $beneficiario->contrato_cod_contrato = $request->contrato_cod_contrato;
        $beneficiario->estado_idestado = '01';
        $beneficiario->save();
    }

    public function update(Request $request){

        if (!$request->ajax()) return redirect('/');

        //Validacion del Formulario

        $rules = [
            'b_paterno'=>'required',
        ];

        $messages = [
            'b_paterno.required' => 'Ingresar Apellido Paterno',
        ];

        $this->validate($request,$rules,$messages);

        //Fin validacion del formulario

        $fechjudicial = date('Y-m-d', strtotime($request->b_fechjudicial));

        $beneficiario= Beneficiario::findOrFail($request->cod_beneficiario);
        $beneficiario->b_paterno = $request->b_paterno;
        $beneficiario->b_materno = $request->b_materno;
        $beneficiario->b_nombres = $request->b_nombres;
        $beneficiario->tipo_documento_cod_tipo_documento = $request->tipo_documento_cod_tipo_documento;
        $beneficiario->b_numdoc = $request->b_numdoc;
        $beneficiario->b_resjudicial = $request->b_resjudicial;
        $beneficiario->b_fechjudicial = $fechjudicial;
        $beneficiario->b_fijo = $request->b_fijo;
        $beneficiario->b_porcentaje = $request->b_porcentaje;
        $beneficiario->tipo_pago_cod_tipo_pago = $request->tipo_pago_cod_tipo_pago;
        $beneficiario->banco_cod_banco = $request->banco_cod_banco;
        $beneficiario->b_cuenta = $request->b_cuenta;
        $beneficiario->b_observacion = $request->b_observacion;
        $beneficiario->contrato_cod_contrato = $request->contrato_cod_contrato;
        $beneficiario->estado_idestado = $request->estado_idestado;
        $beneficiario->save();
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $beneficiario= Beneficiario::find($request->cod_beneficiario);
        $beneficiario->delete();
    }
}
