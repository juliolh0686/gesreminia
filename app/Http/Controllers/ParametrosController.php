<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parametros;

class ParametrosController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $parametros= Parametros::orderBy('pm_id','desc')->paginate(5);
        }
        else
        {
            $parametros = Parametros::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('pm_id','desc')
                    ->paginate(5);
        }

        
        return [
            'pagination' =>[
                'total'         => $parametros->total(),
                'current_page'  => $parametros->currentPage(),
                'per_page'      => $parametros->perpage(),
                'last_page'     => $parametros->lastPage(),
                'from'          => $parametros->firstItem(),
                'to'            => $parametros->lastItem(),
            ],
            'parametros' => $parametros
        ];
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'pm_nombre'=>'required',
            'pm_nombre_abrev'=>'required',
            'pm_monto'=>'required|numeric',
            'pm_porcentaje'=>'required|numeric',
        ];

        $messages = [
            'pm_nombre.required'=>'Ingresar Nombre',
            'pm_nombre_abrev.required'=>'Ingresar Abreviatura',
            'pm_monto.required'=>'Ingresar Monto',
            'pm_monto.numeric'=>'Ingresar Numeros',
            'pm_porcentaje.required'=>'Ingresar porcentaje',
            'pm_porcentaje.numeric'=>'Ingresar Numeros',
        ];

        $this->validate($request,$rules,$messages);

        //*Guardar Datos en la tabla
        $parametros= new Parametros();
        $parametros->pm_nombre = $request->pm_nombre;
        $parametros->pm_nombre_abrev = $request->pm_nombre_abrev;
        $parametros->pm_monto = $request->pm_monto;
        $parametros->pm_porcentaje = $request->pm_porcentaje;
        $parametros->pm_descripcion = $request->pm_descripcion;
        $parametros->save();

    }

  
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'pm_nombre'=>'required',
            'pm_nombre_abrev'=>'required',
            'pm_monto'=>'required|numeric',
            'pm_porcentaje'=>'required|numeric',
        ];

        $messages = [
            'pm_nombre.required'=>'Ingresar Nombre',
            'pm_nombre_abrev.required'=>'Ingresar Abreviatura',
            'pm_monto.required'=>'Ingresar Monto',
            'pm_monto.numeric'=>'Ingresar Numeros',
            'pm_porcentaje.required'=>'Ingresar porcentaje',
            'pm_porcentaje.numeric'=>'Ingresar Numeros',
        ];

        $this->validate($request,$rules,$messages);

        //*Actualizar Datos en la tabla

        $parametros= Parametros::findOrFail($request->pm_id);
        $parametros->pm_nombre = $request->pm_nombre;
        $parametros->pm_nombre_abrev = $request->pm_nombre_abrev;
        $parametros->pm_monto = $request->pm_monto;
        $parametros->pm_porcentaje = $request->pm_porcentaje;
        $parametros->pm_descripcion = $request->pm_descripcion;
        $parametros->save();

    }

    
    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $parametros= Parametros::find($request->pm_id);
        $parametros->delete();
    }
}
