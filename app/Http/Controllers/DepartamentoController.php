<?php

namespace App\Http\Controllers;

use App\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if ($buscar==''){
            $departamentos=Departamento::orderBy('dep_departamento','asc')->paginate(10);
        }
        else
        {
            $departamentos=Departamento::where($criterio,'like','%'.$buscar.'%')->orderBy('dep_departamento','asc')->paginate(10);
        }

        return[
            'pagination' => [

                'total'         =>$departamentos->total(),
                'current_page'  =>$departamentos->currentPage(),
                'per_page'      =>$departamentos->perPage(),
                'last_page'     =>$departamentos->lastPage(),
                'from'          =>$departamentos->firstItem(),
                'to'            =>$departamentos->lastItem(),
            ],
            'departamentos'=>$departamentos
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'cod_departamento'=>'required|digits:2',
            'dep_departamento'=>'required',
        ];

        $messages = [
            'cod_departamento.required'=>'Ingresar Codigo',
            'cod_departamento.digits'=>'Numeros 2 digitos',
            'dep_departamento.required'=>'Ingresar Tipo de Documento',
        ];

        $this->validate($request,$rules,$messages);

        //*Guardar Datos en la tabla
        $departamento=new Departamento();
        $departamento->cod_departamento=$request->cod_departamento;
        $departamento->dep_departamento=$request->dep_departamento;
        $departamento->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'cod_departamento'=>'required|digits:2',
            'dep_departamento'=>'required',
        ];

        $messages = [
            'cod_departamento.required'=>'Ingresar Codigo',
            'cod_departamento.digits'=>'Numeros 2 digitos',
            'dep_departamento.required'=>'Ingresar Tipo de Documento',
        ];

        $this->validate($request,$rules,$messages);

        //*Guardar Datos en la tabla
        $departamento= Departamento::findOrFail($request->cod_departamento);
        $departamento->cod_departamento=$request->cod_departamento;
        $departamento->dep_departamento=$request->dep_departamento;
        $departamento->save();
    }

    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        
        $departamento= Departamento::find($request->cod_departamento);
        $departamento->delete();
    }

    public function selectDepartamento(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $departamento = Departamento::select('cod_departamento','dep_departamento')->orderBy('dep_departamento','asc')->get();
        return ['departamento'=>$departamento];
    }

}
