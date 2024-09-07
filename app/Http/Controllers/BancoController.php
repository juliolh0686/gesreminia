<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banco;

class BancoController extends Controller
{

    public function selectBanco(Request $request){
        
       if (!$request->ajax()) return redirect('/');

        $banco = Banco::select('cod_banco','b_banco')->orderBy('cod_banco','asc')->get();
        return ['banco'=>$banco];
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $banco= Banco::orderBy('b_banco','asc')->paginate(5);
        }
        else
        {
            $banco = Banco::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('b_banco','asc')
                    ->paginate(5);
        }

        
        return [
            'pagination' =>[
                'total'         => $banco->total(),
                'current_page'  => $banco->currentPage(),
                'per_page'      => $banco->perpage(),
                'last_page'     => $banco->lastPage(),
                'from'          => $banco->firstItem(),
                'to'            => $banco->lastItem(),
            ],
            'banco' => $banco
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
        $banco= new Banco();
        $banco->cod_banco = $request->cod_banco;
        $banco->b_banco = $request->b_banco;
        $banco->save();

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

        $banco=Banco::findOrFail($request->cod_banco);
        $banco->b_banco= $request->b_banco;
        $banco->save();

    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $banco= Banco::find($request->cod_banco);
        $banco->delete();
    }


}
