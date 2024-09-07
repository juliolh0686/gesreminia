<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class PersonalController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $b_numdoc= $request->b_numdoc;
        $b_apaterno = $request->b_apaterno;
        $b_amaterno = $request->b_amaterno;
        $b_nombres = $request->b_nombres;
       
        $personal=Personal::join('distritos','personal.distrito_cod_distrito','=','distritos.cod_distrito')
        ->join('provincias','distritos.provincia_cod_provincia','=','provincias.cod_provincia')
        ->join('departamentos','provincias.departamento_cod_departamento','=','departamentos.cod_departamento')
        ->join('admin_pensiones','personal.admin_pension_cod_admin_pension','=','admin_pensiones.cod_admin_pension')
        ->join('reg_pensiones','admin_pensiones.regimen_pension_cod_regimen_pension','=','reg_pensiones.cod_regimen_pension')
        ->where('p_num_doc','like','%'.$b_numdoc.'%')
        ->where('p_a_paterno','like','%'.$b_apaterno.'%')
        ->where('p_a_materno','like','%'.$b_amaterno.'%')
        ->where('p_nombres','like','%'.$b_nombres.'%')
        ->orderBy('p_a_paterno','desc')
        ->paginate(10);
        
        return [
            'pagination' =>[
                'total'         => $personal->total(),
                'current_page'  => $personal->currentPage(),
                'per_page'      => $personal->perpage(),
                'last_page'     => $personal->lastPage(),
                'from'          => $personal->firstItem(),
                'to'            => $personal->lastItem(),
            ],
            'personal' => $personal
        ];
    }

    public function store(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        //Validacion del Formulario

        $rules = [
            'p_a_paterno'=>'required',
            'p_a_materno'=>'required',
            'p_nombres'=>'required',
            'p_fech_nac'=>'required|date_format:d/m/Y',
            'tipo_documento_cod_tipo_documento'=>'required|size:2',
            'p_num_doc'=>'numeric|required|digits_between:8,12',
            'sexo_cod_sexo'=>'required|size:2',
            'estado_civil_cod_estado_civil'=>'required|size:2',
            'p_ruc'=>'required|size:11',
            'distrito_cod_distrito'=>'required|size:6',
            'p_correo'=>'email',
            'p_telefono'=>'digits:7',
            'p_celular'=>'digits:9',
            'admin_pension_cod_admin_pension'=>'required|size:2',
            'banco_cod_banco'=>'required|size:3',
        ];

        $messages = [
            'p_a_paterno.required'=>'Ingresar Apellido Paterno',
            'p_a_materno.required'=>'Ingresar Apellido Materno',
            'p_nombres.required'=>'Ingresar Nombres',
            'p_fech_nac.required'=>'Ingresar Fecha de Nacimiento',
            'p_fech_nac.date_format'=>'Debe un Valor Tipo Fecha',
            'tipo_documento_cod_tipo_documento.size'=>'Debe Seleccionar un valor',
            'p_num_doc.required'=>'debe ingresar un valor',
            'p_num_doc.numeric'=>'solo se permite el ingreso de numeros',
            'p_num_doc.digits_between'=>'Deb ingresar de 8 a 12 digitos',
            'sexo_cod_sexo.size'=>'debe Seleccionar un valor',
            'estado_civil_cod_estado_civil.size'=>'debe Seleccionar un valor',
            'p_ruc.required'=>'debe ingresar RUC',
            'p_ruc.size'=>'El RUC contiene 11 Digitos',
            'distrito_cod_distrito.size'=>'seleccionar un Distrito',
            'p_correo.email'=>'Debe ingresar un Correo Electronico',
            'p_telefono.digits'=>'7 Digitos',
            'p_celular.digits'=>'9 Digitos',
            'admin_pension_cod_admin_pension.size'=>'Seleccionar un valor',
            'banco_cod_banco.size'=>'debe seleccionar un valor',
        ];

        $this->validate($request,$rules,$messages);

        //Fin validacion del formulario

        if ($request->variablefoto==1){

            $exploded = explode(',',$request->fotopersonal);

            $decoded = base64_decode($exploded[1]);
    
            //if(str_contains($exploded[0],'jpeg')){
                $extension='jpg';
            //} 
            //else
            //{
            //    $extension='png';
            //}
    
            $fileName=str_random().'.'.$extension;

            $path = public_path().'/fotos/'.$fileName;
            
            file_put_contents($path,$decoded);

        }else{
            $fileName=substr($request->fotopersonal, -(strlen($request->fotopersonal)-6));
        }


       // $fecha_nac = date('Y-m-d', strtotime($request->p_fech_nac));
       // $fecha_afi = date('Y-m-d', strtotime($request->p_fech_afiliacion));

        $mifecha = explode("/", $request->p_fech_nac);
        $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
        $fecha_nac= $lafecha;

        if ($request->p_fech_afiliacion==""){
            $fecha_afi="";
        }else{
            $mifecha = explode("/", $request->p_fech_afiliacion);
            $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
            $fecha_afi= $lafecha;
        }

        $personal= new Personal();
        $personal->cod_personal = $request->cod_personal;
        $personal->tipo_documento_cod_tipo_documento = $request->tipo_documento_cod_tipo_documento;
        $personal->p_num_doc = $request->p_num_doc;
        $personal->p_a_paterno = $request->p_a_paterno;
        $personal->p_a_materno = $request->p_a_materno;
        $personal->p_nombres = $request->p_nombres;
        $personal->foto = $fileName;
        $personal->p_fech_nac = $fecha_nac;
        $personal->sexo_cod_sexo = $request->sexo_cod_sexo;
        $personal->estado_civil_cod_estado_civil = $request->estado_civil_cod_estado_civil;
        $personal->p_ruc = $request->p_ruc;
        $personal->distrito_cod_distrito = $request->distrito_cod_distrito;
        $personal->p_direccion = $request->p_direccion;
        $personal->p_correo = $request->p_correo;
        $personal->p_telefono = $request->p_telefono;
        $personal->p_celular = $request->p_celular;
        $personal->p_observacion = $request->p_observacion;
        $personal->admin_pension_cod_admin_pension = $request->admin_pension_cod_admin_pension;
        $personal->p_cuspp = $request->p_cuspp;
        if($fecha_afi<>""){
            $personal->p_fech_afiliacion = $fecha_afi;
        }else{
            $personal->p_fech_afiliacion = null;
        }
        $personal->banco_cod_banco = $request->banco_cod_banco;
        $personal->p_num_cuenta = $request->p_num_cuenta;
        $personal->save();
    }

 
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

       //Validacion del Formulario

       $rules = [
        'p_a_paterno'=>'required',
        'p_a_materno'=>'required',
        'p_nombres'=>'required',
        'p_fech_nac'=>'required|date_format:d/m/Y',
        'tipo_documento_cod_tipo_documento'=>'required|size:2',
        'p_num_doc'=>'numeric|required|digits_between:8,12',
        'sexo_cod_sexo'=>'required|size:2',
        'estado_civil_cod_estado_civil'=>'required|size:2',
        'p_ruc'=>'required|size:11',
        'distrito_cod_distrito'=>'required|size:6',
        'p_correo'=>'email',
        'p_telefono'=>'digits:7',
        'p_celular'=>'digits:9',
        'admin_pension_cod_admin_pension'=>'required|size:2',
        'banco_cod_banco'=>'required|size:3',
    ];

    $messages = [
        'p_a_paterno.required'=>'Ingresar Apellido Paterno',
        'p_a_materno.required'=>'Ingresar Apellido Materno',
        'p_nombres.required'=>'Ingresar Nombres',
        'p_fech_nac.required'=>'Ingresar Fecha de Nacimiento',
        'p_fech_nac.date_format'=>'Debe un Valor Tipo Fecha',
        'tipo_documento_cod_tipo_documento.size'=>'Debe Seleccionar un valor',
        'p_num_doc.required'=>'debe ingresar un valor',
        'p_num_doc.numeric'=>'solo se permite el ingreso de numeros',
        'p_num_doc.digits_between'=>'Deb ingresar de 8 a 12 digitos',
        'sexo_cod_sexo.size'=>'debe Seleccionar un valor',
        'estado_civil_cod_estado_civil.size'=>'debe Seleccionar un valor',
        'p_ruc.required'=>'debe ingresar RUC',
        'p_ruc.size'=>'El RUC contiene 11 Digitos',
        'distrito_cod_distrito.size'=>'seleccionar un Distrito',
        'p_correo.email'=>'Debe ingresar un Correo Electronico',
        'p_telefono.digits'=>'7 Digitos',
        'p_celular.digits'=>'9 Digitos',
        'admin_pension_cod_admin_pension.size'=>'Seleccionar un valor',
        'banco_cod_banco.size'=>'debe seleccionar un valor',
    ];

    $this->validate($request,$rules,$messages);

    //Fin validacion del formulario


        if ($request->variablefoto==1){
            $exploded = explode(',',$request->fotopersonal);

            $decoded = base64_decode($exploded[1]);
    
            //if(str_contains($exploded[0],'jpeg')){
                $extension='jpg';
           // } 
            //else
            //{
            //    $extension='png';
            //}
    
            $fileName=str_random().'.'.$extension;

            $path = public_path().'/fotos/'.$fileName;
            
            file_put_contents($path,$decoded);
        }else{
            $fileName=substr($request->fotopersonal, -(strlen($request->fotopersonal)-6));
        }

        //$fecha_nac = date('Y-m-d', strtotime($request->p_fech_nac));
        //$fecha_afi = date('Y-m-d', strtotime($request->p_fech_afiliacion));

        $mifecha = explode("/", $request->p_fech_nac);
        $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
        $fecha_nac= $lafecha;

        if ($request->p_fech_afiliacion==""){
            $fecha_afi=null;
        }else{
            $mifecha = explode("/", $request->p_fech_afiliacion);
            $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
            $fecha_afi= $lafecha;
        }

        

        $personal= Personal::findOrFail($request->cod_personal);
        $personal->tipo_documento_cod_tipo_documento = $request->tipo_documento_cod_tipo_documento;
        $personal->p_num_doc = $request->p_num_doc;
        $personal->p_a_paterno = $request->p_a_paterno;
        $personal->p_a_materno = $request->p_a_materno;
        $personal->p_nombres = $request->p_nombres;
        $personal->foto = $fileName;
        $personal->p_fech_nac = $fecha_nac;
        $personal->sexo_cod_sexo = $request->sexo_cod_sexo;
        $personal->estado_civil_cod_estado_civil = $request->estado_civil_cod_estado_civil;
        $personal->p_ruc = $request->p_ruc;
        $personal->distrito_cod_distrito = $request->distrito_cod_distrito;
        $personal->p_direccion = $request->p_direccion;
        $personal->p_correo = $request->p_correo;
        $personal->p_telefono = $request->p_telefono;
        $personal->p_celular = $request->p_celular;
        $personal->p_observacion = $request->p_observacion;
        $personal->admin_pension_cod_admin_pension = $request->admin_pension_cod_admin_pension;
        $personal->p_cuspp = $request->p_cuspp;
        //if($fecha_afi<>""){
            $personal->p_fech_afiliacion = $fecha_afi;
        //}else{
            //$personal->p_fech_afiliacion = null;
        //}
        $personal->banco_cod_banco = $request->banco_cod_banco;
        $personal->p_num_cuenta = $request->p_num_cuenta;
        $personal->save();
    }


    public function Reportepersonal(Request $request)
    {
        $personal = Personal::all();
        $pdf = \PDF::loadView('pdf.rep_personal', compact('personal'));
        $pdf->setPaper('A3', 'landscape');
        return $pdf->stream('archivo.pdf');
    }

    public function Reportepersonalexcel(Request $request)
    {

        Excel::create('Reporte Personal', function($excel) {
            //Hoja excel
            $excel->sheet('Personal',function($sheet){
                //Hoja
                $sheet->setFontFamily('Times New Roman');
                //Header
                $sheet->mergeCells('A1:W1');
                $sheet->cells('A1:W1', function($cells) {
                    $cells->setFontSize(16);
                    $cells->setFontWeight('bold');
                    $cells->setBorder('thin','thin','thin','thin');
                });

                $sheet->cells('A2:W2', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setBorder('thin','thin','thin','thin');
                });

                $sheet->setColumnFormat(array(
                    'A' => '@',
                    'B' => '@',
                    'C' => '@',
                    'D' => '@',
                    'E' => '@',
                    'F' => '@',
                    'G' => 'dd/mm/yyyy',
                    'H' => '@',
                    'I' => '@',
                    'J' => '@',
                    'K' => '@',
                    'L' => '@',
                    'M' => '@',
                    'N' => '@',
                    'O' => '@',
                    'P' => '@',
                    'Q' => '@',
                    'R' => '@',
                    'S' => 'dd/mm/yyyy',
                    'T' => '@',
                    'U' => '@',
                ));

                $sheet->row(1, ['Reporte de Personal-UGEL Ventanilla']);
                $sheet->row(2, ['Cod. Personal','Cod. Documento','Documento','A_Paterno','A_Materno','Nombres',
                'F_Nacimiento','Sexo','Cod_Est_Civil','RUC','Cod_Distrito','Dirección','Correo','Telefono','Celuler',
                'Observación','Adm_Pensión','CUSPP','F_Afiliación','Cod_Banco','Cuenta de Ahorros','F_Creación','F_Modificación']);
                //Data
                $personal=Personal::all();
                $data=[];
                foreach ($personal as $personal){
                    $row = [];
                    $row[0] = $personal->cod_personal;
                    $row[1] = $personal->tipo_documento_cod_tipo_documento;
                    $row[2] = $personal->p_num_doc;
                    $row[3] = $personal->p_a_paterno	;
                    $row[4] = $personal->p_a_materno	;
                    $row[5] = $personal->p_nombres;
                    $row[6] = date("d-m-Y", strtotime($personal->p_fech_nac));
                    $row[7] = $personal->sexo_cod_sexo;
                    $row[8] = $personal->estado_civil_cod_estado_civil;
                    $row[9] = $personal->p_ruc;
                    $row[10] = $personal->distrito_cod_distrito;
                    $row[11] = $personal->p_direccion;
                    $row[12] = $personal->p_correo;
                    $row[13] = $personal->p_telefono;
                    $row[14] = $personal->p_celular;
                    $row[15] = $personal->p_observacion;
                    $row[16] = $personal->admin_pension_cod_admin_pension;
                    $row[17] = $personal->p_cuspp;
                    $row[18] = $personal->p_fech_afiliacion;
                    $row[19] = $personal->banco_cod_banco;
                    $row[20] = $personal->p_num_cuenta;
                    $row[21] = $personal->created_at;
                    $row[22] = $personal->updated_at;
                    $data[]=$row;
                    $sheet->appendRow($row);
                }
            });

            
        
        })->download('xlsx');
        
        
        //return Excel::download(new PersonalExport, 'users.xlsx');
    }


}
