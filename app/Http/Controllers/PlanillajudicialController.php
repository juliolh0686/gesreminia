<?php

namespace App\Http\Controllers;

use App\Planilla;
use Illuminate\Http\Request;
use App\Planillajudicial;

use Barryvdh\DomPDF\Facade\Pdf;

class PlanillajudicialController extends Controller
{
    Public function RepJudicialPDF(Request $request){

        $cod_planilla= $request->cod_planilla;

        $planillajudicial= Planillajudicial::select('b_paterno', 'b_materno', 'b_nombres', 'b_numdoc', 'b_resjudicial', 'b_fechjudicial', 'b_fijo', 'b_porcentaje', 'b_cuenta', 'pj_monto', 'b_observacion')
        ->join('beneficiario', 'planilla_judicial.beneficiarios_cod_beneficiario', '=', 'beneficiario.cod_beneficiario')
        ->join('detalle_planilla','planilla_judicial.detalleplanillas_cod_detalle_planilla','=','detalle_planilla.cod_detalle_planilla')
        ->join('planilla','detalle_planilla.planilla_cod_planilla','=','planilla.cod_planilla')
        ->where('cod_planilla','=',$cod_planilla)
        ->get();

        
        $planilla= Planilla::where('cod_planilla','=',$cod_planilla)->first();


        $pdf = Pdf::loadView('pdf.rep_planillajudicial', compact('planillajudicial','planilla'));

        $pdf->setPaper('A4','landscape');

        return $pdf->stream('Planilla_Judicial.pdf');

    }
}
