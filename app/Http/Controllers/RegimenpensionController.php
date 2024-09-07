<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Regimenpension;

class RegimenpensionController extends Controller
{

    public function selectRegimenpension(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $regimenpension = Regimenpension::select('cod_regimen_pension','rp_regimen_pension')->orderBy('cod_regimen_pension','asc')->get();
        return ['regimenpension'=>$regimenpension];
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $regimenpension= Regimenpension::orderBy('rp_regimen_pension','asc')->paginate(5);
        }
        else
        {
            $regimenpension = Regimenpension::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('rp_regimen_pension','asc')
                    ->paginate(5);
        }

        
        return [
            'pagination' =>[
                'total'         => $regimenpension->total(),
                'current_page'  => $regimenpension->currentPage(),
                'per_page'      => $regimenpension->perpage(),
                'last_page'     => $regimenpension->lastPage(),
                'from'          => $regimenpension->firstItem(),
                'to'            => $regimenpension->lastItem(),
            ],
            'regimenpension' => $regimenpension
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
        $regpen= new Regimenpension();
        $regpen->cod_regimen_pension = $request->cod_regimen_pension;
        $regpen->rp_regimen_pension = $request->rp_regimen_pension;
        $regpen->save();

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

        $sexo= Regimenpension::findOrFail($request->cod_regimen_pension);
        $sexo->rp_regimen_pension = $request->rp_regimen_pension;
        $sexo->save();

    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $regpen= Regimenpension::find($request->cod_regimen_pension);
        $regpen->delete();
    }


    
}
