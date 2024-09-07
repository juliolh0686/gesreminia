<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contrato;
use App\Pagoocasional;

class ContratosController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cod_personal= $request->cod_personal;
       
            $contratos=Contrato::where('personal_cod_personal','like','%'.$cod_personal.'%')
            ->orderBy('cod_contrato','desc')
            ->paginate(5);


        
        return [
            'pagination' =>[
                'total'         => $contratos->total(),
                'current_page'  => $contratos->currentPage(),
                'per_page'      => $contratos->perpage(),
                'last_page'     => $contratos->lastPage(),
                'from'          => $contratos->firstItem(),
                'to'            => $contratos->lastItem(),
            ],
            'contratos' => $contratos
        ];
    }

    public function store(Request $request){

        if (!$request->ajax()) return redirect('/');

        //Validacion del Formulario

        $rules = [
            'c_numero'=>'required',
            'c_plaza'=>'required',
        ];

        $messages = [
            'c_numero.required' => 'Debe ingresar el numero de contrato',
            'c_plaza.required' =>'Debe ingresar la plaza',
        ];

        $this->validate($request,$rules,$messages);

        //Fin validacion del formulario

        //CAMBIAR A FORMATO DE FECHA PARA INSERTAR EN BASE DE DATOS
        $mifecha = explode("/", $request->c_fech_contrato);
        $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
        $fech_contrato= $lafecha;

        $mifecha = explode("/", $request->c_fech_ini);
        $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
        $fech_ini= $lafecha;

        $mifecha = explode("/", $request->c_fech_ter);
        $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
        $fech_fin= $lafecha;

        $contrato= new Contrato();
        $contrato->cod_contrato = $request->cod_contrato;
        $contrato->c_numero = $request->c_numero;
        $contrato->c_plaza = $request->c_plaza;
        $contrato->c_cod_reg_airhsp = $request->c_cod_reg_airhsp;
        $contrato->c_fech_contrato = $fech_contrato;
        $contrato->c_fech_ini = $fech_ini;
        $contrato->c_fech_ter = $fech_fin;
        $contrato->area_a_cod_area = $request->area_a_cod_area;
        $contrato->cargo_cod_cargo = $request->cargo_cod_cargo;
        $contrato->tipo_trabajador_cod_tipo_trabajador = $request->tipo_trabajador_cod_tipo_trabajador;
        $contrato->tipo_planilla_cod_tipo_planilla = $request->tipo_planilla_cod_tipo_planilla;
        $contrato->clasificador_id = $request->clasificador_id;
        $contrato->meta_m_cod_meta = $request->meta_m_cod_meta;
        $contrato->regimen_laboral_cod_regimen_laboral = $request->regimen_laboral_cod_regimen_laboral;
        $contrato->c_horas = $request->c_horas;
        $contrato->sus_renta = $request->sus_renta;
        $contrato->num_operacion = $request->num_operacion;
        $contrato->c_dias_lab = $request->c_dias_lab;
        $contrato->c_observacion = $request->c_observacion;
        $contrato->personal_cod_personal = $request->cod_personal;
        $contrato->tipo_pago_cod_tipo_pago = $request->tipo_pago_cod_tipo_pago;
        $contrato->tipo_registro_airhsp_tra_id = $request->tipo_registro_airhsp_tra_id;
        $contrato->estado_personal_cod_estado_personal = '01';
        $contrato->save();
    }

    public function update(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        //CAMBIAR A FORMATO DE FECHA PARA INSERTAR EN BASE DE DATOS
        $mifecha = explode("/", $request->c_fech_contrato);
        $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
        $fech_contrato= $lafecha;

        $mifecha = explode("/", $request->c_fech_ini);
        $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
        $fech_ini= $lafecha;

        $mifecha = explode("/", $request->c_fech_ter);
        $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
        $fech_fin= $lafecha;

        //$fech_contrato = date('Y-m-d', strtotime($request->c_fech_contrato));
        //$fech_ini = date('Y-m-d', strtotime($request->c_fech_ini));
        //$fech_fin = date('Y-m-d', strtotime($request->c_fech_ter));

        $contrato= Contrato::findOrFail($request->cod_contrato);
        $contrato->c_numero = $request->c_numero;
        $contrato->c_plaza = $request->c_plaza;
        $contrato->c_cod_reg_airhsp = $request->c_cod_reg_airhsp;
        $contrato->c_fech_contrato = $fech_contrato;
        $contrato->c_fech_ini = $fech_ini;
        $contrato->c_fech_ter = $fech_fin;
        $contrato->area_a_cod_area = $request->area_a_cod_area;
        $contrato->cargo_cod_cargo = $request->cargo_cod_cargo;
        $contrato->tipo_trabajador_cod_tipo_trabajador = $request->tipo_trabajador_cod_tipo_trabajador;
        $contrato->tipo_planilla_cod_tipo_planilla = $request->tipo_planilla_cod_tipo_planilla;
        $contrato->clasificador_id = $request->clasificador_id;
        $contrato->meta_m_cod_meta = $request->meta_m_cod_meta;
        $contrato->regimen_laboral_cod_regimen_laboral = $request->regimen_laboral_cod_regimen_laboral;
        $contrato->c_horas = $request->c_horas;
        $contrato->sus_renta = $request->sus_renta;
        $contrato->num_operacion = $request->num_operacion;
        $contrato->aseguradora_cod_aseguradora = $request->aseguradora_cod_aseguradora;
        $contrato->plan_eps_cod_plan_eps = $request->plan_eps_cod_plan_eps;
        $contrato->comp_fam_cod_comp_fam = $request->comp_fam_cod_comp_fam;
        $contrato->monto_eps = $request->monto_eps;
        $contrato->afiliados_eps = $request->afiliados_eps;
        $contrato->c_dias_lab = $request->c_dias_lab;
        $contrato->c_dias_lic = $request->c_dias_lic;
        $contrato->c_desc_dias = $request->c_desc_dias;
        $contrato->c_desc_horas = $request->c_desc_horas;
        $contrato->c_desc_min = $request->c_desc_min;
        $contrato->c_desc_perm = $request->c_desc_perm;
        $contrato->c_observacion = $request->c_observacion;
        $contrato->personal_cod_personal = $request->cod_personal;
        $contrato->tipo_pago_cod_tipo_pago = $request->tipo_pago_cod_tipo_pago;
        $contrato->estado_personal_cod_estado_personal = $request->estado_personal_cod_estado_personal;
        $contrato->tipo_registro_airhsp_tra_id = $request->tipo_registro_airhsp_tra_id;
        $contrato->save();
    }

    public function restablecercontratos(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

            $actualizarcontrato=Contrato::where('estado_personal_cod_estado_personal','01')
            ->update(['c_desc_dias' => 0,'c_desc_horas' => 0,'c_desc_min' => 0,'c_desc_perm' => 0,'c_dias_lab' => 30]);

        
            $datacontratos= Contrato::where('c_dias_lic','>',0)->where('estado_personal_cod_estado_personal','=','03')
            ->orWhere('estado_personal_cod_estado_personal','=','04')->get();

            foreach($datacontratos as $itemscontratos){

                $dias_licencia= $itemscontratos->c_dias_lic;

                $total_dias_lis=0;

                if($dias_licencia>30){

                    $total_dias_lis=$dias_licencia-30;

                }

                if($total_dias_lis==0){

                    $contrato= Contrato::findOrFail($itemscontratos->cod_contrato);
                    $contrato->c_dias_lic = $total_dias_lis;
                    $contrato->estado_personal_cod_estado_personal = '01';
                    $contrato->save();

                }else{

                    $contrato= Contrato::findOrFail($itemscontratos->cod_contrato);
                    $contrato->c_dias_lic = $total_dias_lis;
                    $contrato->save();

                }


                }


    }

    public function aguinaldoMasivo(Request $request)
    {

      if (!$request->ajax()) return redirect('/');

      $datacontratos= Contrato::where('estado_personal_cod_estado_personal','=','01')
        ->orWhere('estado_personal_cod_estado_personal','=','03')->get();

      foreach($datacontratos as $itemscontratos){

        $pagoocasional= new Pagoocasional();
        $pagoocasional->po_monto = $request->pll_id_monto;
        $pagoocasional->po_inicio = $request->periodo;
        $pagoocasional->po_termino = $request->periodo;
        $pagoocasional->contrato_cod_contrato = $itemscontratos->cod_contrato;
        $pagoocasional->concepto_cod_concepto = '0025';
        $pagoocasional->save();

      }

    }


}
