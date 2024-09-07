<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipodocumento;

class TipodocumentoController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $tipodoc= Tipodocumento::orderBy('cod_tipo_documento','asc')->paginate(5);
        }
        else
        {
            $tipodoc = Tipodocumento::where($criterio,'like','%'.$buscar.'%')
                    ->orderBy('cod_tipo_documento','asc')
                    ->paginate(5);
        }

        
        return [
            'pagination' =>[
                'total'         => $tipodoc->total(),
                'current_page'  => $tipodoc->currentPage(),
                'per_page'      => $tipodoc->perpage(),
                'last_page'     => $tipodoc->lastPage(),
                'from'          => $tipodoc->firstItem(),
                'to'            => $tipodoc->lastItem(),
            ],
            'tipodoc' => $tipodoc
        ];
    }


    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'cod_tipo_documento'=>'required|digits:2',
            'td_documento'=>'required',
        ];

        $messages = [
            'cod_tipo_documento.required'=>'Ingresar Codigo',
            'cod_tipo_documento.digits'=>'Numeros 2 digitos',
            'td_documento.required'=>'Ingresar Tipo de Documento',
        ];

        $this->validate($request,$rules,$messages);

        //*Guardar Datos en la tabla
        $tipodoc= new Tipodocumento();
        $tipodoc->cod_tipo_documento = $request->cod_tipo_documento;
        $tipodoc->td_documento = $request->td_documento;
        $tipodoc->save();

    }


    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'cod_tipo_documento'=>'required|digits:2',
            'td_documento'=>'required',
        ];

        $messages = [
            'cod_tipo_documento.required'=>'Ingresar Codigo',
            'cod_tipo_documento.digits'=>'Numeros 2 digitos',
            'td_documento.required'=>'Ingresar Tipo de Documento',
        ];

        $this->validate($request,$rules,$messages);

        //*Actualizar Datos en la tabla

        $tipodoc= Tipodocumento::findOrFail($request->cod_tipo_documento);
        $tipodoc->td_documento = $request->td_documento;
        $tipodoc->save();

    }


    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $tipodoc= Tipodocumento::find($request->cod_tipo_documento);
        $tipodoc->delete();
    }


    public function selectTipodocumento(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $tipodocumento = Tipodocumento::select('cod_tipo_documento','td_documento')->orderBy('cod_tipo_documento','asc')->get();
        return ['tipodocumento'=>$tipodocumento];
    }
}
