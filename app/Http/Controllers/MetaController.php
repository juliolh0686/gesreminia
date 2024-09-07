<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meta;

class MetaController extends Controller
{
    public function selectMeta(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $meta = Meta::select('m_cod_meta','m_anio_per','meta','descripcion')->orderBy('m_anio_per','desc')->get();
        return ['meta'=>$meta];
    }

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $meta= Meta::orderBy('m_anio_per','asc')->paginate(10);
        }
        else
        {
            $meta = Meta::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('m_anio_per','asc')
                    ->paginate(10);
        }

        
        return [
            'pagination' =>[
                'total'         => $meta->total(),
                'current_page'  => $meta->currentPage(),
                'per_page'      => $meta->perpage(),
                'last_page'     => $meta->lastPage(),
                'from'          => $meta->firstItem(),
                'to'            => $meta->lastItem(),
            ],
            'meta' => $meta
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
        $meta= new Meta();
        $meta->m_anio_per = $request->m_anio_per;
        $meta->meta = $request->meta;
        $meta->descripcion = $request->descripcion;
        $meta->save();

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

        $meta= Meta::findOrFail($request->m_cod_meta);
        $meta->m_anio_per = $request->m_anio_per;
        $meta->meta = $request->meta;
        $meta->descripcion = $request->descripcion;
        $meta->save();

    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $meta=Meta::find($request->m_cod_meta);
        $meta->delete();
    }
}
