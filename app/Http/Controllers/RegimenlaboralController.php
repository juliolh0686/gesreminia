<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Regimenlaboral;

class RegimenlaboralController extends Controller
{
    public function selectRegimenlaboral(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $regimenlaboral = Regimenlaboral::select('cod_regimen_laboral','rl_regimen_laboral')->orderBy('cod_regimen_laboral','asc')->get();
        return ['regimenlaboral'=>$regimenlaboral];
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $reglaboral= Regimenlaboral::orderBy('rl_regimen_laboral','asc')->paginate(5);
        }
        else
        {
            $reglaboral = Regimenlaboral::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('rl_regimen_laboral','asc')
                    ->paginate(5);
        }

        
        return [
            'pagination' =>[
                'total'         => $reglaboral->total(),
                'current_page'  => $reglaboral->currentPage(),
                'per_page'      => $reglaboral->perpage(),
                'last_page'     => $reglaboral->lastPage(),
                'from'          => $reglaboral->firstItem(),
                'to'            => $reglaboral->lastItem(),
            ],
            'reglaboral' => $reglaboral
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

        // $this->validate($request,$rules,$messages);

        //*Guardar Datos en la tabla
        $reglaboral= new Regimenlaboral();
        $reglaboral->cod_regimen_laboral= $request->cod_regimen_laboral;
        $reglaboral->rl_regimen_laboral= $request->rl_regimen_laboral;
        $reglaboral->save();

    }

    public function update(Request $request)
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

        // $this->validate($request,$rules,$messages);

        //*Actualizar Datos en la tabla

        $reglaboral=Regimenlaboral::findOrFail($request->cod_regimen_laboral);
        $reglaboral->rl_regimen_laboral= $request->rl_regimen_laboral;
        $reglaboral->save();

    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $reglaboral= Regimenlaboral::find($request->cod_regimen_laboral);
        $reglaboral->delete();
    }
}
