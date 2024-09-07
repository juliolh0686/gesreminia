<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia;

class ProvinciaController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $provincia= Provincia::join('departamentos','provincias.departamento_cod_departamento','=','departamentos.cod_departamento')
                                    ->orderBy('pro_provincia','asc')->paginate(10);
        }
        else
        {
            $provincia = Provincia::where($criterio,'like','%'.$buscar.'%')
                    ->join('departamentos','provincias.departamento_cod_departamento','=','departamentos.cod_departamento')
                    ->orderBy('pro_provincia','asc')
                    ->paginate(10);
        }

        
        return [
            'pagination' =>[
                'total'         => $provincia->total(),
                'current_page'  => $provincia->currentPage(),
                'per_page'      => $provincia->perpage(),
                'last_page'     => $provincia->lastPage(),
                'from'          => $provincia->firstItem(),
                'to'            => $provincia->lastItem(),
            ],
            'provincia' => $provincia
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        // $rules = [
        //     'cod_tipo_documento'=>'required|digits:2',
        //     'td_documento'=>'required',
        // ];

        // $messages = [
        //     'cod_tipo_documento.required'=>'Ingresar Codigo',
        //     'cod_tipo_documento.digits'=>'Numeros 2 digitos',
        //     'td_documento.required'=>'Ingresar Tipo de Documento',
        // ];

        // $this->validate($request,$rules,$messages);

        //*Guardar Datos en la tabla
        $provincia= new Provincia();
        $provincia->cod_provincia = $request->cod_provincia;
        $provincia->pro_provincia = $request->pro_provincia;
        $provincia->departamento_cod_departamento = $request->departamento_cod_departamento;
        $provincia->save();

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        // //--Validacion del Formulario

        // $rules = [
        //     'cod_tipo_documento'=>'required|digits:2',
        //     'td_documento'=>'required',
        // ];

        // $messages = [
        //     'cod_tipo_documento.required'=>'Ingresar Codigo',
        //     'cod_tipo_documento.digits'=>'Numeros 2 digitos',
        //     'td_documento.required'=>'Ingresar Tipo de Documento',
        // ];

        // $this->validate($request,$rules,$messages);

        //*Actualizar Datos en la tabla

        $provincia= Provincia::findOrFail($request->cod_provincia);
        $provincia->pro_provincia = $request->pro_provincia;
        $provincia->departamento_cod_departamento = $request->departamento_cod_departamento;
        $provincia->save();

    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $tipodoc= Provincia::find($request->cod_provincia);
        $tipodoc->delete();
    }

    public function selectProvincia(Request $request){
        
        //if (!$request->ajax()) return redirect('/');

        $iddepartamento= $request->iddepartamento;

        $provincia=Provincia::select('cod_provincia','pro_provincia')->where('departamento_cod_departamento','=',$iddepartamento)->orderBy('pro_provincia','asc')->get();
        return ['provincia'=>$provincia];
    }

}
