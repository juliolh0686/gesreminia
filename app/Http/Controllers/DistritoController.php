<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Distrito;

class DistritoController extends Controller
{

  public function index(Request $request)
  {
      if (!$request->ajax()) return redirect('/');

      $buscar= $request->buscar;
      $criterio = $request->criterio;

      if($buscar==''){

        $distritos = Distrito::join('provincias','distritos.provincia_cod_provincia','=','provincias.cod_provincia')
          ->join('departamentos','provincias.departamento_cod_departamento','=','departamentos.cod_departamento')
          ->orderBy('dis_distrito','asc')->paginate(10);

      }
      else
      {
          $distritos = Distrito::join('provincias','distritos.provincia_cod_provincia','=','provincias.cod_provincia')
            ->join('departamentos','provincias.departamento_cod_departamento','=','departamentos.cod_departamento')
            ->where($criterio,'like','%'.$buscar.'%')
            ->orderBy('dis_distrito','asc')
            ->paginate(10);
      }

      
      return [
          'pagination' =>[
              'total'         => $distritos->total(),
              'current_page'  => $distritos->currentPage(),
              'per_page'      => $distritos->perpage(),
              'last_page'     => $distritos->lastPage(),
              'from'          => $distritos->firstItem(),
              'to'            => $distritos->lastItem(),
          ],
          'distritos' => $distritos
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
      $distrito= new Distrito();
      $distrito->cod_distrito = $request->cod_distrito;
      $distrito->dis_distrito = $request->dis_distrito;
      $distrito->provincia_cod_provincia = $request->provincia_cod_provincia;
      $distrito->save();

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

      $distrito= Distrito::findOrFail($request->cod_distrito);
      $distrito->dis_distrito = $request->dis_distrito;
      $distrito->provincia_cod_provincia = $request->provincia_cod_provincia;
      $distrito->save();

  }

  public function destroy(Request $request)
  {
      if (!$request->ajax()) return redirect('/');
      
      $distrito= Distrito::find($request->cod_distrito);
      $distrito->delete();
  }


    public function selectDistrito(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $idprovincia= $request->idprovincia;

        $distrito=Distrito::select('cod_distrito','dis_distrito')->where('provincia_cod_provincia','=',$idprovincia)->orderBy('dis_distrito','asc')->get();
        return ['distrito'=>$distrito];
    }

}
