<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Planilla;
use App\Personal;
use App\Contrato;
use App\Detalleplanilla;
use App\Ingreso;
use App\Planillaconceptos;
use App\Pagoocasional;
use App\Adminpension;
use App\Descuento;
use App\Beneficiario;
use App\Planillajudicial;
use App\Tipotrabajador;
use App\Variable;
use App\Sexo;
use App\Meta;
use App\Primaeps;
use Fpdf;
use Carbon\Carbon;
use App\Parametros;
use App\Uejecutora;

use Barryvdh\DomPDF\Facade\Pdf;
use Dflydev\DotAccessData\Data;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PlanillaController extends Controller
{
  public function index(Request $request)
  {
    if (!$request->ajax()) return redirect('/');

    $buscar= $request->buscar;
    $criterio = $request->criterio;

    if($buscar==''){
      $planilla= Planilla::join('planilla_estado','planilla.planilla_estado_cod_plla_estado','=','planilla_estado.cod_plla_estado')
        ->join('tipo_planilla','planilla.tipo_planilla_cod_tipo_planilla','tipo_planilla.cod_tipo_planilla')
        ->join('clase_planilla','planilla.clase_planilla_cod_clase_planilla','clase_planilla.cod_clase_planilla')
        ->orderBy('pll_periodo','desc')
        ->paginate(10);
    }
    else
    {
      $planilla=Planilla::join('planilla_estado','planilla.planilla_estado_cod_plla_estado','=','planilla_estado.cod_plla_estado')
        ->join('tipo_planilla','planilla.tipo_planilla_cod_tipo_planilla','tipo_planilla.cod_tipo_planilla')
        ->join('clase_planilla','planilla.clase_planilla_cod_clase_planilla','clase_planilla.cod_clase_planilla')
        ->where($criterio,'like','%'.$buscar.'%')
        ->orderBy('pll_periodo','desc')
        ->paginate(10);
    }


    return [
      'pagination' =>[
          'total'         => $planilla->total(),
          'current_page'  => $planilla->currentPage(),
          'per_page'      => $planilla->perpage(),
          'last_page'     => $planilla->lastPage(),
          'from'          => $planilla->firstItem(),
          'to'            => $planilla->lastItem(),
      ],
      'planilla' => $planilla
    ];
  }

    public function Planillascerradas(Request $request)
    {
       if (!$request->ajax()) return redirect('/');

            $claseplanilla= $request->claseplanilla;
            $tipoplanilla= $request->tipoplanilla;

            $planilla=Planilla::where('tipo_planilla_cod_tipo_planilla','=',$tipoplanilla)
                            ->where('clase_planilla_cod_clase_planilla','=',$claseplanilla)
                            ->orderBy('pll_periodo','desc')->get();

            return ['planilla' => $planilla];

    }


    public function store(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        $planilla= new Planilla();
        $planilla->tipo_planilla_cod_tipo_planilla = $request->tipo_planilla_cod_tipo_planilla;
        $planilla->clase_planilla_cod_clase_planilla = $request->clase_planilla_cod_clase_planilla;
        $planilla->pll_periodo = $request->pll_periodo;
        $planilla->pll_bruto = 0;
        $planilla->pll_desc = 0;
        $planilla->pll_liquido = 0;
        $planilla->pll_aport = 0;
        $planilla->pll_detalle = $request->pll_detalle;
        $planilla->planilla_estado_cod_plla_estado = '01';
        $planilla->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $planilla= Planilla::findOrFail($request->cod_planilla);
        $planilla->tipo_planilla_cod_tipo_planilla = $request->tipo_planilla_cod_tipo_planilla;
        $planilla->clase_planilla_cod_clase_planilla = $request->clase_planilla_cod_clase_planilla;
        $planilla->pll_periodo = $request->pll_periodo;
        $planilla->pll_detalle = $request->pll_detalle;
        $planilla->save();
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $planilla= Planilla::find($request->cod_planilla);
        $planilla->delete();
    }

    public function Procesarplanilla(Request $request)
    {
      //if (!$request->ajax()) return redirect('/');

      //--Capturar el codigo de la planilla--//
      $cod_planilla= $request->cod_planilla;

      //--Consultar datos de la planilla--//
      $planilla = Planilla::where('cod_planilla',$cod_planilla)->get()->first();

      //--Seleccionar todos los contratos de la Planilla Continua CAS--//
      if ($planilla->tipo_planilla_cod_tipo_planilla=='01' && $planilla->clase_planilla_cod_clase_planilla=='01' ){

        $contratos= Contrato::join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
          ->join('admin_pensiones', 'personal.admin_pension_cod_admin_pension', '=', 'admin_pensiones.cod_admin_pension')
          ->where('estado_personal_cod_estado_personal','!=','02')
          ->where('tipo_trabajador_cod_tipo_trabajador','=','01')
          ->where('tipo_planilla_cod_tipo_planilla','=','01')
          ->get();
      }

      //--Seleccionar todos los contratos de la Planilla Complementaria CAS--//
      if ($planilla->tipo_planilla_cod_tipo_planilla=='03' && $planilla->clase_planilla_cod_clase_planilla=='01' ){

        $contratos= Contrato::join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
          ->join('admin_pensiones', 'personal.admin_pension_cod_admin_pension', '=', 'admin_pensiones.cod_admin_pension')
          ->join('pago_ocasional','contratos.cod_contrato','pago_ocasional.contrato_cod_contrato')
          ->where('estado_personal_cod_estado_personal','!=','02')
          ->where('tipo_trabajador_cod_tipo_trabajador','=','01')
          ->where('tipo_planilla_cod_tipo_planilla','=','03')
          ->get();
      }

      //--Seleccionar todos los contratos de vacaciones truncas CAS--//
      if ($planilla->tipo_planilla_cod_tipo_planilla=='04' && $planilla->clase_planilla_cod_clase_planilla=='01' ){

        $contratos= Contrato::join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
          ->join('admin_pensiones', 'personal.admin_pension_cod_admin_pension', '=', 'admin_pensiones.cod_admin_pension')
          ->where('estado_personal_cod_estado_personal','!=','02')
          ->where('tipo_trabajador_cod_tipo_trabajador','=','01')
          ->where('tipo_planilla_cod_tipo_planilla','=','04')
          ->get();
      }

      //--Seleccionar todos los contratos de practicantes--//
      if ($planilla->tipo_planilla_cod_tipo_planilla=='01' && $planilla->clase_planilla_cod_clase_planilla=='02' ){

        $contratos= Contrato::join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
          ->join('admin_pensiones', 'personal.admin_pension_cod_admin_pension', '=', 'admin_pensiones.cod_admin_pension')
          ->where('estado_personal_cod_estado_personal','!=','02')
          ->where('tipo_trabajador_cod_tipo_trabajador','=','02')
          ->where('tipo_planilla_cod_tipo_planilla','=','01')
          ->get();
      }

      //--Hallar el 45% de la UIT--//
      $arrayUIT = Parametros::where('pm_id','=',1)->get()->first();
      $UIT = $arrayUIT->pm_monto;
      $UIT30PR = round(($UIT*45)/100,2);

      //--Consultar la RMV--//
      $arrayRMV = Parametros::where('pm_id','=',2)->get()->first();
      $RMV = $arrayRMV->pm_monto;

      //--Validar que la planilla se encuentra en estado 01 -> Aperturado--//
      if ($planilla->planilla_estado_cod_plla_estado == '01'){

        //Bucle para insertar contratos
        foreach($contratos as $itemscontratos){

          //CREA EL DETALLE DE LA PLANILLA
          $detalle_planilla = new Detalleplanilla();
          $detalle_planilla->planilla_cod_planilla = $cod_planilla;
          $detalle_planilla->contrato_cod_contrato = $itemscontratos->cod_contrato;
          $detalle_planilla->save();

          //CAPTURA EL CODIGO DEL DETALLE DE LA PLANILLA
          $cod_detalle_planilla = $detalle_planilla->cod_detalle_planilla;

          //SELECCIONAR INGRESOS
          //CONTINUA->CAS

          $finclasificador=$itemscontratos->clasificador_id;

          if ($planilla->tipo_planilla_cod_tipo_planilla=='01' && $planilla->clase_planilla_cod_clase_planilla=='01' ){

          $ingresos= Ingreso::join('conceptos', 'ingresos.concepto_cod_concepto', '=', 'conceptos.cod_concepto')
                      ->where('contrato_cod_contrato',$itemscontratos->cod_contrato)->get();

                  }

          //VACACIONES COMPLEMENTARIA->CAS
          if ($planilla->tipo_planilla_cod_tipo_planilla=='03' && $planilla->clase_planilla_cod_clase_planilla=='01' ){

              $ingresos= Ingreso::join('conceptos', 'ingresos.concepto_cod_concepto', '=', 'conceptos.cod_concepto')
                          ->where('contrato_cod_contrato',$itemscontratos->cod_contrato)
                          ->where('concepto_cod_concepto','0102')
                          ->get();

                      }

          //VACACIONES TRUNCAS->CAS
          if ($planilla->tipo_planilla_cod_tipo_planilla=='04' && $planilla->clase_planilla_cod_clase_planilla=='01' ){

              $ingresos= Ingreso::join('conceptos', 'ingresos.concepto_cod_concepto', '=', 'conceptos.cod_concepto')
                          ->where('contrato_cod_contrato',$itemscontratos->cod_contrato)
                          //->where('concepto_cod_concepto','0215')
                          ->whereIn('concepto_cod_concepto',['0215','1206'])
                          //->where(function($query){
                          //    $query->where('concepto_cod_concepto', '=', '0215');
                          //    $query->orWhere('concepto_cod_concepto', '=', '1206');
                          //})
                          //->orWhere('concepto_cod_concepto','1206')
                          ->get();

                      }

          //SELECCIONAR TODOS LOS CONTRATOS PRACTICANTES
          if ($planilla->tipo_planilla_cod_tipo_planilla=='01' && $planilla->clase_planilla_cod_clase_planilla=='02' ){



              $ingresos= Ingreso::join('conceptos', 'ingresos.concepto_cod_concepto', '=', 'conceptos.cod_concepto')
                          ->where('contrato_cod_contrato',$itemscontratos->cod_contrato)
                          ->get();
          }

          $ingreso = 0;
          $ocasional = 0;
          $ingreso_afecto = 0;
          $ocasional_afecto = 0;
          $aguinaldo = 0;
          $ingreso_desc_ley=0;
          $ingresos_total=0;
          $ingreso_calc_inas=0;
          $ingreso_lic_manual=0;
          $ingreso_maximo_afp = 11983.66;
          $ingreso_desc_ley_afp=0;

          //REGISTRAR INGRESOS
          foreach($ingresos as $itemsingreso){

                  //ingresos para el calculo de inasistencias y tardanzas y licencias
                  $ingreso_calc_inas=$ingreso_calc_inas+$itemsingreso->i_monto;

                  $monto_ingreso=round(($itemsingreso->i_monto/30)*$itemscontratos->c_dias_lab,2);

                  if ($monto_ingreso>0){

                  $ingreso= $ingreso + $monto_ingreso;

                  if ($itemsingreso->con_afecto==1){
                      $ingreso_afecto=$ingreso_afecto+$monto_ingreso;
                  }

                      $planilla_conceptos= new Planillaconceptos;
                      $planilla_conceptos->pll_id_monto = $monto_ingreso;
                      $planilla_conceptos->concepto_cod_concepto = $itemsingreso->concepto_cod_concepto;
                      $planilla_conceptos->clasificador_idclasificador = $finclasificador;///----MODIFICADO
                      $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
                      $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
                      $planilla_conceptos->save();
                  }
          }

          //Fin ingresos

          //Registrar Ocasionales

          if ($planilla->tipo_planilla_cod_tipo_planilla=='01' && $planilla->clase_planilla_cod_clase_planilla=='01' ){

          $Pagosocasionales= Pagoocasional::join('conceptos', 'pago_ocasional.concepto_cod_concepto', '=', 'conceptos.cod_concepto')
                          ->where('contrato_cod_contrato',$itemscontratos->cod_contrato)
                          ->where('concepto_cod_concepto','!=','0102')
                          ->where('concepto_cod_concepto','!=','0215')
                          ->get();
                      }

          //COMPLEMENTARIA->CAS
          if ($planilla->tipo_planilla_cod_tipo_planilla=='03' && $planilla->clase_planilla_cod_clase_planilla=='01' ){

              $Pagosocasionales= Pagoocasional::join('conceptos', 'pago_ocasional.concepto_cod_concepto', '=', 'conceptos.cod_concepto')
                              ->where('contrato_cod_contrato',$itemscontratos->cod_contrato)
                              ->whereIn('concepto_cod_concepto',['0102','0025'])
                              ->get();
                          }

          //VACACIONES TRUNCAS->CAS
          if ($planilla->tipo_planilla_cod_tipo_planilla=='04' && $planilla->clase_planilla_cod_clase_planilla=='01' ){

              $Pagosocasionales= Pagoocasional::join('conceptos', 'pago_ocasional.concepto_cod_concepto', '=', 'conceptos.cod_concepto')
                              ->where('contrato_cod_contrato',$itemscontratos->cod_contrato)
                              ->whereIn('concepto_cod_concepto',['0215','1206'])
                              ->get();

                      }

          //SELECCIONAR TODOS LOS CONTRATOS PRACTICANTES
          if ($planilla->tipo_planilla_cod_tipo_planilla=='01' && $planilla->clase_planilla_cod_clase_planilla=='02' ){

                $Pagosocasionales= Pagoocasional::join('conceptos', 'pago_ocasional.concepto_cod_concepto', '=', 'conceptos.cod_concepto')
                              ->where('contrato_cod_contrato',$itemscontratos->cod_contrato)
                              ->get();
          }

            foreach($Pagosocasionales as $itemsPagosocasionales){

              if (($itemsPagosocasionales->po_inicio <= $planilla->pll_periodo) && ($itemsPagosocasionales->po_termino >= $planilla->pll_periodo)){

                  $ocasional= $ocasional + $itemsPagosocasionales->po_monto;

                  if ($itemsPagosocasionales->con_afecto==1){
                      $ocasional_afecto=$ocasional_afecto+$itemsPagosocasionales->po_monto;
                  }

                  if($itemsPagosocasionales->concepto_cod_concepto=='0025'){
                      $clasificador_concepto=5;
                      $aguinaldo = $itemsPagosocasionales->po_monto;
                  } else{
                      $clasificador_concepto=$finclasificador;//MODIFICADO
                  }

                  $planilla_conceptos= new Planillaconceptos;
                  $planilla_conceptos->pll_id_monto = $itemsPagosocasionales->po_monto;
                  $planilla_conceptos->concepto_cod_concepto = $itemsPagosocasionales->concepto_cod_concepto;
                  $planilla_conceptos->clasificador_idclasificador = $clasificador_concepto;
                  $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
                  $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
                  $planilla_conceptos->save();

              }

          }

          $ingresos_total=$ingreso+$ocasional;

          //Fin Registrar Ocasionales

          //Registrar descuentos
          $descuentos = 0;
          $t_desc_lic_sg=0;
          $t_desc_lic_cg=0;
          $t_desc_dias=0;
          $t_tardanzas=0;
          $dias_desc_lic=0;

          //Descuento de Licencias

          if ($planilla->tipo_planilla_cod_tipo_planilla=='01' && $planilla->clase_planilla_cod_clase_planilla=='01'){

          //VERIFICAR QUE EL DESCUENTO SEA POR 30 DIAS
          if($itemscontratos->c_dias_lic>30){
              $dias_desc_lic=30;
          }else{
              $dias_desc_lic=$itemscontratos->c_dias_lic;
          }

          if ($itemscontratos->estado_personal_cod_estado_personal=='04'){

              $t_desc_lic_sg=round(($ingreso_calc_inas/30)*$dias_desc_lic,2);

              if ($t_desc_lic_sg<>0){

                  $planilla_conceptos= new Planillaconceptos;
                  $planilla_conceptos->pll_id_monto = $t_desc_lic_sg;
                  $planilla_conceptos->concepto_cod_concepto = '0109';
                  $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
                  $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
                  $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
                  $planilla_conceptos->save();

                  $descuentos= $descuentos + $t_desc_lic_sg;
              }
          }

          if ($itemscontratos->estado_personal_cod_estado_personal=='03'){

              if($ingreso_calc_inas>=$UIT30PR){

                  $t_desc_lic_cg=round(($UIT30PR/30)*$dias_desc_lic,2);

              }else
              {
                  $t_desc_lic_cg=round(($ingreso_calc_inas/30)*$dias_desc_lic,2);

              }

              if ($t_desc_lic_cg<>0){

                  $planilla_conceptos= new Planillaconceptos;
                  $planilla_conceptos->pll_id_monto = $t_desc_lic_cg;
                  $planilla_conceptos->concepto_cod_concepto = '0109';
                  $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
                  $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
                  $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
                  $planilla_conceptos->save();

                  $descuentos= $descuentos + $t_desc_lic_cg;
              }

          }

          //Fin de descuento de licencias

          //descuentos inasistenacias y tardanzas

              $t_desc_dias=round(($ingreso_calc_inas/30)*$itemscontratos->c_desc_dias,2);

              if ($t_desc_dias<>0){

                  $planilla_conceptos= new Planillaconceptos;
                  $planilla_conceptos->pll_id_monto = $t_desc_dias;
                  $planilla_conceptos->concepto_cod_concepto = '1145';
                  $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
                  $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
                  $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
                  $planilla_conceptos->save();

                  $descuentos= $descuentos + $t_desc_dias;
              }

              $t_desc_horas=round(($ingreso_calc_inas/240)*$itemscontratos->c_desc_horas,2);
              $t_desc_minutos=round(($ingreso_calc_inas/14400)*$itemscontratos->c_desc_min,2);

              $t_tardanzas=round($t_desc_horas+$t_desc_minutos,2);

              if ($t_tardanzas<>0){

                  $planilla_conceptos= new Planillaconceptos;
                  $planilla_conceptos->pll_id_monto = $t_tardanzas;
                  $planilla_conceptos->concepto_cod_concepto = '0054';
                  $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
                  $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
                  $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
                  $planilla_conceptos->save();

                  $descuentos= $descuentos + $t_tardanzas;
              }
          }
          //Fin descuentos inasistenacias y tardanzas

          //HALLAR DESCUENTO DE LICENCIA  MANUAL
          $descuentolicmanual= Descuento::where('contrato_cod_contrato',$itemscontratos->cod_contrato)
            ->where('concepto_cod_concepto','1205')->get();

              foreach($descuentolicmanual as $descuentolicmanuallist){

                  if (($descuentolicmanuallist->d_inicio <= $planilla->pll_periodo) && ($descuentolicmanuallist->d_termino >= $planilla->pll_periodo)){

                      $ingreso_lic_manual= $ingreso_lic_manual + $descuentolicmanuallist->d_monto;
                  }
              }

          //ingreso para descuento de ley

          $ingreso_desc_ley=round(($ingreso_afecto+$ocasional_afecto)-($t_desc_dias+$t_tardanzas+$t_desc_lic_sg+$t_desc_lic_cg+$ingreso_lic_manual),2);

          // // if ($itemscontratos->estado_personal_cod_estado_personal=='03'){

          // //     $ingreso_desc_ley=round(($ingreso_afecto+$ocasional_afecto) - $t_desc_lic_cg);

          // // }

          //hallar el sistema nacional de pensiones
              if ($itemscontratos->regimen_pension_cod_regimen_pension=='02'){

                  $afp = Adminpension::where('cod_admin_pension',$itemscontratos->admin_pension_cod_admin_pension)->get()->first();

                  $monto_snp=round(($ingreso_desc_ley*$afp->ap_aporte_fijo)/100,2);

                  if ($monto_snp<>0){

                  $planilla_conceptos= new Planillaconceptos;
                  $planilla_conceptos->pll_id_monto = $monto_snp;
                  $planilla_conceptos->concepto_cod_concepto = '0002';
                  $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
                  $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
                  $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
                  $planilla_conceptos->save();

                  $descuentos= $descuentos + $monto_snp;

                  }

                  }

          //Fin hallar el sistema nacional de pensiones

          //hallar el sistema privado de pensiones
          if ($itemscontratos->regimen_pension_cod_regimen_pension=='03'){

              $afp = Adminpension::where('cod_admin_pension',$itemscontratos->admin_pension_cod_admin_pension)->get()->first();

              if($ingreso_desc_ley>$ingreso_maximo_afp){
                $ingreso_desc_ley_afp = $ingreso_maximo_afp;
              }else {
                $ingreso_desc_ley_afp = $ingreso_desc_ley;
              }

              $spp_comision=round(($ingreso_desc_ley*$afp->ap_comision)/100,2);

              if ($spp_comision>0){
                  $planilla_conceptos= new Planillaconceptos;
                  $planilla_conceptos->pll_id_monto = $spp_comision;
                  $planilla_conceptos->concepto_cod_concepto = '1200';
                  $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
                  $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
                  $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
                  $planilla_conceptos->save();

                  $descuentos= $descuentos + $spp_comision;
              }

              //HALLAR FECHA DE NACIMIENTO
              $edad = Carbon::parse($itemscontratos->p_fech_nac)->age;

              if ($edad<65){

              $spp_prima=round(($ingreso_desc_ley_afp*$afp->ap_prima)/100,2);

              if ($spp_prima>0){
              $planilla_conceptos= new Planillaconceptos;
              $planilla_conceptos->pll_id_monto = $spp_prima;
              $planilla_conceptos->concepto_cod_concepto = '1201';
              $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
              $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
              $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
              $planilla_conceptos->save();

              $descuentos= $descuentos + $spp_prima;
              }


              }


              $spp_aporte=round(($ingreso_desc_ley*$afp->ap_aporte)/100,2);

              if ($spp_aporte>0){
              $planilla_conceptos= new Planillaconceptos;
              $planilla_conceptos->pll_id_monto = $spp_aporte;
              $planilla_conceptos->concepto_cod_concepto = '1202';
              $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
              $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
              $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
              $planilla_conceptos->save();

              $descuentos= $descuentos + $spp_aporte;
              }

              }
              //Fin hallar el sistema privado de pensiones

              //descuento de renta de cuarta categoria
              if ($itemscontratos->estado_personal_cod_estado_personal!='03'){

              if (($itemscontratos->sus_renta==0) && (($ingreso_desc_ley+$aguinaldo)>1500)){

              $renta4ta=round((($ingreso_desc_ley+$aguinaldo)*8)/100,2);

              $planilla_conceptos= new Planillaconceptos;
              $planilla_conceptos->pll_id_monto = $renta4ta;
              $planilla_conceptos->concepto_cod_concepto = '0006';
              $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
              $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
              $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
              $planilla_conceptos->save();

              $descuentos= $descuentos + $renta4ta;

              }

          }

              //fin descuento de renta de cuarta categoria

              //descuentos Judiciales

              $afecto_judicial=$ingresos_total-$descuentos;

              $judicial_total=0;

              $beneficiario= Beneficiario::where('contrato_cod_contrato',$itemscontratos->cod_contrato)
                              ->where('estado_idestado','01')->get();

              foreach($beneficiario as $beneficiario){

                      $monto_pjudicial=round(($afecto_judicial*$beneficiario->b_porcentaje)/100,2);

                      $monto_total_jud=round($monto_pjudicial+$beneficiario->b_fijo,2);

                      if($monto_total_jud > 0){

                      $planilla_judicial= new Planillajudicial;
                      $planilla_judicial->pj_monto = $monto_total_jud;
                      $planilla_judicial->beneficiarios_cod_beneficiario = $beneficiario->cod_beneficiario;
                      $planilla_judicial->detalleplanillas_cod_detalle_planilla= $cod_detalle_planilla;
                      $planilla_judicial->save();

                      $judicial_total= $judicial_total+ $monto_total_jud;

                      }

              }

              if($judicial_total > 0){

              $planilla_conceptos= new Planillaconceptos;
              $planilla_conceptos->pll_id_monto = $judicial_total;
              $planilla_conceptos->concepto_cod_concepto = '0004';
              $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
              $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
              $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
              $planilla_conceptos->save();

                $descuentos= $descuentos + $judicial_total;
              }

              //fin descuentos adicionales

              //descuentos adicionales

              // if ($planilla->tipo_planilla_cod_tipo_planilla=='01' && $planilla->clase_planilla_cod_clase_planilla=='01' ){

              $descuentoadics= Descuento::where('contrato_cod_contrato',$itemscontratos->cod_contrato)->get();

              foreach($descuentoadics as $descuentoadics){

                  if (($descuentoadics->d_inicio <= $planilla->pll_periodo) && ($descuentoadics->d_termino >= $planilla->pll_periodo)){

                      $planilla_conceptos= new Planillaconceptos;
                      $planilla_conceptos->pll_id_monto = $descuentoadics->d_monto;
                      $planilla_conceptos->concepto_cod_concepto = $descuentoadics->concepto_cod_concepto;
                      $planilla_conceptos->clasificador_idclasificador = $finclasificador;//MODIFICADO
                      $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
                      $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
                      $planilla_conceptos->save();

                      $descuentos= $descuentos + $descuentoadics->d_monto;
                  }
              }
              //}
              //fin descuentos adicionales

              $valoreps=0;

              //hallar monto liquido y cuota patronal
                  if($ingreso_desc_ley==0){
                      $cuotapatronal = 0;
                  }elseif ($ingreso_desc_ley>=$UIT30PR){
                      $cuotapatronal = round($UIT30PR*9/100,2);
                  } elseif ($ingreso_desc_ley<=$RMV) {
                      $cuotapatronal = round($RMV*9/100,2);
                  } else {
                      $cuotapatronal = round($ingreso_desc_ley*9/100,2);
                  }

                  if ($cuotapatronal<>0){

                      $planilla_conceptos= new Planillaconceptos;
                      $planilla_conceptos->pll_id_monto = $cuotapatronal;
                      $planilla_conceptos->concepto_cod_concepto = '1203';
                      $planilla_conceptos->clasificador_idclasificador = 3;
                      $planilla_conceptos->meta_m_cod_meta = $itemscontratos->meta_m_cod_meta;
                      $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $cod_detalle_planilla;
                      $planilla_conceptos->save();
                  }


              $liquido = round($ingresos_total - $descuentos,2);

              //actualizar tabla detalleplanilla

              $detalleplanilla= Detalleplanilla::findOrFail($cod_detalle_planilla);
              $detalleplanilla->dpll_dias_lab = $itemscontratos->c_dias_lab;
              $detalleplanilla->dpll_dias_lic = $itemscontratos->c_dias_lic;
              $detalleplanilla->dpll_desc_dias = $itemscontratos->c_desc_dias;
              $detalleplanilla->dpll__desc_horas = $itemscontratos->c_desc_horas;
              $detalleplanilla->dpll_desc_min = $itemscontratos->c_desc_min;
              $detalleplanilla->dpll_desc_perm = $itemscontratos->c_desc_perm;
              $detalleplanilla->dpll_observacion = $itemscontratos->c_observacion;
              $detalleplanilla->dpll_bruto = $ingresos_total;
              $detalleplanilla->dpll_base_calculo = $ingreso_desc_ley;
              $detalleplanilla->dpll_descuentos = $descuentos;
              $detalleplanilla->dpll_liquido = $liquido;
              $detalleplanilla->dpll_aport = $cuotapatronal+$valoreps;
              $detalleplanilla->save();



              //fin actualizar tabla detalleplanilla

          }


              //hallar el calculo de la EPS
              //LISTAR NUMERO DE AFILIADOS
              // $ctotalafiliados="SELECT comp_fam_cod_comp_fam FROM contratos WHERE aseguradora_cod_aseguradora<>3 AND (estado_personal_cod_estado_personal='01' OR estado_personal_cod_estado_personal='03')";
              // $resulttotalafiliados= DB::select($ctotalafiliados);


              //SACER RESULTADO DE TOTAL AFILIADOS

              $totalafiliados=0;

              $ctotalafiliados="SELECT SUM(afiliados_eps) AS total_afi FROM contratos WHERE estado_personal_cod_estado_personal='01' OR estado_personal_cod_estado_personal='03'";
              $ptotalafiliados= DB::select($ctotalafiliados);

              foreach ($ptotalafiliados as $pta) {
                  $totalafiliados = $pta->total_afi;
              }

              // foreach($resulttotalafiliados as $itemstotalafiliados){

              //     if($itemstotalafiliados->comp_fam_cod_comp_fam==2){
              //         $totalafiliados=$totalafiliados+1;
              //     }elseif($itemstotalafiliados->comp_fam_cod_comp_fam==3){
              //         $totalafiliados=$totalafiliados+2;
              //     }elseif($itemstotalafiliados->comp_fam_cod_comp_fam==4){
              //         $totalafiliados=$totalafiliados+3;
              //     }elseif($itemstotalafiliados->comp_fam_cod_comp_fam==5){
              //         $totalafiliados=$totalafiliados+4;
              //     }

              // }

              if ($totalafiliados<>0){


              //TOTAL ESSALUD AFECTO
              $totalessaludeps="select pll_id_monto from planilla_conceptos inner join detalle_planilla on planilla_conceptos.detalle_planilla_cod_detalle_planilla=detalle_planilla.cod_detalle_planilla
              inner join contratos on detalle_planilla.contrato_cod_contrato=contratos.cod_contrato where (estado_personal_cod_estado_personal='01' or estado_personal_cod_estado_personal='03')
              and aseguradora_cod_aseguradora=1 and concepto_cod_concepto='1203' and planilla_cod_planilla=".$cod_planilla;
              $resulttotalessaludeps= DB::select($totalessaludeps);

              $sumaessaludeps=0;

              foreach($resulttotalessaludeps as $itemsresulttotalessaludeps){

                  $sumaessaludeps=$sumaessaludeps+$itemsresulttotalessaludeps->pll_id_monto;

              }

              $porcentaje25=round($sumaessaludeps*25/100,2);

              $porcentajeafecto=round($porcentaje25/$totalafiliados,2);

              //MENSAJE PRUEBA
              //dd($porcentajeafecto);
              ///////////-------------------------------------------------------------------------------------------------------------------
              //$creditoinclIGV=round($porcentajeafecto*1.18,2);

              //LISTAR REGISTROS A ACTUALIZAR
              $registrosactualizarEPS="select * from planilla_conceptos inner join detalle_planilla on planilla_conceptos.detalle_planilla_cod_detalle_planilla=detalle_planilla.cod_detalle_planilla
              inner join contratos on detalle_planilla.contrato_cod_contrato=contratos.cod_contrato where (estado_personal_cod_estado_personal='01' or estado_personal_cod_estado_personal='03')
              and aseguradora_cod_aseguradora=1 and concepto_cod_concepto='1203' and planilla_cod_planilla=".$cod_planilla;
              $resultregistrosactualizarEPS= DB::select($registrosactualizarEPS);

              foreach($resultregistrosactualizarEPS as $itemsregistrosactualizar){

                  //if($itemsregistrosactualizar->comp_fam_cod_comp_fam==2){
                  $montocreditoessalud = round($porcentajeafecto,2);
                  //}elseif($itemsregistrosactualizar->comp_fam_cod_comp_fam==3){
                    //   $montocreditoessalud = round($creditoinclIGV*2,2);
                  //}elseif($itemsregistrosactualizar->comp_fam_cod_comp_fam==4){
                    //  $montocreditoessalud = round($creditoinclIGV*3,2);
                  //}elseif($itemsregistrosactualizar->comp_fam_cod_comp_fam==5){
                    //  $montocreditoessalud = round($creditoinclIGV*4,2);
                  //}

                  $montofinalessalud=round($itemsregistrosactualizar->pll_id_monto-($montocreditoessalud*$itemsregistrosactualizar->afiliados_eps),2);

                  //MONTO EPS
                  // $primaeps = Primaeps::where('aseguradora_cod_aseguradora','=',$itemsregistrosactualizar->aseguradora_cod_aseguradora)
                  //   ->where('plan_eps_cod_plan_eps','=',$itemsregistrosactualizar->plan_eps_cod_plan_eps)
                  //   ->where('comp_fam_cod_comp_fam','=',$itemsregistrosactualizar->comp_fam_cod_comp_fam)->get()->first();

                  $primaeps = $itemsregistrosactualizar->monto_eps;

                  $montodescuentoeps=round($primaeps-($montocreditoessalud*$itemsregistrosactualizar->afiliados_eps),2);

                  $planillaconceptos= Planillaconceptos::findOrFail($itemsregistrosactualizar->cod_planilla_conceptos);
                  $planillaconceptos->pll_id_monto = $montofinalessalud;
                  $planillaconceptos->save();

                  $planilla_conceptos= new Planillaconceptos;
                  $planilla_conceptos->pll_id_monto = round($montocreditoessalud*$itemsregistrosactualizar->afiliados_eps,2);
                  if ($itemsregistrosactualizar->aseguradora_cod_aseguradora==1){
                    $planilla_conceptos->concepto_cod_concepto = '1204';
                  }else {
                    $planilla_conceptos->concepto_cod_concepto = '1208';
                  }
                  $planilla_conceptos->clasificador_idclasificador = $itemsregistrosactualizar->clasificador_idclasificador;
                  $planilla_conceptos->meta_m_cod_meta = $itemsregistrosactualizar->meta_m_cod_meta;
                  $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $itemsregistrosactualizar->detalle_planilla_cod_detalle_planilla;
                  $planilla_conceptos->save();

                  $planilla_conceptos= new Planillaconceptos;
                  $planilla_conceptos->pll_id_monto = $montodescuentoeps;
                  if ($itemsregistrosactualizar->aseguradora_cod_aseguradora==1){
                    $planilla_conceptos->concepto_cod_concepto = '0010';
                  } else {
                    $planilla_conceptos->concepto_cod_concepto = '0011';
                  }
                  $planilla_conceptos->clasificador_idclasificador = $itemsregistrosactualizar->clasificador_id;//MODIFICADO
                  $planilla_conceptos->meta_m_cod_meta = $itemsregistrosactualizar->meta_m_cod_meta;
                  $planilla_conceptos->detalle_planilla_cod_detalle_planilla= $itemsregistrosactualizar->detalle_planilla_cod_detalle_planilla;
                  $planilla_conceptos->save();

                  //actualizar tabla detalleplanilla

                  $actualizardescuentos=$itemsregistrosactualizar->dpll_descuentos+$montodescuentoeps;

                  $actualizarliquido=$itemsregistrosactualizar->dpll_liquido-$montodescuentoeps;

                  $detalleplanilla= Detalleplanilla::findOrFail($itemsregistrosactualizar->detalle_planilla_cod_detalle_planilla);
                  $detalleplanilla->dpll_descuentos = $actualizardescuentos;
                  $detalleplanilla->dpll_liquido = $actualizarliquido;
                  $detalleplanilla->save();
              }

              }


              //reporte de totales de planilla generada
              $total_bruto = Planilla::join('detalle_planilla','planilla.cod_planilla', '=', 'detalle_planilla.planilla_cod_planilla')->select('Planilla.*', 'detalle_planilla*')->where('planilla_cod_planilla',$cod_planilla)->sum('dpll_bruto');

              $total_descuentos = Planilla::join('detalle_planilla','planilla.cod_planilla', '=', 'detalle_planilla.planilla_cod_planilla')->select('Planilla.*', 'detalle_planilla*')->where('planilla_cod_planilla',$cod_planilla)->sum('dpll_descuentos');

              $total_liquido = Planilla::join('detalle_planilla','planilla.cod_planilla', '=', 'detalle_planilla.planilla_cod_planilla')->select('Planilla.*', 'detalle_planilla*')->where('planilla_cod_planilla',$cod_planilla)->sum('dpll_liquido');

              $total_aportes = Planilla::join('detalle_planilla','planilla.cod_planilla', '=', 'detalle_planilla.planilla_cod_planilla')->select('Planilla.*', 'detalle_planilla*')->where('planilla_cod_planilla',$cod_planilla)->sum('dpll_aport');


              //actualizar datos de planilla

              $planilla= Planilla::findOrFail($cod_planilla);
              $planilla->pll_bruto = $total_bruto;
              $planilla->pll_desc = $total_descuentos;
              $planilla->pll_liquido = $total_liquido;
              $planilla->pll_aport = $total_aportes;
              $planilla->planilla_estado_cod_plla_estado = '02';
              $planilla->save();

      }

    }

    public function Cerrarplanilla(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cod_planilla= $request->cod_planilla;

        //actualizar datos de planilla

        $planilla= Planilla::findOrFail($cod_planilla);
        $planilla->planilla_estado_cod_plla_estado = '03';
        $planilla->save();
    }

    public function Limpiarplanilla(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cod_planilla= $request->cod_planilla;

        //Limpiar datos de planilla

        $detalleplanilla=Detalleplanilla::where('planilla_cod_planilla',$cod_planilla)->get();

        foreach($detalleplanilla as $registro){
            $ids[]=$registro->cod_detalle_planilla;
        }

        $eliminados = Detalleplanilla::destroy($ids);


        $planilla= Planilla::findOrFail($cod_planilla);
        $planilla->pll_bruto = 0;
        $planilla->pll_desc = 0;
        $planilla->pll_liquido = 0;
        $planilla->pll_aport = 0;
        $planilla->planilla_estado_cod_plla_estado = '01';
        $planilla->save();

    }


    Public function Generarboletas(Request $request){

        $cod_planilla= $request->cod_planilla;

        $boletas = Detalleplanilla::join('planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
                                    ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=', 'contratos.cod_contrato')
                                    ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
                                    ->join('sexo', 'personal.sexo_cod_sexo', '=', 'sexo.cod_sexo')
                                    ->join('estado_civil', 'personal.estado_civil_cod_estado_civil', '=', 'estado_civil.cod_estado_civil')
                                    ->join('admin_pensiones', 'personal.admin_pension_cod_admin_pension', '=', 'admin_pensiones.cod_admin_pension')
                                    ->join('areas', 'contratos.area_a_cod_area', '=', 'areas.a_cod_area')
                                    ->join('regimen_laboral', 'contratos.regimen_laboral_cod_regimen_laboral', '=', 'regimen_laboral.cod_regimen_laboral')
                                    ->join('tipo_trabajador', 'contratos.tipo_trabajador_cod_tipo_trabajador', '=', 'tipo_trabajador.cod_tipo_trabajador')
                                    ->join('cargos', 'contratos.cargo_cod_cargo', '=', 'cargos.cod_cargo')
                                    ->join('meta','contratos.meta_m_cod_meta', '=', 'meta.m_cod_meta')
                                    ->with('Planilla_Conceptos')
                                    ->where('planilla_cod_planilla', $cod_planilla)
                                    ->orderBy('p_a_paterno','asc')
                                    ->orderBy('p_a_materno','asc')
                                    ->get();

        $Uejecutoras = Uejecutora::first();

        $pdf = PDF::loadView('pdf.boletasv2', compact('boletas','Uejecutoras'));

        $pdf->setPaper('A4');

        return $pdf->stream('archivo.pdf');

    }

    Public function Generarboletasperiodo(Request $request){

        $p_num_doc= $request->p_num_doc;
        $p_inicial= $request->p_inicial;
        $p_final= $request->p_final;

        $boletas = Detalleplanilla::join('planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
                  ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=', 'contratos.cod_contrato')
                  ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
                  ->join('sexo', 'personal.sexo_cod_sexo', '=', 'sexo.cod_sexo')
                  ->join('estado_civil', 'personal.estado_civil_cod_estado_civil', '=', 'estado_civil.cod_estado_civil')
                  ->join('admin_pensiones', 'personal.admin_pension_cod_admin_pension', '=', 'admin_pensiones.cod_admin_pension')
                  ->join('areas', 'contratos.area_a_cod_area', '=', 'areas.a_cod_area')
                  ->join('regimen_laboral', 'contratos.regimen_laboral_cod_regimen_laboral', '=', 'regimen_laboral.cod_regimen_laboral')
                  ->join('tipo_trabajador', 'contratos.tipo_trabajador_cod_tipo_trabajador', '=', 'tipo_trabajador.cod_tipo_trabajador')
                  ->join('cargos', 'contratos.cargo_cod_cargo', '=', 'cargos.cod_cargo')
                  ->join('meta','contratos.meta_m_cod_meta', '=', 'meta.m_cod_meta')
                  ->with('Planilla_Conceptos')
                  ->where('p_num_doc', $p_num_doc)
                  ->where('pll_periodo','>=',$p_inicial)
                  ->where('pll_periodo','<=',$p_final)
                  ->orderBy('pll_periodo','asc')
                  ->get();

        $Uejecutoras = Uejecutora::first();

        $pdf = PDF::loadView('pdf.boletasv2', compact('boletas','Uejecutoras'));

        $pdf->setPaper('A4');

        return $pdf->stream('archivo.pdf');
    }

    Public function GenerarResumen(Request $request){

        $cod_planilla= $request->codplanilla;

        $sql="SELECT clasificador as CLASIFICADOR,meta AS META,IFNULL(SUM(CASE tipo_concepto_cod_tip_concepto WHEN 1 THEN pll_id_monto END),0)+IFNULL(SUM(CASE tipo_concepto_cod_tip_concepto WHEN 3 THEN pll_id_monto END),0) AS TOTAL_BRUTO,
        IFNULL(SUM(CASE tipo_concepto_cod_tip_concepto WHEN 2 THEN pll_id_monto END),0) DESCUENTOS,
        (IFNULL(SUM(CASE tipo_concepto_cod_tip_concepto WHEN 1 THEN pll_id_monto END),0)+IFNULL(SUM(CASE tipo_concepto_cod_tip_concepto WHEN 3 THEN pll_id_monto END),0)) - IFNULL(SUM(CASE tipo_concepto_cod_tip_concepto WHEN 2 THEN pll_id_monto END),0) as MONTO_LIQUIDO,
        IFNULL(SUM(CASE tipo_concepto_cod_tip_concepto WHEN 4 THEN pll_id_monto END),0) as APORTES
        FROM planilla_conceptos INNER JOIN detalle_planilla on planilla_conceptos.detalle_planilla_cod_detalle_planilla=detalle_planilla.cod_detalle_planilla
        INNER JOIN clasificador ON planilla_conceptos.clasificador_idclasificador=clasificador.idclasificador
        INNER JOIN meta ON planilla_conceptos.meta_m_cod_meta=meta.m_cod_meta
        INNER JOIN conceptos ON planilla_conceptos.concepto_cod_concepto=conceptos.cod_concepto
        WHERE planilla_cod_planilla=".$cod_planilla."
        GROUP BY clasificador,meta ORDER BY clasificador;";

        $dataresumen= DB::select($sql);

        $planillatotal= Planilla::where('cod_planilla','=',$cod_planilla)->first();

        $pdf = PDF::loadView('pdf.resumen', compact('dataresumen','planillatotal'));

        $pdf->setPaper('A4','landscape');

        return $pdf->stream('Resumen-'.$planillatotal->pll_periodo.'.pdf');

    }

    Public function PlanillaDescuentos(Request $request){

        $cod_planilla= $request->codplanilla;

        $sqlDetalle="SELECT con_nombre,clasificador,meta, sum(pll_id_monto) as monto FROM planilla_conceptos
          INNER JOIN detalle_planilla on planilla_conceptos.detalle_planilla_cod_detalle_planilla=detalle_planilla.cod_detalle_planilla
          INNER JOIN clasificador ON planilla_conceptos.clasificador_idclasificador=clasificador.idclasificador
          INNER JOIN meta ON planilla_conceptos.meta_m_cod_meta=meta.m_cod_meta
          INNER JOIN conceptos ON planilla_conceptos.concepto_cod_concepto=conceptos.cod_concepto
          WHERE planilla_cod_planilla=".$cod_planilla." AND tipo_concepto_cod_tip_concepto=2
          GROUP BY con_nombre,clasificador,meta";

        $sqlResumen = "SELECT con_nombre, sum(pll_id_monto) as monto FROM planilla_conceptos
          INNER JOIN detalle_planilla on planilla_conceptos.detalle_planilla_cod_detalle_planilla=detalle_planilla.cod_detalle_planilla
          INNER JOIN clasificador ON planilla_conceptos.clasificador_idclasificador=clasificador.idclasificador
          INNER JOIN meta ON planilla_conceptos.meta_m_cod_meta=meta.m_cod_meta
          INNER JOIN conceptos ON planilla_conceptos.concepto_cod_concepto=conceptos.cod_concepto
          WHERE planilla_cod_planilla=".$cod_planilla." AND tipo_concepto_cod_tip_concepto=2
          GROUP BY con_nombre";

        $dataDetalle= DB::select($sqlDetalle);
        $dataResumen= DB::select($sqlResumen);

        $planillatotal= Planilla::where('cod_planilla','=',$cod_planilla)->first();

        $pdf = PDF::loadView('pdf.pladescuentos', compact('dataDetalle','dataResumen','planillatotal'));

        $pdf->setPaper('A4','portrait');

        return $pdf->stream('PlanillaDescuentos-'.$planillatotal->pll_periodo.'.pdf');

    }

    Public function PlanillaAportes(Request $request){

      $cod_planilla= $request->codplanilla;

      $sqlDetalle="SELECT con_nombre,clasificador,meta, sum(pll_id_monto) as monto FROM planilla_conceptos
        INNER JOIN detalle_planilla on planilla_conceptos.detalle_planilla_cod_detalle_planilla=detalle_planilla.cod_detalle_planilla
        INNER JOIN clasificador ON planilla_conceptos.clasificador_idclasificador=clasificador.idclasificador
        INNER JOIN meta ON planilla_conceptos.meta_m_cod_meta=meta.m_cod_meta
        INNER JOIN conceptos ON planilla_conceptos.concepto_cod_concepto=conceptos.cod_concepto
        WHERE planilla_cod_planilla=".$cod_planilla." AND tipo_concepto_cod_tip_concepto=4
        GROUP BY con_nombre,clasificador,meta";

      $sqlResumen="SELECT con_nombre, sum(pll_id_monto) as monto FROM planilla_conceptos
        INNER JOIN detalle_planilla on planilla_conceptos.detalle_planilla_cod_detalle_planilla=detalle_planilla.cod_detalle_planilla
        INNER JOIN clasificador ON planilla_conceptos.clasificador_idclasificador=clasificador.idclasificador
        INNER JOIN meta ON planilla_conceptos.meta_m_cod_meta=meta.m_cod_meta
        INNER JOIN conceptos ON planilla_conceptos.concepto_cod_concepto=conceptos.cod_concepto
        WHERE planilla_cod_planilla=".$cod_planilla." AND tipo_concepto_cod_tip_concepto=4
        GROUP BY con_nombre";

      $dataDetalle= DB::select($sqlDetalle);
      $dataResumen= DB::select($sqlResumen);

      $planillatotal= Planilla::where('cod_planilla','=',$cod_planilla)->first();

      $pdf = PDF::loadView('pdf.plaaportes', compact('dataDetalle','dataResumen','planillatotal'));

      $pdf->setPaper('A4','portrait');

      return $pdf->stream('PlanillaAportes-'.$planillatotal->pll_periodo.'.pdf');

    }

    Public function PlanillaAfp(Request $request){

        $cod_planilla= $request->codplanilla;

        $sql="select det_resumen, sum(pll_id_monto) as monto from planilla_conceptos
            inner join conceptos on planilla_conceptos.concepto_cod_concepto=conceptos.cod_concepto
            inner join detalle_planilla on planilla_conceptos.detalle_planilla_cod_detalle_planilla=detalle_planilla.cod_detalle_planilla
            inner join contratos on detalle_planilla.contrato_cod_contrato=contratos.cod_contrato
            inner join planilla on detalle_planilla.planilla_cod_planilla=planilla.cod_planilla
            inner join personal on contratos.personal_cod_personal=personal.cod_personal
            inner join admin_pensiones on personal.admin_pension_cod_admin_pension=admin_pensiones.cod_admin_pension
            inner join meta on contratos.meta_m_cod_meta=meta.m_cod_meta
            inner join reg_pensiones on admin_pensiones.regimen_pension_cod_regimen_pension=reg_pensiones.cod_regimen_pension
            where planilla_cod_planilla=".$cod_planilla." and tipo_concepto_cod_tip_concepto=2 and regimen_pension_cod_regimen_pension='03' and (concepto_cod_concepto='1200' or concepto_cod_concepto='1201' or concepto_cod_concepto='1202')
            group by det_resumen";

        $dataafps= DB::select($sql);

        $planillatotal= Planilla::where('cod_planilla','=',$cod_planilla)->first();

        $pdf = PDF::loadView('pdf.plaafp', compact('dataafps','planillatotal'));

        $pdf->setPaper('A4','portrait');

        return $pdf->stream('PlanillaAFP'.$planillatotal->pll_periodo.'.pdf');

    }

    Public function PlanillaAfpresumen(Request $request){

        $cod_planilla= $request->codplanilla;

        $sql="select det_resumen,clasificador,meta, sum(pll_id_monto) as monto from planilla_conceptos
          inner join conceptos on planilla_conceptos.concepto_cod_concepto=conceptos.cod_concepto
          inner join detalle_planilla on planilla_conceptos.detalle_planilla_cod_detalle_planilla=detalle_planilla.cod_detalle_planilla
          inner join contratos on detalle_planilla.contrato_cod_contrato=contratos.cod_contrato
          inner join planilla on detalle_planilla.planilla_cod_planilla=planilla.cod_planilla
          inner join personal on contratos.personal_cod_personal=personal.cod_personal
          inner join admin_pensiones on personal.admin_pension_cod_admin_pension=admin_pensiones.cod_admin_pension
          inner join meta on contratos.meta_m_cod_meta=meta.m_cod_meta
          inner join clasificador on planilla_conceptos.clasificador_idclasificador=clasificador.idclasificador
          inner join reg_pensiones on admin_pensiones.regimen_pension_cod_regimen_pension=reg_pensiones.cod_regimen_pension
          where planilla_cod_planilla=".$cod_planilla." and tipo_concepto_cod_tip_concepto=2 and regimen_pension_cod_regimen_pension='03' and (concepto_cod_concepto='1200' or concepto_cod_concepto='1201' or concepto_cod_concepto='1202')
          group by det_resumen,clasificador,meta";

        $dataafpresumen= DB::select($sql);

        $planillatotal= Planilla::where('cod_planilla','=',$cod_planilla)->first();

        $pdf = PDF::loadView('pdf.plaafpresumen', compact('dataafpresumen','planillatotal'));

        $pdf->setPaper('A4','portrait');

        return $pdf->stream('PlanillaAFPresumen'.$planillatotal->pll_periodo.'.pdf');

    }

    Public function GenerarInterface(Request $request){

        $codplanilla= $request->codplanilla;
        $tipointer= $request->tipointer;

        switch ($tipointer) {
            case 1:

                    //Registros Personal
                    $personal= Personal::whereMonth('created_at','=',date("m"))->whereYear('created_at', date("Y"))->get();

                    $fi=fopen("interface/DP000062.txt", "w") or die("problemas al crear el archivo");

                    foreach ($personal as $personal) {

                        $sexo=substr($personal->sexo_cod_sexo,1,1);
                        $fecha_nac = date('d/m/Y', strtotime($personal->p_fech_nac));

                        fwrite($fi,$personal->tipo_documento_cod_tipo_documento.";".$personal->p_num_doc.";".$personal->p_a_paterno.";".$personal->p_a_materno.";".$personal->p_nombres.";".$sexo.";".$fecha_nac.";;;N".PHP_EOL);

                    }

                    fclose($fi);

                $ruta="interface/DP000062.txt";
                header ("Content-Disposition: attachment; filename=DP000062.txt");
                header ("Content-Type: application/octet-stream");
                header ("Content-Length: ".filesize($ruta));
                readfile($ruta);

                break;

            case 2:
                echo "i es igual a 2";
                break;
            case 3:

                //Registros Personal
                $personal= Personal::whereMonth('created_at','=',date("m"))->whereYear('created_at', date("Y"))->get();

                $fi=fopen("interface/DB000062.txt", "w") or die("problemas al crear el archivo");

                foreach ($personal as $personal) {

                    fwrite($fi,$personal->tipo_documento_cod_tipo_documento.";".$personal->p_num_doc.";00000000000000000000;".$personal->banco_cod_banco.";".$personal->p_num_cuenta.PHP_EOL);

                }

                fclose($fi);

                 $ruta="interface/DB000062.txt";
                 header ("Content-Disposition: attachment; filename=DB000062.txt");
                 header ("Content-Type: application/octet-stream");
                 header ("Content-Length: ".filesize($ruta));
                 readfile($ruta);

                 break;

            case 4:

                //totales de la planilla
                $planillatotales= Planilla::where('cod_planilla', $codplanilla)->first();

                $periodo=$planillatotales->pll_periodo;

                $anio=substr($periodo,0, 4);
                $mes=substr($periodo,4, 2);



                //Registros de detalle planilla
                $planilla= Planilla::join('detalle_planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
                                        ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=','contratos.cod_contrato')
                                        ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
                                        ->where('planilla_cod_planilla', $codplanilla)
                                        ->get();



                $fi=fopen("interface/PLL000062".$periodo."01030001.txt", "w") or die("problemas al crear el archivo");

                fwrite($fi,"000062;".$anio.";".$mes.";01;03;0001;;".$planillatotales->pll_bruto.";".$planillatotales->pll_desc.";0.00;0.00;0.00;0.00".PHP_EOL);

                foreach ($planilla as $planilla) {

                    $monto_afp=0;

                    $interface=Planillaconceptos::join('conceptos', 'planilla_conceptos.concepto_cod_concepto', '=','conceptos.cod_concepto')
                    ->where('detalle_planilla_cod_detalle_planilla','=',$planilla->cod_detalle_planilla)
                    ->where('tipo_concepto_cod_tip_concepto','<>','4')
                    ->orderBy('concepto_cod_concepto','asc')
                    ->get();

                    foreach ($interface as $interface){

                        if ($interface->concepto_cod_concepto=='1200' OR $interface->concepto_cod_concepto == '1201'OR $interface->concepto_cod_concepto == '1202'){

                            $monto_afp=round($monto_afp+$interface->pll_id_monto,2);

                        }else{
                            $tip_concepto=$interface->tipo_concepto_cod_tip_concepto;

                            if($tip_concepto == 3){
                                $tip_concepto=4;
                            }

                            if($interface->concepto_cod_concepto=='0025'){
                                $tip_concepto=1;
                            }

                            fwrite($fi,$planilla->tipo_documento_cod_tipo_documento.";".$planilla->p_num_doc.";00;".$tip_concepto.";".$interface->concepto_cod_concepto.";".$interface->con_abrev.";".$interface->pll_id_monto.PHP_EOL);
                        }
                    }
                        if($monto_afp<>0){
                            fwrite($fi,$planilla->tipo_documento_cod_tipo_documento.";".$planilla->p_num_doc.";00;2;0113;AFP;".$monto_afp.PHP_EOL);
                        }

                        fwrite($fi,$planilla->tipo_documento_cod_tipo_documento.";".$planilla->p_num_doc.";00;9;9999;;".$planilla->dpll_liquido.PHP_EOL);

                }

                fclose($fi);

            $ruta="interface/PLL000062".$periodo."01030001.txt";
            header ("Content-Disposition: attachment; filename=PLL000062".$periodo."01030001.txt");
            header ("Content-Type: application/octet-stream");
            header ("Content-Length: ".filesize($ruta));
            readfile($ruta);

            break;
        }

    }

    Public function GenerarInterfacemcppweb(Request $request){

        $codplanilla= $request->codplanilla;
        $tipointer= $request->tipointer;

        //DATA REMUNERACION LIQUIDO
        $sqlDataremuneracion = "select sum(dpll_bruto) as bruto, sum(dpll_descuentos) descuentos, sum(dpll_aport) as aportes from detalle_planilla where planilla_cod_planilla=".$codplanilla." and dpll_liquido > 0.00";

        $planillatotales = DB::select($sqlDataremuneracion);

        $primerResultado = $planillatotales[0];
        $bruto = $primerResultado->bruto;
        $descuentos = $primerResultado->descuentos;
        $aportes = $primerResultado->aportes;

        $planillaperiodo= Planilla::where('cod_planilla', $codplanilla)->first();

        $periodo=$planillaperiodo->pll_periodo;

        $anio=substr($periodo,0, 4);
        $mes=substr($periodo,4, 2);

        //Registros de detalle planilla
        $planilla= Planilla::join('detalle_planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
          ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=','contratos.cod_contrato')
          ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
          ->join('tipo_registro_airhsp','contratos.tipo_registro_airhsp_tra_id','=','tipo_registro_airhsp.tra_id')
          ->join('tipo_documento','personal.tipo_documento_cod_tipo_documento','=','tipo_documento.cod_tipo_documento')
          ->where('planilla_cod_planilla', $codplanilla)
          ->get();

          $num_registro=Planillaconceptos::select('cod_detalle_planilla')
            ->join('detalle_planilla', 'planilla_conceptos.detalle_planilla_cod_detalle_planilla', '=','detalle_planilla.cod_detalle_planilla')
            ->where('planilla_cod_planilla','=',$codplanilla)
            ->where('dpll_liquido','>',0)
            ->get()
            ->count();

        $fi=fopen("interface/PLL000062".$periodo."01030001.txt", "w") or die("problemas al crear el archivo");

        fwrite($fi,"000062|".$anio."|".$mes."|01|03|0001|".$num_registro."|".$bruto."|".$descuentos."|".$aportes.PHP_EOL);

        foreach ($planilla as $planilla) {

            if($planilla->dpll_liquido > 0){

                $interface=Planillaconceptos::join('conceptos', 'planilla_conceptos.concepto_cod_concepto', '=','conceptos.cod_concepto')
                    ->join('concepto_airhsp','conceptos.concepto_airhsp_ca_id','=','concepto_airhsp.ca_id')
                    ->where('detalle_planilla_cod_detalle_planilla','=',$planilla->cod_detalle_planilla)
                    ->orderBy('concepto_cod_concepto','asc')
                    ->get();

                foreach ($interface as $interface){

                    fwrite($fi,$planilla->td_documento_airhsp."|".$planilla->p_num_doc."|00|".$interface->tipo_concepto_airhsp_tca_id."|".$interface->ca_cod_concepto."|".$interface->con_abrev."|".$interface->pll_id_monto."|".$planilla->tra_id."|".$planilla->c_cod_reg_airhsp.PHP_EOL);

                }

            }


        }

        fclose($fi);

    $ruta="interface/PLL000062".$periodo."01030001.txt";
    header ("Content-Disposition: attachment; filename=PLL000062".$periodo."01030001.txt");
    header ("Content-Type: application/octet-stream");
    header ("Content-Length: ".filesize($ruta));
    readfile($ruta);


    }

    Public function GenerarArchivoPDT(Request $request){

        $tipointer=$request->tipointer;
        $cod_planilla= $request->cod_planilla;

        //totales de la planilla
        $planillatotales= Planilla::where('cod_planilla', $cod_planilla)->first();

        $periodo=$planillatotales->pll_periodo;

        switch ($tipointer) {
            case 1:

                $anio=substr($periodo,0, 4);
                $mes=substr($periodo,4, 2);

                //totales de la planilla
                $planillatotales= Planilla::where('cod_planilla','=',$cod_planilla)->first();

                //Registros de detalle planilla
                $planilla= Planilla::join('detalle_planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
                                        ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=','contratos.cod_contrato')
                                        ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
                                        ->where('cod_planilla','=',$cod_planilla)
                                        ->get();



                $fi=fopen("interface/0601".$periodo."20334929281.rem", "w") or die("problemas al crear el archivo");


                foreach ($planilla as $planilla) {

                    $monto_afp=0;

                    $interface=Planillaconceptos::join('conceptos', 'planilla_conceptos.concepto_cod_concepto', '=','conceptos.cod_concepto')
                    ->where('detalle_planilla_cod_detalle_planilla','=',$planilla->cod_detalle_planilla)
                    ->where('tipo_concepto_cod_tip_concepto','!=','4')
                    ->orderBy('concepto_cod_concepto','asc')
                    ->get();

                    fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|2039|".$planilla->dpll_base_calculo."|".$planilla->dpll_base_calculo."|".PHP_EOL);

                    $cuarta_verif=0;

                    foreach ($interface as $interface){

                        switch ($interface->concepto_cod_concepto) {
                            case '0025':
                            fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|2044|".$interface->pll_id_monto."|".$interface->pll_id_monto."|".PHP_EOL);
                            break;
                            case '1202':
                            fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|608|".$interface->pll_id_monto."|".$interface->pll_id_monto."|".PHP_EOL);
                            break;
                            case '1200':
                            fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|601|".$interface->pll_id_monto."|".$interface->pll_id_monto."|".PHP_EOL);
                            break;
                            case '1201':
                            fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|606|".$interface->pll_id_monto."|".$interface->pll_id_monto."|".PHP_EOL);
                            break;
                            case '0006':
                            fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|618|".$interface->pll_id_monto."|".$interface->pll_id_monto."|".PHP_EOL);
                            $cuarta_verif=$interface->pll_id_monto;
                            break;
                        }

                    }

                    if ($cuarta_verif==0){
                        fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|618|0.00|0.00|".PHP_EOL);
                    }

                }

                fclose($fi);

                $ruta="interface/0601".$periodo."20334929281.rem";
                header ("Content-Disposition: attachment; filename=0601".$periodo."20334929281.rem");
                header ("Content-Type: application/octet-stream");
                header ("Content-Length: ".filesize($ruta));
                readfile($ruta);

                break;

            case 2:

                $anio=substr($periodo,0, 4);
                $mes=substr($periodo,4, 2);

                //totales de la planilla
                $planillatotales= Planilla::where('cod_planilla','=',$cod_planilla)->first();

                //Registros de detalle planilla
                $planilla= Planilla::join('detalle_planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
                                        ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=','contratos.cod_contrato')
                                        ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
                                        ->where('cod_planilla','=',$cod_planilla)
                                        ->get();



                $fi=fopen("interface/0601".$periodo."20334929281.jor", "w") or die("problemas al crear el archivo");


                foreach ($planilla as $planilla) {

                    fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|160|0|0|0|".PHP_EOL);

                }

                fclose($fi);

                $ruta="interface/0601".$periodo."20334929281.jor";
                header ("Content-Disposition: attachment; filename=0601".$periodo."20334929281.jor");
                header ("Content-Type: application/octet-stream");
                header ("Content-Length: ".filesize($ruta));
                readfile($ruta);
                break;
        }

    }

    public function GenerarArchivoAFPNet(Request $request)
    {
        $cod_planilla= $request->cod_planilla;

        //totales de la planilla
        $planillatotales= Planilla::where('cod_planilla', $cod_planilla)->first();

        $periodo=$planillatotales->pll_periodo;

        $spreadsheet = new Spreadsheet();

        $datosplanilla=Detalleplanilla::join('planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
                                    ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=', 'contratos.cod_contrato')
                                    ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
                                    ->join('admin_pensiones', 'personal.admin_pension_cod_admin_pension', '=', 'admin_pensiones.cod_admin_pension')
                                    ->where('cod_planilla', $cod_planilla)
                                    ->where('regimen_pension_cod_regimen_pension', '03')
                                    ->get();

        $numeracion = 1;
        $data=[];

        foreach ($datosplanilla as $datosplanilla){

            if($datosplanilla->dpll_base_calculo>0){

                    $row = [];
                    $row[0] = $numeracion;
                    $row[1] = $datosplanilla->p_cuspp;
                    $row[2] = '0';
                    $row[3] = $datosplanilla->p_num_doc;
                    $row[4] = $datosplanilla->p_a_paterno;
                    $row[5] = $datosplanilla->p_a_materno;
                    $row[6] = $datosplanilla->p_nombres;
                    $row[7] = 'S';

                    $contrato_ini=substr($datosplanilla->c_fech_ini,0,4).substr($datosplanilla->c_fech_ini,5,2);

                    if ($contrato_ini==$periodo){
                    $row[8] = 'S';
                    }else{
                    $row[8] = 'N';
                    }

                    $contrato_ter=substr($datosplanilla->c_fech_ter,0,4).substr($datosplanilla->c_fech_ter,5,2);

                    if ($contrato_ter==$periodo){
                    $row[9] = 'S';
                    }else{
                    $row[9] = 'N';
                    }

                    $row[10] = '';
                    $row[11] = $datosplanilla->dpll_base_calculo;
                    $row[12] = '0';
                    $row[13] = '0';
                    $row[14] = '0';
                    $row[15] = 'N';
                    $row[16] = '';
                    $data[]=$row;
                    $numeracion += 1;
                }

            $arrayData = $data;

        }

        $spreadsheet->getActiveSheet()
            ->fromArray($arrayData,NULL,'A1');

        // Aquí
        $filename = 'AFPNet-'.$periodo.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $objWriter->save('php://output');

    }

    Public function PagosContrato(Request $request){

        $cod_contrato=$request->cod_contrato;

        $pagoscontrato = Detalleplanilla::join('planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
                                    ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=', 'contratos.cod_contrato')
                                    ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
                                    ->join('sexo', 'personal.sexo_cod_sexo', '=', 'sexo.cod_sexo')
                                    ->with('Planilla_Conceptos')
                                    ->where('contrato_cod_contrato', $cod_contrato)
                                    ->orderBy('pll_periodo', 'DESC')
                                    ->get();


         return ['pagoscontrato' => $pagoscontrato];
    }

    Public function GenerarArchivoPDTexcel(Request $request){

        $tipointer=$request->tipointer;
        $cod_planilla= $request->cod_planilla;

        //totales de la planilla
        $planillatotales= Planilla::where('cod_planilla', $cod_planilla)->first();

        $periodo=$planillatotales->pll_periodo;

        switch ($tipointer) {
            case 1:

                $anio=substr($periodo,0, 4);
                $mes=substr($periodo,4, 2);

                //totales de la planilla
                $planillatotales= Planilla::where('cod_planilla','=',$cod_planilla)->first();

                $spreadsheet = new Spreadsheet();

                //Registros de detalle planilla
                $planilla= Planilla::join('detalle_planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
                                        ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=','contratos.cod_contrato')
                                        ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
                                        ->where('cod_planilla','=',$cod_planilla)
                                        ->get();

                $data=[];

                //$fi=fopen("interface/0601".$periodo."20334929281.rem", "w") or die("problemas al crear el archivo");

                foreach ($planilla as $planilla) {

                    $monto_afp=0;

                    $interface=Planillaconceptos::join('conceptos', 'planilla_conceptos.concepto_cod_concepto', '=','conceptos.cod_concepto')
                    ->where('detalle_planilla_cod_detalle_planilla','=',$planilla->cod_detalle_planilla)
                    ->where('tipo_concepto_cod_tip_concepto','!=','4')
                    ->orderBy('concepto_cod_concepto','asc')
                    ->get();

                    $row = [];

                    $row[0] = $planilla->tipo_documento_cod_tipo_documento;
                    $row[1] = $planilla->p_num_doc;
                    $row[2] = $planilla->p_a_paterno;
                    $row[3] = $planilla->p_a_materno;
                    $row[4] = $planilla->p_nombres;
                    $row[5] = $planilla->p_fech_nac;

                    $row[6] = '2039';
                    $row[7] = $planilla->dpll_base_calculo;
                    $row[8] = $planilla->dpll_base_calculo;
                    $data[]=$row;

                    $arrayData = $data;


                    //fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|2039|".$planilla->dpll_base_calculo."|".$planilla->dpll_base_calculo."|".PHP_EOL);

                    $cuarta_verif=0;

                    // foreach ($interface as $interface){

                    //     switch ($interface->concepto_cod_concepto) {
                    //         case '0025':
                    //         fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|2044|".$interface->pll_id_monto."|".$interface->pll_id_monto."|".PHP_EOL);
                    //         break;
                    //         case '1202':
                    //         fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|608|".$interface->pll_id_monto."|".$interface->pll_id_monto."|".PHP_EOL);
                    //         break;
                    //         case '1200':
                    //         fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|601|".$interface->pll_id_monto."|".$interface->pll_id_monto."|".PHP_EOL);
                    //         break;
                    //         case '1201':
                    //         fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|606|".$interface->pll_id_monto."|".$interface->pll_id_monto."|".PHP_EOL);
                    //         break;
                    //         case '0006':
                    //         fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|618|".$interface->pll_id_monto."|".$interface->pll_id_monto."|".PHP_EOL);
                    //         $cuarta_verif=$interface->pll_id_monto;
                    //         break;
                    //     }

                    // }

                    // if ($cuarta_verif==0){
                    //     fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|618|0.00|0.00|".PHP_EOL);
                    // }

                }

                //fclose($fi);

        $spreadsheet->getActiveSheet()->fromArray($arrayData,NULL,'A1');

        // Aquí
        $filename = 'AFPNet-'.$periodo.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $objWriter->save('php://output');

                // $ruta="interface/0601".$periodo."20334929281.rem";
                // header ("Content-Disposition: attachment; filename=0601".$periodo."20334929281.rem");
                // header ("Content-Type: application/octet-stream");
                // header ("Content-Length: ".filesize($ruta));
                // readfile($ruta);

                break;

            case 2:

                $anio=substr($periodo,0, 4);
                $mes=substr($periodo,4, 2);

                //totales de la planilla
                $planillatotales= Planilla::where('cod_planilla','=',$cod_planilla)->first();

                //Registros de detalle planilla
                $planilla= Planilla::join('detalle_planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
                                        ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=','contratos.cod_contrato')
                                        ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
                                        ->where('cod_planilla','=',$cod_planilla)
                                        ->get();



                $fi=fopen("interface/0601".$periodo."20334929281.jor", "w") or die("problemas al crear el archivo");


                foreach ($planilla as $planilla) {

                    fwrite($fi,$planilla->tipo_documento_cod_tipo_documento."|".$planilla->p_num_doc."|160|0|0|0|".PHP_EOL);

                }

                fclose($fi);

                $ruta="interface/0601".$periodo."20334929281.jor";
                header ("Content-Disposition: attachment; filename=0601".$periodo."20334929281.jor");
                header ("Content-Type: application/octet-stream");
                header ("Content-Length: ".filesize($ruta));
                readfile($ruta);
                break;
        }

    }



}
