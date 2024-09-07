<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {

        $anio=date('Y');
        $ingresos=DB::table('planilla as p')
        ->select(DB::raw('SUBSTRING(p.pll_periodo,5,2) as mes'),
        DB::raw('SUBSTRING(p.pll_periodo,1,4) as anio'),
        'p.pll_bruto as bruto','p.pll_desc as desc','p.pll_liquido as liq')
        ->where(DB::raw('SUBSTRING(p.pll_periodo,1,4)'),$anio)
        ->where('tipo_planilla_cod_tipo_planilla','01')
        ->get();

        $totales=DB::table('planilla as p')
        ->select(DB::raw('SUM(pll_bruto) as tbruto'),
        DB::raw('SUM(pll_desc) as tdesc'),
        DB::raw('SUM(pll_liquido) as tliq'))
        ->where(DB::raw('SUBSTRING(p.pll_periodo,1,4)'),$anio)
        ->first();

        $tpersonal=DB::table('personal')
        ->select(DB::raw('COUNT(cod_personal) as numpersonal'))
        ->first();

        $tplanillas=DB::table('planilla')
        ->select(DB::raw('COUNT(cod_planilla) as numplanillas'))
        ->first();

        $tcontratos=DB::table('contratos')
        ->select(DB::raw('COUNT(cod_contrato) as numcontratos'))
        ->first();

        $tbeneficiarios=DB::table('beneficiario')
        ->select(DB::raw('COUNT(cod_beneficiario) as numbeneficiarios'))
        ->first();

        return ['ingresos'=>$ingresos,'anio'=>$anio,'totales'=>$totales,'tpersonal'=>$tpersonal,
                'tplanillas'=>$tplanillas,'tcontratos'=>$tcontratos,'tbeneficiarios'=>$tbeneficiarios];

    }
}
