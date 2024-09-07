<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estadocivil;

class EstadocivilController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $estadocivil= Estadocivil::orderBy('ec_estado_civil','asc')->paginate(5);
        }
        else
        {
            $estadocivil = Estadocivil::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('ec_estado_civil','asc')
                    ->paginate(5);
        }

        
        return [
            'pagination' =>[
                'total'         => $estadocivil->total(),
                'current_page'  => $estadocivil->currentPage(),
                'per_page'      => $estadocivil->perpage(),
                'last_page'     => $estadocivil->lastPage(),
                'from'          => $estadocivil->firstItem(),
                'to'            => $estadocivil->lastItem(),
            ],
            'estadocivil' => $estadocivil
        ];
    }


    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'cod_estado_civil'=>'required|digits:2',
            'ec_estado_civil'=>'required',
        ];

        $messages = [
            'cod_estado_civil.required'=>'Ingresar Codigo',
            'cod_estado_civil.digits'=>'Numeros 2 digitos',
            'ec_estado_civil.required'=>'Ingresar Sexo',
        ];

        $this->validate($request,$rules,$messages);

        //*Guardar Datos en la tabla
        $estadocivil= new Estadocivil();
        $estadocivil->cod_estado_civil = $request->cod_estado_civil;
        $estadocivil->ec_estado_civil = $request->ec_estado_civil;
        $estadocivil->save();

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'cod_estado_civil'=>'required|digits:2',
            'ec_estado_civil'=>'required',
        ];

        $messages = [
            'cod_estado_civil.required'=>'Ingresar Codigo',
            'cod_estado_civil.digits'=>'Numeros 2 digitos',
            'ec_estado_civil.required'=>'Ingresar Sexo',
        ];

        $this->validate($request,$rules,$messages);

        //*Actualizar Datos en la tabla

        $estadocivil= Estadocivil::findOrFail($request->cod_estado_civil);
        $estadocivil->ec_estado_civil = $request->ec_estado_civil;
        $estadocivil->save();

    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $estadocivil= Estadocivil::find($request->cod_estado_civil);
        $estadocivil->delete();
    }


    public function selectEstadocivil(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $estadocivil = Estadocivil::select('cod_estado_civil','ec_estado_civil')->orderBy('cod_estado_civil','asc')->get();
        return ['estadocivil'=>$estadocivil];
    }

}
