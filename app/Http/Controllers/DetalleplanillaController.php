<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Detalleplanilla;
use App\Planilla;
use App\Concepto;
use App\Planillaconceptos;
use App\Estacion;
use App\Meta;
use App\Clasificador;


class DetalleplanillaController extends Controller
{
    public function index(Request $request)
    {
       if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $detalleplanilla= Detalleplanilla::join('contratos', 'detalle_planilla.contrato_cod_contrato', '=', 'contratos.cod_contrato')
                            ->join('personal','contratos.personal_cod_personal','personal.cod_personal')
                            ->orderBy('cod_detalle_planilla','desc')
                            ->paginate(10);
        }
        else
        {
            $detalleplanilla=Detalleplanilla::join('contratos', 'detalle_planilla.contrato_cod_contrato', '=', 'contratos.cod_contrato')
                            ->join('personal','contratos.personal_cod_personal','personal.cod_personal')
                            ->where('planilla_cod_planilla','like','%'.$buscar.'%')
                            ->orderBy('cod_detalle_planilla','desc')
                            ->paginate(10);
        }

        
        return [
            'pagination' =>[
                'total'         => $detalleplanilla->total(),
                'current_page'  => $detalleplanilla->currentPage(),
                'per_page'      => $detalleplanilla->perpage(),
                'last_page'     => $detalleplanilla->lastPage(),
                'from'          => $detalleplanilla->firstItem(),
                'to'            => $detalleplanilla->lastItem(),
            ],
            'detalleplanilla' => $detalleplanilla
        ];
    }

    Public function Rp_DetallePlanilla(Request $request){

        $codplanilla= $request->codplanilla;

        $rp_DetallePlanilla= Detalleplanilla::join('planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
                                    ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=','contratos.cod_contrato')
                                    ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
                                    ->join('admin_pensiones', 'personal.admin_pension_cod_admin_pension', '=', 'admin_pensiones.cod_admin_pension')
                                    ->join('sexo', 'personal.sexo_cod_sexo', '=', 'sexo.cod_sexo')
                                    ->join('cargos', 'contratos.cargo_cod_cargo', '=', 'cargos.cod_cargo')
                                    ->join('meta', 'contratos.meta_m_cod_meta', '=', 'meta.m_cod_meta')
                                    ->join('areas', 'contratos.area_a_cod_area', '=', 'areas.a_cod_area')
                                    ->join('bancos', 'personal.banco_cod_banco', '=', 'bancos.cod_banco')
                                    ->with('Planilla_Conceptos')
                                    ->where('planilla_cod_planilla','=',$codplanilla)
                                    ->orderBy('p_a_paterno','asc')
                                    ->get();
        
        $totalplanilla= Planilla::where('cod_planilla','=',$codplanilla)->first();

        $pdf = \PDF::loadView('pdf.rep_detalleplanilla', compact('rp_DetallePlanilla','totalplanilla'));

        $pdf->setPaper('A3','landscape');

        return $pdf->stream('resumen.pdf');

    }

    Public function Rp_DetallePlanillaExcel(Request $request){

        $codplanilla= $request->codplanilla;

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial Narrow');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $planillaperiodo=Planilla::find($codplanilla);//where('cod_planilla', '=',$codplanilla)->get();

        $conceptosdata=Planillaconceptos::join('conceptos','planilla_conceptos.concepto_cod_concepto','conceptos.cod_concepto')
          ->join('detalle_planilla','planilla_conceptos.detalle_planilla_cod_detalle_planilla','detalle_planilla.cod_detalle_planilla')
          ->join('planilla','detalle_planilla.planilla_cod_planilla','planilla.cod_planilla')
          ->select('cod_concepto','con_abrev', DB::raw('sum(pll_id_monto) as monto'))
          ->where('cod_planilla', '=',$codplanilla)
          ->where('tipo_concepto_cod_tip_concepto', '=',2)
          ->groupBy('cod_concepto','con_abrev')
          ->get();
        
        $conceptosdataingresos=Planillaconceptos::join('conceptos','planilla_conceptos.concepto_cod_concepto','conceptos.cod_concepto')
          ->join('detalle_planilla','planilla_conceptos.detalle_planilla_cod_detalle_planilla','detalle_planilla.cod_detalle_planilla')
          ->join('planilla','detalle_planilla.planilla_cod_planilla','planilla.cod_planilla')
          ->select('cod_concepto','con_abrev', DB::raw('sum(pll_id_monto) as monto'))
          ->where('cod_planilla', '=',$codplanilla)
          ->whereIn('tipo_concepto_cod_tip_concepto',[1,3])
          //->orWhere('tipo_concepto_cod_tip_concepto', '=',3)
          ->groupBy('cod_concepto','con_abrev')
          ->get();
        
        $conceptosdataaportes=Planillaconceptos::join('conceptos','planilla_conceptos.concepto_cod_concepto','conceptos.cod_concepto')
          ->join('detalle_planilla','planilla_conceptos.detalle_planilla_cod_detalle_planilla','detalle_planilla.cod_detalle_planilla')
          ->join('planilla','detalle_planilla.planilla_cod_planilla','planilla.cod_planilla')
          ->select('cod_concepto','con_abrev', DB::raw('sum(pll_id_monto) as monto'))
          ->where('cod_planilla', '=',$codplanilla)
          ->where('tipo_concepto_cod_tip_concepto', '=',4)
          ->groupBy('cod_concepto','con_abrev')
          ->get();

        $textoencabezado = array();

        $textoencabezado[] = 'N°';
        $textoencabezado[] = 'COD_PERSONAL';
        $textoencabezado[] = 'COD_PLAZA';
        $textoencabezado[] = 'COD_AIRHSP';
        $textoencabezado[] = 'NUM_DOC';
        $textoencabezado[] = 'APELLIDO_PATERNO';
        $textoencabezado[] = 'APELLIDO_MATERNO';
        $textoencabezado[] = 'NOMBRES';
        $textoencabezado[] = 'FECH_NAC';
        $textoencabezado[] = 'SEXO';
        $textoencabezado[] = 'N° CONTRATO';
        $textoencabezado[] = 'RUC';
        $textoencabezado[] = 'FECH_INI';
        $textoencabezado[] = 'FECH_FN';
        $textoencabezado[] = 'ADMIN_PENSION';
        $textoencabezado[] = 'CUSPP';
        $textoencabezado[] = 'FECH_AFIL';
        $textoencabezado[] = 'AREA';
        $textoencabezado[] = 'CARGO';
        $textoencabezado[] = 'META';
        $textoencabezado[] = 'DIAS_LAB';
        $textoencabezado[] = 'HORAS_LAB';
        $textoencabezado[] = 'BANCO';
        $textoencabezado[] = 'CUENTA';
        foreach($conceptosdataingresos as $conceptosmostrar){
          $textoencabezado[] = $conceptosmostrar->cod_concepto.'-'.$conceptosmostrar->con_abrev;
      }
        $textoencabezado[] = 'M_BRUTO';
        $textoencabezado[] = 'M_BASE_CALCULO';

        foreach($conceptosdata as $conceptosmostrar){
            $textoencabezado[] = $conceptosmostrar->cod_concepto.'-'.$conceptosmostrar->con_abrev;
        }

        $textoencabezado[] = 'TOTAL DESC.';
        $textoencabezado[] = 'REM. LIQUIDA';
        foreach($conceptosdataaportes as $conceptosmostrar){
          $textoencabezado[] = $conceptosmostrar->cod_concepto.'-'.$conceptosmostrar->con_abrev;
        }
        $textoencabezado[] = 'APORTES';

        $arrayencabezado = [
            $textoencabezado
        ];

        $datosplanilla=Detalleplanilla::join('planilla', 'detalle_planilla.planilla_cod_planilla', '=', 'planilla.cod_planilla')
          ->join('contratos', 'detalle_planilla.contrato_cod_contrato', '=','contratos.cod_contrato')
          ->join('personal', 'contratos.personal_cod_personal', '=', 'personal.cod_personal')
          ->join('admin_pensiones', 'personal.admin_pension_cod_admin_pension', '=', 'admin_pensiones.cod_admin_pension')
          ->join('sexo', 'personal.sexo_cod_sexo', '=', 'sexo.cod_sexo')
          ->join('cargos', 'contratos.cargo_cod_cargo', '=', 'cargos.cod_cargo')
          ->join('meta', 'contratos.meta_m_cod_meta', '=', 'meta.m_cod_meta')
          ->join('areas', 'contratos.area_a_cod_area', '=', 'areas.a_cod_area')
          ->join('bancos', 'personal.banco_cod_banco', '=', 'bancos.cod_banco')
          ->with('Planilla_Conceptos')
          ->where('planilla_cod_planilla','=',$codplanilla)
          ->orderBy('p_a_paterno','asc')
          ->get();


        $numeracionrem=24;
        $numeracion = 1;
        $data=[];

        foreach ($datosplanilla as $datosplanilla){
            $row = [];
            $row[0] = $numeracion;
            $row[1] = $datosplanilla->cod_personal;
            $row[2] = $datosplanilla->c_plaza;
            $row[3] = $datosplanilla->c_cod_reg_airhsp;
            $row[4] = $datosplanilla->p_num_doc;
            $row[5] = $datosplanilla->p_a_paterno	;
            $row[6] = $datosplanilla->p_a_materno;
            $row[7] = $datosplanilla->p_nombres;
            $row[8] = date("d/m/Y", strtotime($datosplanilla->p_fech_nac));
            $row[9] = $datosplanilla->s_sexo;
            $row[10] = $datosplanilla->c_numero;
            $row[11] = $datosplanilla->p_ruc;
            $row[12] = date("d/m/Y", strtotime($datosplanilla->c_fech_ini));
            $row[13] = date("d/m/Y", strtotime($datosplanilla->c_fech_ter));
            $row[14] = $datosplanilla->ap_admin_pension;
            $row[15] = $datosplanilla->p_cuspp;
            if($datosplanilla->p_fech_afiliacion==null){
                $row[16] = "";
            }else{
                $row[16] = date("d/m/Y", strtotime($datosplanilla->p_fech_afiliacion));
            }
            $row[17] = $datosplanilla->a_area;
            $row[18] = $datosplanilla->c_nomcar;
            $row[19] = $datosplanilla->meta;
            $row[20] = $datosplanilla->dpll_dias_lab;
            $row[21] = $datosplanilla->c_horas;
            $row[22] = $datosplanilla->b_banco;
            $row[23] = $datosplanilla->p_num_cuenta;

            $numeracionrem+=24;

            foreach($conceptosdataingresos as $conceptosimprimir){

              $valordefecto=0.00;

              foreach($datosplanilla->Planilla_Conceptos as $resconceptosimprimir){

                  if($resconceptosimprimir->concepto_cod_concepto == $conceptosimprimir->cod_concepto && ($resconceptosimprimir->tipo_concepto_cod_tip_concepto==1 || $resconceptosimprimir->tipo_concepto_cod_tip_concepto==3))
                      {
                          $i = $resconceptosimprimir->pll_id_monto;
                      }

              }

                  if(!@$i){
                      $row[$numeracionrem] = $valordefecto;
                  }else{
                      $row[$numeracionrem] = @$i;
              }

              $i = 0;
              $numeracionrem+=1;
          }

            $row[24] = $datosplanilla->dpll_bruto;
            $row[25] = $datosplanilla->dpll_base_calculo;

            foreach($conceptosdata as $conceptosimprimir){

                $valordefecto=0.00;

                foreach($datosplanilla->Planilla_Conceptos as $resconceptosimprimir){

                    if($resconceptosimprimir->concepto_cod_concepto == $conceptosimprimir->cod_concepto && $resconceptosimprimir->tipo_concepto_cod_tip_concepto==2)
                        {
                            $i = $resconceptosimprimir->pll_id_monto;
                        }

                }

                    if(!@$i){
                        $row[$numeracionrem] = $valordefecto;
                    }else{
                        $row[$numeracionrem] = @$i;
                }

                $i = 0;
                $numeracionrem+=1;
            }

                $row[$numeracionrem+1] = $datosplanilla->dpll_descuentos;
                $row[$numeracionrem+2] = $datosplanilla->dpll_liquido;

                $numeracionrem+=3;

                foreach($conceptosdataaportes as $conceptosimprimir){

                    $valordefecto=0.00;
    
                    foreach($datosplanilla->Planilla_Conceptos as $resconceptosimprimir){
    
                        if($resconceptosimprimir->concepto_cod_concepto == $conceptosimprimir->cod_concepto && $resconceptosimprimir->tipo_concepto_cod_tip_concepto==4)
                            {
                                $i = $resconceptosimprimir->pll_id_monto;
                            }
    
                    }
    
                        if(!@$i){
                            $row[$numeracionrem] = $valordefecto;
                        }else{
                            $row[$numeracionrem] = @$i;
                    }
    
                    $i = 0;
                    $numeracionrem+=1;
                }


                $row[$numeracionrem+1] = $datosplanilla->dpll_aport;

            $data[]=$row;
            $numeracion += 1;
        }


        $arrayData = $data;


        $spreadsheet->getActiveSheet()
            ->fromArray($arrayencabezado,NULL,'A2')
            ->fromArray($arrayData,NULL,'A3');

        // Aquí
        $filename = 'PlanillaCAS-'.$planillaperiodo->pll_periodo.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $objWriter->save('php://output');


    }

    Public function Rp_Descuentos(Request $request){


        $estaciones = Estacion::where('ejecutora_e_id','=','001')->get();
        $conceptos = Concepto::all();
        $metas = Meta::where('m_anio_per','=','2025')->get();
        $clasificadores = Clasificador::all();


        foreach ($estaciones as $estacion) {
            foreach ($conceptos as $concepto){

               $sql = "SELECT p_num_doc, p_a_paterno, p_a_materno, p_nombres, est_nombre, idclasificador,clasificador, meta, pll_id_monto, estacion_est_id, concepto_cod_concepto 
                FROM planilla_conceptos 
                INNER JOIN conceptos ON planilla_conceptos.concepto_cod_concepto = conceptos.cod_concepto
                INNER JOIN clasificador ON planilla_conceptos.clasificador_idclasificador = clasificador.idclasificador
                INNER JOIN meta ON planilla_conceptos.meta_m_cod_meta = meta.m_cod_meta
                INNER JOIN detalle_planilla ON planilla_conceptos.detalle_planilla_cod_detalle_planilla = detalle_planilla.cod_detalle_planilla
                INNER JOIN contratos ON detalle_planilla.contrato_cod_contrato = contratos.cod_contrato
                INNER JOIN estacion ON contratos.estacion_est_id = estacion.est_id
                INNER JOIN personal ON contratos.personal_cod_personal = personal.cod_personal
                WHERE estacion_est_id = ? AND concepto_cod_concepto = ? AND tipo_concepto_cod_tip_concepto=2 
                ORDER BY clasificador, meta";

                $datadescuentos = DB::select($sql, [$estacion->est_id, $concepto->cod_concepto]);

                if(!empty($datadescuentos)) {
                    $pdf = \PDF::loadView('pdf.rep_descuentos', compact('datadescuentos','metas','estacion','concepto','clasificadores'));
                    $fileName = 'pdfs/'.$estacion->est_nombre.'/'.$concepto->con_nombre.'-'.time().'.pdf';
                    Storage::put($fileName,$pdf->output());
                }

            }
        }

        return response()->json([message=>'PDFs generados y guardados']);

    }

    Public function Rp_Descuentos_AFP(Request $request){


        $estaciones = Estacion::where('ejecutora_e_id','=','001')->get();
        $conceptos = Concepto::all();
        $metas = Meta::where('m_anio_per','=','2024')->get();
        $clasificadores = Clasificador::all();


        foreach ($estaciones as $estacion) {
            foreach ($conceptos as $concepto){

               $sql = "SELECT p_num_doc, p_a_paterno, p_a_materno, p_nombres, est_nombre, idclasificador,clasificador, meta, pll_id_monto, estacion_est_id, concepto_cod_concepto 
                FROM planilla_conceptos 
                INNER JOIN conceptos ON planilla_conceptos.concepto_cod_concepto = conceptos.cod_concepto
                INNER JOIN clasificador ON planilla_conceptos.clasificador_idclasificador = clasificador.idclasificador
                INNER JOIN meta ON planilla_conceptos.meta_m_cod_meta = meta.m_cod_meta
                INNER JOIN detalle_planilla ON planilla_conceptos.detalle_planilla_cod_detalle_planilla = detalle_planilla.cod_detalle_planilla
                INNER JOIN contratos ON detalle_planilla.contrato_cod_contrato = contratos.cod_contrato
                INNER JOIN estacion ON contratos.estacion_est_id = estacion.est_id
                INNER JOIN personal ON contratos.personal_cod_personal = personal.cod_personal
                WHERE estacion_est_id = ? AND concepto_cod_concepto = ? AND tipo_concepto_cod_tip_concepto=2 
                ORDER BY clasificador, meta";

                $datadescuentos = DB::select($sql, [$estacion->est_id, $concepto->cod_concepto]);

                if(!empty($datadescuentos)) {
                    $pdf = \PDF::loadView('pdf.rep_descuentos', compact('datadescuentos','metas','estacion','concepto','clasificadores'));
                    $fileName = 'pdfs/'.$estacion->est_nombre.'/'.$concepto->con_nombre.'-'.time().'.pdf';
                    Storage::put($fileName,$pdf->output());
                }

            }
        }

        return response()->json([message=>'PDFs generados y guardados']);

    }
}
