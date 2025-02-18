<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\DataImport;
use App\Imports\PersonalImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Personal;
use App\Contrato;
use App\Detalleplanilla;
use App\Planillaconceptos;

class ImportplanillaController extends Controller
{

    public function PersonalImport(Request $request) {
        try {

            $contador = 0;

            $import = new DataImport;
            $data = Excel::toCollection($import,'D:/DatosPersonal.xlsx');//request()->file('file')

            $datos = $data->first();

            //Recorrer las filas a insertar
            foreach ($datos->skip(1) as $data) {
    
                //$this->procesarPlanillasiaf($fila);//,$expediente_documento_ed_id

                //Datos Personales
                $tipo_documento_cod_tipo_documento=trim($data[0]);
                $p_num_doc=trim($data[1]);
                $p_a_paterno = mb_convert_encoding(trim($data[2]),'UTF-8');
                $p_a_materno = mb_convert_encoding(trim($data[3]),'UTF-8');
                $p_nombres = mb_convert_encoding(trim($data[4]),'UTF-8');
                $p_fech_nac = trim($data[5]);

                // Procesar la fecha
                $mifecha = explode("/", $p_fech_nac);
                $lafecha = isset($mifecha[2]) && isset($mifecha[1]) && isset($mifecha[0]) 
                            ? $mifecha[2] . "-" . $mifecha[1] . "-" . $mifecha[0] 
                            : null; // Verificar que la fecha esté bien formateada
                $p_fech_nac = $lafecha;

                // Columnas opcionales que pueden estar vacías
                $sexo_cod_sexo = isset($data[6]) ? trim($data[6]) : null;
                $estado_civil_cod_estado_civil = isset($data[7]) ? trim($data[7]) : null;
                $p_ruc = isset($data[8]) ? trim($data[8]) : null;
                $distrito_cod_distrito = isset($data[9]) ? trim($data[9]) : null;
                $p_direccion = isset($data[10]) ? trim($data[10]) : null;
                $p_correo = isset($data[11]) ? trim($data[11]) : null;
                $p_telefono = isset($data[12]) ? trim($data[12]) : null;
                $p_celular = isset($data[13]) ? trim($data[13]) : null;
                $p_observacion = isset($data[14]) ? trim($data[14]) : null;
                $admin_pension_cod_admin_pension = isset($data[15]) ? trim($data[15]) : null;
                $p_cuspp = isset($data[16]) ? trim($data[16]) : null;
                $p_fech_afiliacion = isset($data[17]) ? trim($data[17]) : null;
                $banco_cod_banco = isset($data[18]) ? trim($data[18]) : null;
                $p_num_cuenta = isset($data[19]) ? trim($data[19]) : null;
                $foto = isset($data[20]) ? trim($data[20]) : null;
                //Datos Personales
                Personal::updateOrCreate(
                ['p_num_doc' => $p_num_doc],
                [
                    'cod_personal' => "10".$p_num_doc,
                    'tipo_documento_cod_tipo_documento' => $tipo_documento_cod_tipo_documento,
                    'p_num_doc' => $p_num_doc,
                    'p_a_paterno' => $p_a_paterno,
                    'p_a_materno' => $p_a_materno,
                    'p_nombres' => $p_nombres,
                    'p_fech_nac' => $p_fech_nac,
                    'sexo_cod_sexo' => $sexo_cod_sexo,
                    'estado_civil_cod_estado_civil' => $estado_civil_cod_estado_civil,
                    'p_ruc' => $p_ruc,
                    'distrito_cod_distrito' => $distrito_cod_distrito,
                    'p_direccion' => $p_direccion,
                    'p_correo' => $p_correo,
                    'p_telefono' => $p_telefono,
                    'p_celular' => $p_celular,
                    'p_observacion' => $p_observacion,
                    'admin_pension_cod_admin_pension' => $admin_pension_cod_admin_pension,
                    'p_cuspp' => $p_cuspp,
                    'p_fech_afiliacion' => $p_fech_afiliacion,
                    'banco_cod_banco' => $banco_cod_banco,
                    'p_num_cuenta' => $p_num_cuenta,
                    'foto' => $foto
                ]
                );

                $contador++;
            }

        } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
        }
        
    }

    public function ContratosImport(Request $request) {
        try {

            $contador = 0;

            $import = new DataImport;
            $data = Excel::toCollection($import,'D:/Contratos.xlsx');//request()->file('file')

            $datos = $data->first();

            //Recorrer las filas a insertar
            foreach ($datos->skip(1) as $data) {
    
                //$this->procesarPlanillasiaf($fila);//,$expediente_documento_ed_id

                //Datos Personales
                $tipo_documento_cod_tipo_documento=trim($data[0]);
                $p_num_doc=trim($data[1]);
                $p_a_paterno = mb_convert_encoding(trim($data[2]),'UTF-8');
                $p_a_materno = mb_convert_encoding(trim($data[3]),'UTF-8');
                $p_nombres = mb_convert_encoding(trim($data[4]),'UTF-8');
                $p_fech_nac = trim($data[5]);

                // Procesar la fecha
                $mifecha = explode("/", $p_fech_nac);
                $lafecha = isset($mifecha[2]) && isset($mifecha[1]) && isset($mifecha[0]) 
                            ? $mifecha[2] . "-" . $mifecha[1] . "-" . $mifecha[0] 
                            : null; // Verificar que la fecha esté bien formateada
                $p_fech_nac = $lafecha;

                // Columnas opcionales que pueden estar vacías
                $sexo_cod_sexo = isset($data[6]) ? trim($data[6]) : null;
                $estado_civil_cod_estado_civil = isset($data[7]) ? trim($data[7]) : null;
                $p_ruc = isset($data[8]) ? trim($data[8]) : null;
                $distrito_cod_distrito = isset($data[9]) ? trim($data[9]) : null;
                $p_direccion = isset($data[10]) ? trim($data[10]) : null;
                $p_correo = isset($data[11]) ? trim($data[11]) : null;
                $p_telefono = isset($data[12]) ? trim($data[12]) : null;
                $p_celular = isset($data[13]) ? trim($data[13]) : null;
                $p_observacion = isset($data[14]) ? trim($data[14]) : null;
                $admin_pension_cod_admin_pension = isset($data[15]) ? trim($data[15]) : null;
                $p_cuspp = isset($data[16]) ? trim($data[16]) : null;
                $p_fech_afiliacion = isset($data[17]) ? trim($data[17]) : null;
                $banco_cod_banco = isset($data[18]) ? trim($data[18]) : null;
                $p_num_cuenta = isset($data[19]) ? trim($data[19]) : null;
                $foto = isset($data[20]) ? trim($data[20]) : null;
                //Datos Personales
                Personal::updateOrCreate(
                ['p_num_doc' => $p_num_doc],
                [
                    'cod_personal' => "10".$p_num_doc,
                    'tipo_documento_cod_tipo_documento' => $tipo_documento_cod_tipo_documento,
                    'p_num_doc' => $p_num_doc,
                    'p_a_paterno' => $p_a_paterno,
                    'p_a_materno' => $p_a_materno,
                    'p_nombres' => $p_nombres,
                    'p_fech_nac' => $p_fech_nac,
                    'sexo_cod_sexo' => $sexo_cod_sexo,
                    'estado_civil_cod_estado_civil' => $estado_civil_cod_estado_civil,
                    'p_ruc' => $p_ruc,
                    'distrito_cod_distrito' => $distrito_cod_distrito,
                    'p_direccion' => $p_direccion,
                    'p_correo' => $p_correo,
                    'p_telefono' => $p_telefono,
                    'p_celular' => $p_celular,
                    'p_observacion' => $p_observacion,
                    'admin_pension_cod_admin_pension' => $admin_pension_cod_admin_pension,
                    'p_cuspp' => $p_cuspp,
                    'p_fech_afiliacion' => $p_fech_afiliacion,
                    'banco_cod_banco' => $banco_cod_banco,
                    'p_num_cuenta' => $p_num_cuenta,
                    'foto' => $foto
                ]
                );

                $contador++;
            }

        } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
        }
        
    }


    public function import(Request $request)
    {
        try {

            //Rescatar el nombre
           // $nom_archivo = $request->filename;
           // $num_doc_siaf = basename($nom_archivo, ".xlsx");

            $contador = 0;

            $import = new DataImport;
            $data = Excel::toCollection($import,'D:/CargaPruega.xlsx');//request()->file('file')

            $datos = $data->first();

            //Sacar el codigo expediente documento
            //$expediente_documento = Expedientedocumento::where('ed_num_doc', $num_doc_siaf)->first();
            //$idexpediente_documento = $expediente_documento->ed_id;

            //$expediente_documento_ed_id=$idexpediente_documento;

            //return $expediente_documento_ed_id;


            //Recorrer las filas a insertar
            foreach ($datos->skip(1) as $fila) {
                $this->procesarPlanillasiaf($fila);//,$expediente_documento_ed_id
                $contador++;
            }

            return response()->json([
                'status' => true,
                'message' => 'Reporte Satisfactorio',
                'numero' => $contador
              ], 200);


          } catch (\Throwable $th) {
            return response()->json([
              'status' => false,
              'message' => $th->getMessage()
            ], 500);
          }
    }

    private function procesarPlanillasiaf($data) {//,$expediente_documento

        //Datos Personales
        $tipo_documento_cod_tipo_documento=trim($data[1]);
        $p_num_doc=trim($data[2]);
        $p_a_paterno = mb_convert_encoding(trim($data[3]),'UTF-8');
        $p_a_materno = mb_convert_encoding(trim($data[4]),'UTF-8');
        $p_nombres = mb_convert_encoding(trim($data[5]),'UTF-8');
        $sexo_cod_sexo = trim($data[6]);
        $estado_civil_cod_estado_civil = trim($data[7]);
        $distrito_cod_distrito = '010101';
        $admin_pension_cod_admin_pension = trim($data[9]);                           
        $banco_cod_banco = trim($data[10]);
        $p_num_cuenta = trim($data[11]);

        //Datos Personales
        Personal::updateOrCreate(
        ['p_num_doc' => $p_num_doc],
        [
            'cod_personal' => "10".$p_num_doc,
            'tipo_documento_cod_tipo_documento' => $tipo_documento_cod_tipo_documento,
            'p_num_doc' => $p_num_doc,
            'p_a_paterno' => $p_a_paterno,
            'p_a_materno' => $p_a_materno,
            'p_nombres' => $p_nombres,
            'sexo_cod_sexo' => $sexo_cod_sexo,
            'estado_civil_cod_estado_civil' => '01',
            'distrito_cod_distrito' => $distrito_cod_distrito,
            'admin_pension_cod_admin_pension' => $admin_pension_cod_admin_pension,
            'banco_cod_banco' => $banco_cod_banco,
            'p_num_cuenta' => $p_num_cuenta
        ]
        );

        //dd($tipo_documento_cod_tipo_documento);

        //Datos Laborales

        $c_cod_reg_airhsp=trim($data[12]);
        $c_fech_ini=trim($data[13]);

        $mifecha = explode("/", $c_fech_ini);
        $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
        $c_fech_ini= $lafecha;

        $estacion_est_id=trim($data[14]);
        $area_a_cod_area=trim($data[15]);
        $cargo_cod_cargo=trim($data[16]);
        $regimen_laboral_cod_regimen_laboral=trim($data[17]);
        $tipo_trabajador_cod_tipo_trabajador=trim($data[18]);
        $tipo_planilla_cod_tipo_planilla =trim($data[19]);
        $clasificador_id=trim($data[20]);
        $meta_m_cod_meta=trim($data[21]);
        $tipo_pago_cod_tipo_pago=trim($data[22]);
        $tipo_registro_airhsp_tra_id=trim($data[23]);

        //Datos Laborales
        Contrato::updateOrCreate(
        ['personal_cod_personal' => "10".$p_num_doc],
        [
            'c_cod_reg_airhsp' => $c_cod_reg_airhsp,
            'c_fech_ini' => $c_fech_ini,
            'estacion_est_id' => $estacion_est_id,
            'area_a_cod_area' => $area_a_cod_area,
            'cargo_cod_cargo'=> $cargo_cod_cargo,
            'regimen_laboral_cod_regimen_laboral'=> $regimen_laboral_cod_regimen_laboral,
            'tipo_trabajador_cod_tipo_trabajador'=> $tipo_trabajador_cod_tipo_trabajador,
            'tipo_planilla_cod_tipo_planilla' => $tipo_planilla_cod_tipo_planilla,
            'clasificador_id' => $clasificador_id,
            'meta_m_cod_meta'=> $meta_m_cod_meta,
            'personal_cod_personal' => "10".$p_num_doc,
            'tipo_pago_cod_tipo_pago'=> $tipo_pago_cod_tipo_pago,
            'estado_personal_cod_estado_personal'=> '01',
            'tipo_registro_airhsp_tra_id'=> $tipo_registro_airhsp_tra_id,
        ]
        );

        //Detalle Planilla
        $dpll_bruto=trim($data[24]);
        $dpll_base_calculo=trim($data[25]);
        $dpll_descuentos=trim($data[26]);
        $dpll_liquido=trim($data[27]);
        $dpll_aport=trim($data[28]);
        $planilla_cod_planilla=trim($data[29]);

        $contratos = Contrato::where('personal_cod_personal', "10".$p_num_doc)->first();
        $contrato_cod_contrato = $contratos->cod_contrato;

        Detalleplanilla::create([
            'dpll_bruto' => $dpll_bruto,
            'dpll_base_calculo' => $dpll_base_calculo,
            'dpll_descuentos' => $dpll_descuentos,
            'dpll_liquido' => $dpll_liquido,
            'dpll_aport' => $dpll_aport,
            'planilla_cod_planilla' => $planilla_cod_planilla,
            'contrato_cod_contrato' => $contrato_cod_contrato
        ]);
        
        $detalle_planilla = Detalleplanilla::where('contrato_cod_contrato', $contrato_cod_contrato)->first();
        $cod_detalle_planilla = $detalle_planilla->cod_detalle_planilla;


        $conceptos = [
            ['monto' => trim($data[30]), 'codigo' => '0101'],
            ['monto' => trim($data[31]), 'codigo' => '0047'],
            ['monto' => trim($data[32]), 'codigo' => '0184'],
            ['monto' => trim($data[33]), 'codigo' => '0103'],
            ['monto' => trim($data[34]), 'codigo' => '0981'],
            ['monto' => trim($data[35]), 'codigo' => '2001'],
            ['monto' => trim($data[36]), 'codigo' => '0236'],
            ['monto' => trim($data[37]), 'codigo' => '2032'],
            ['monto' => trim($data[38]), 'codigo' => '2034'],
            ['monto' => trim($data[39]), 'codigo' => '2035'],
            ['monto' => trim($data[40]), 'codigo' => '6027'],
            ['monto' => trim($data[41]), 'codigo' => '0006'],
            ['monto' => trim($data[42]), 'codigo' => '2033'],
            ['monto' => trim($data[43]), 'codigo' => '0002'],
            ['monto' => trim($data[44]), 'codigo' => '1202'],
            ['monto' => trim($data[45]), 'codigo' => '1201'],
            ['monto' => trim($data[46]), 'codigo' => '1200'],
            ['monto' => trim($data[47]), 'codigo' => '0004'],
            ['monto' => trim($data[48]), 'codigo' => '0109'],
            ['monto' => trim($data[49]), 'codigo' => '1145'],
            ['monto' => trim($data[50]), 'codigo' => '0054'],
            ['monto' => trim($data[51]), 'codigo' => '2002'],
            ['monto' => trim($data[52]), 'codigo' => '2003'],
            ['monto' => trim($data[53]), 'codigo' => '0011'],
            ['monto' => trim($data[54]), 'codigo' => '2004'],
            ['monto' => trim($data[55]), 'codigo' => '2005'],
            ['monto' => trim($data[56]), 'codigo' => '2006'],
            ['monto' => trim($data[57]), 'codigo' => '2007'],
            ['monto' => trim($data[58]), 'codigo' => '2008'],
            ['monto' => trim($data[59]), 'codigo' => '2009'],
            ['monto' => trim($data[60]), 'codigo' => '2010'],
            ['monto' => trim($data[61]), 'codigo' => '2011'],
            ['monto' => trim($data[62]), 'codigo' => '2012'],
            ['monto' => trim($data[63]), 'codigo' => '2013'],
            ['monto' => trim($data[64]), 'codigo' => '2014'],
            ['monto' => trim($data[65]), 'codigo' => '2015'],
            ['monto' => trim($data[66]), 'codigo' => '2016'],
            ['monto' => trim($data[67]), 'codigo' => '2017'],
            ['monto' => trim($data[68]), 'codigo' => '2018'],
            ['monto' => trim($data[69]), 'codigo' => '2019'],
            ['monto' => trim($data[70]), 'codigo' => '2020'],
            ['monto' => trim($data[71]), 'codigo' => '2021'],
            ['monto' => trim($data[72]), 'codigo' => '2022'],
            ['monto' => trim($data[73]), 'codigo' => '2023'],
            ['monto' => trim($data[74]), 'codigo' => '2024'],
            ['monto' => trim($data[75]), 'codigo' => '2025'],
            ['monto' => trim($data[76]), 'codigo' => '2026'],
            ['monto' => trim($data[77]), 'codigo' => '2027'],
            ['monto' => trim($data[78]), 'codigo' => '2028'],
            ['monto' => trim($data[79]), 'codigo' => '2029'],
            ['monto' => trim($data[80]), 'codigo' => '2030'],
            ['monto' => trim($data[81]), 'codigo' => '2031'],
            ['monto' => trim($data[82]), 'codigo' => '0025'],
            ['monto' => trim($data[83]), 'codigo' => '2036'],
            ['monto' => trim($data[84]), 'codigo' => '2037'],
            ['monto' => trim($data[85]), 'codigo' => '2038'],
            ['monto' => trim($data[86]), 'codigo' => '2039'],
            ['monto' => trim($data[87]), 'codigo' => '2040'],
            ['monto' => trim($data[88]), 'codigo' => '2041'],
            ['monto' => trim($data[89]), 'codigo' => '2042'],
            ['monto' => trim($data[90]), 'codigo' => '2043'],
            ['monto' => trim($data[91]), 'codigo' => '2044'],
            ['monto' => trim($data[92]), 'codigo' => '1208'],
            ['monto' => trim($data[93]), 'codigo' => '1203'],
        ];

        foreach ($conceptos as $concepto) {
            if ($concepto['monto'] !== "" || $concepto['monto'] > 0) {
                if($concepto['codigo']=='1208' || $concepto['codigo']=='1203'){
                    $clasificador_fin = 10;
                }else{
                    $clasificador_fin = $clasificador_id;
                }
                Planillaconceptos::create([
                    'pll_id_monto' => $concepto['monto'],
                    'concepto_cod_concepto' => $concepto['codigo'],
                    'clasificador_idclasificador' => $clasificador_fin,
                    'meta_m_cod_meta' => $meta_m_cod_meta,
                    'detalle_planilla_cod_detalle_planilla' => $cod_detalle_planilla,
                ]);
            }
        }

        // $honorario = trim($data[30]);

        // if($honorario<>""){
        //     Planillaconceptos::create([
        //     'pll_id_monto' => $honorario,
        //     'concepto_cod_concepto' => '0101' ,
        //     'clasificador_idclasificador' => $clasificador_id,
        //     'meta_m_cod_meta' => $meta_m_cod_meta,
        //     'detalle_planilla_cod_detalle_planilla' => $cod_detalle_planilla,
        // ]);
        // }

        // $rem_principal = trim($data[31]);

        // if($rem_principal<>""){
        //     Planillaconceptos::create([
        //     'pll_id_monto' => $rem_principal,
        //     'concepto_cod_concepto' => '0047',
        //     'clasificador_idclasificador' => $clasificador_id,
        //     'meta_m_cod_meta' => $meta_m_cod_meta,
        //     'detalle_planilla_cod_detalle_planilla' => $cod_detalle_planilla,
        // ]);
        // }

        // $asig_familiar = trim($data[32]);

        // if($asig_familiar<>""){
        //     Planillaconceptos::create([
        //     'pll_id_monto' => $asig_familiar,
        //     'concepto_cod_concepto' => '0184',
        //     'clasificador_idclasificador' => $clasificador_id,
        //     'meta_m_cod_meta' => $meta_m_cod_meta,
        //     'detalle_planilla_cod_detalle_planilla' => $cod_detalle_planilla,
        // ]);
        // }

        // $ds311 = trim($data[33]);

        // if($ds311<>""){
        //     Planillaconceptos::create([
        //     'pll_id_monto' => $ds311,
        //     'concepto_cod_concepto' => '0103',
        //     'clasificador_idclasificador' => $clasificador_id,
        //     'meta_m_cod_meta' => $meta_m_cod_meta,
        //     'detalle_planilla_cod_detalle_planilla' => $cod_detalle_planilla,
        // ]);
        // }
        

// ds311-2022-ef
// ds313-2023-ef
// complemento subsidio
// reintegros afecto
// reintegro no afecto
// gratificacion
// bonificacion extraordinaria
// bonificacion escolar
// impuesto a la renta 4ta cat.
// quinta categoria
// dl 19990 snp
// d.l. 25897 afp - aporte obligatorio
// d.l. 25897 afp - prima de seguros
// d.l. 25897 afp - comision flujo/mixta
// descuento judicial
// licencia automatica
// inasistencias
// tardanzas
// esvida
// desc. capac.
// eps pacifico
// banco comercio
// mafre peru vida
// scotiabank
// credito navarrete
// credito tai loy s.a
// coop san miguel
// coop serfinco
// sutsa inia
// seguros rimac
// sutsa inia nacional
// coop santo domingo
// coop san jose
// productos agropecuarios
// colegio ingenieros
// caja huancayo
// coop dos de mayo
// canasta navideña
// finantel
// pronavidad
// caja maynas
// coop la coopal
// caja arequipa
// fams
// devolucion de encargo
// "descuento 
// prestamo sutsa inia"
// "circo
// montecarlo"
// "circo
// ucrania"
// interseguro
// aguinaldo
// calidad visual sac
// banco pichincha
// reversion al tesoro
// pago indebido
// caja mun cusco
// aporte solidario cierre conv colectivo
// caja tacna
// "banco
// gnb"
// serfusa
// aporte eps
// aporte de essalud


        //  //Planilla MCPP
        // $pm_anio=trim($data[1]);
        // $pm_mes=trim($data[2]);
        // $pm_tipoplanilla=trim($data[3]);
        // $pm_claseplanilla=trim($data[4]);
        // $pm_correlativo=str_pad(trim($data[5]),4, "0", STR_PAD_LEFT);
        // $pm_ticket=trim($data[6]);
        // $pm_montoneto=trim($data[12]);
        // $pm_banco=trim($data[13]);
        // $pm_cuenta=trim($data[15]);

        // $padron_personas = Padronpersona::where('pp_num_doc', $pp_num_doc)->first();
        // $idpadron_persona = $padron_personas->pp_id;

        // $padron_personas_pp_id= $idpadron_persona;

        // // // Insertar o actualizar datos utilizando el model binding de Laravel

        // Planillamcpp::firstOrCreate(
        //     ['padron_personas_pp_id' => $padron_personas_pp_id,'expediente_documento_ed_id' => $expediente_documento],
        //     [
        //         'pm_anio' => $pm_anio,
        //         'pm_mes' => $pm_mes,
        //         'pm_tipoplanilla' => $pm_tipoplanilla,
        //         'pm_claseplanilla' => $pm_claseplanilla,
        //         'pm_correlativo' => $pm_correlativo,
        //         'pm_ticket' => $pm_ticket,
        //         'pm_montoneto' => $pm_montoneto,
        //         'pm_banco' => $pm_banco,
        //         'pm_cuenta' => $pm_cuenta,
        //         'padron_personas_pp_id' => $padron_personas_pp_id,
        //         'expediente_documento_ed_id' => $expediente_documento
        //     ]
        //     );
    }
}
