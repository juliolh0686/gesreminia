<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;

class AreaController extends Controller
{
    public function selectArea(Request $request){
        
        if (!$request->ajax()) return redirect('/');
 
         $area = Area::select('a_cod_area','a_area')->orderBy('a_cod_area','asc')->get();
         return ['area'=>$area];
     }

     public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $area= Area::orderBy('a_area','asc')->paginate(5);
        }
        else
        {
            $area = Area::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('a_area','asc')
                    ->paginate(5);
        }

        
        return [
            'pagination' =>[
                'total'         => $area->total(),
                'current_page'  => $area->currentPage(),
                'per_page'      => $area->perpage(),
                'last_page'     => $area->lastPage(),
                'from'          => $area->firstItem(),
                'to'            => $area->lastItem(),
            ],
            'area' => $area
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
        $area= new Area();
        $area->a_cod_area = $request->a_cod_area;
        $area->a_area = $request->a_area;
        $area->a_abrev_area = $request->a_abrev_area;
        $area->save();

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

        $area=Area::findOrFail($request->a_cod_area);
        $area->a_area = $request->a_area;
        $area->a_abrev_area = $request->a_abrev_area;
        $area->save();

    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $area= Area::find($request->a_cod_area);
        $area->delete();
    }
}
