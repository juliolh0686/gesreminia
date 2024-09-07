<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;

class CargoController extends Controller
{
    public function selectCargo(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $cargo = Cargo::select('cod_cargo','c_abrev_cargo')->orderBy('c_abrev_cargo','asc')->get();
        return ['cargo'=>$cargo];
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $cargo= Cargo::orderBy('c_nomcar','asc')->paginate(5);
        }
        else
        {
            $cargo = Cargo::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('c_nomcar','asc')
                    ->paginate(5);
        }

        
        return [
            'pagination' =>[
                'total'         => $cargo->total(),
                'current_page'  => $cargo->currentPage(),
                'per_page'      => $cargo->perpage(),
                'last_page'     => $cargo->lastPage(),
                'from'          => $cargo->firstItem(),
                'to'            => $cargo->lastItem(),
            ],
            'cargo' => $cargo
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        // $rules = [
        //     'cod_sexo'=>'required|digits:2',
        //     's_sexo'=>'required',
        // ];

        // $messages = [
        //     'cod_sexo.required'=>'Ingresar Codigo',
        //     'cod_sexo.digits'=>'Numeros 2 digitos',
        //     's_sexo.required'=>'Ingresar Sexo',
        // ];

        //$this->validate($request,$rules,$messages);

        //*Guardar Datos en la tabla
        $cargo= new Cargo();
        $cargo->c_nomcar = $request->c_nomcar;
        $cargo->c_abrev_cargo = $request->c_abrev_cargo;
        $cargo->save();

    }

    public function update(Request $request)
    {
        // if (!$request->ajax()) return redirect('/');

        // //--Validacion del Formulario

        // $rules = [
        //     'cod_sexo'=>'required|digits:2',
        //     's_sexo'=>'required',
        // ];

        // $messages = [
        //     'cod_sexo.required'=>'Ingresar Codigo',
        //     'cod_sexo.digits'=>'Numeros 2 digitos',
        //     's_sexo.required'=>'Ingresar Sexo',
        // ];

        // $this->validate($request,$rules,$messages);

        //*Actualizar Datos en la tabla

        $cargo= Cargo::findOrFail($request->cod_cargo);
        $cargo->c_nomcar = $request->c_nomcar;
        $cargo->c_abrev_cargo = $request->c_abrev_cargo;
        $cargo->save();

    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $cargo= Cargo::find($request->cod_cargo);
        $cargo->delete();
    }

}
