<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sexo;

class SexoController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $sexo= Sexo::orderBy('s_sexo','asc')->paginate(5);
        }
        else
        {
            $sexo = Sexo::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('s_sexo','asc')
                    ->paginate(5);
        }

        
        return [
            'pagination' =>[
                'total'         => $sexo->total(),
                'current_page'  => $sexo->currentPage(),
                'per_page'      => $sexo->perpage(),
                'last_page'     => $sexo->lastPage(),
                'from'          => $sexo->firstItem(),
                'to'            => $sexo->lastItem(),
            ],
            'sexo' => $sexo
        ];
    }


    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'cod_sexo'=>'required|digits:2',
            's_sexo'=>'required',
        ];

        $messages = [
            'cod_sexo.required'=>'Ingresar Codigo',
            'cod_sexo.digits'=>'Numeros 2 digitos',
            's_sexo.required'=>'Ingresar Sexo',
        ];

        $this->validate($request,$rules,$messages);

        //*Guardar Datos en la tabla
        $sexo= new Sexo();
        $sexo->cod_sexo = $request->cod_sexo;
        $sexo->s_sexo = $request->s_sexo;
        $sexo->save();

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'cod_sexo'=>'required|digits:2',
            's_sexo'=>'required',
        ];

        $messages = [
            'cod_sexo.required'=>'Ingresar Codigo',
            'cod_sexo.digits'=>'Numeros 2 digitos',
            's_sexo.required'=>'Ingresar Sexo',
        ];

        $this->validate($request,$rules,$messages);

        //*Actualizar Datos en la tabla

        $sexo= Sexo::findOrFail($request->cod_sexo);
        $sexo->s_sexo = $request->s_sexo;
        $sexo->save();

    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $sexo= Sexo::find($request->cod_sexo);
        $sexo->delete();
    }

    public function selectSexo(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $sexo = Sexo::select('cod_sexo','s_sexo')->orderBy('cod_sexo','asc')->get();
        return ['sexo'=>$sexo];
    }
    
}
