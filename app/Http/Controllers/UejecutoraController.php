<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uejecutora;


class UejecutoraController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $Uejecutoras = Uejecutora::first();

        return $Uejecutoras;

    }

    public function store(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'ue_ruc'=>'required',
            'ue_nombre'=>'required',
            'ue_direccion'=>'required',
        ];

        $messages = [
            'ue_ruc.required'=>'Ingresar RUC',
            'ue_nombre.required'=>'Ingresar Nombre',
            'ue_direccion.required'=>'Ingresar Dirección',
        ];

        $this->validate($request,$rules,$messages);

        //*Fin validacion del formulario

        //*Asignar un nombre a la imegen por defecto
        $name='defaultlogo.png';

        //*Validar file, obtener el nombre del archivo y mover al servidor
        if($request->hasFile('ue_logo')){
            $file = $request->file('ue_logo');
            $name = time().$file->getClientOriginalName();
            $file->move(public_path().'/logoue/',$name);
        }

        //*Guardar Datos en la tabla
        $uejecutora= new Uejecutora();
        $uejecutora->ue_ruc = $request->ue_ruc;
        $uejecutora->ue_nombre = $request->ue_nombre;
        $uejecutora->ue_direccion = $request->ue_direccion;
        $uejecutora->ue_logo = $name;
        $uejecutora->save();
    }

    
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //--Validacion del Formulario

        $rules = [
            'ue_ruc'=>'required|numeric|digits:11',
            'ue_nombre'=>'required',
            'ue_direccion'=>'required',
        ];

        $messages = [
            'ue_ruc.required'=>'Ingresar RUC',
            'ue_nombre.required'=>'Ingresar Nombre',
            'ue_direccion.required'=>'Ingresar Dirección',
        ];

        $this->validate($request,$rules,$messages);

        //*Fin validacion del formulario

        //*Asignar un nombre a la imegen por defecto
         if($request->variablefoto==0){

            //*Guardar Datos en la tabla
            $uejecutora= Uejecutora::find($request->ue_id);
            $uejecutora->ue_ruc = $request->ue_ruc;
            $uejecutora->ue_nombre = $request->ue_nombre;
            $uejecutora->ue_direccion = $request->ue_direccion;
            $uejecutora->save();

        }else{ 
            
            $name='defaultlogo.png';

            //*Validar file, obtener el nombre del archivo y mover al servidor
            if($request->hasFile('ue_logo')){
                $file = $request->file('ue_logo');
                $name = time().$file->getClientOriginalName();
                $file->move(public_path().'/logoue/',$name);
            }

            //*Guardar Datos en la tabla

            $uejecutora= Uejecutora::find($request->ue_id);
            $uejecutora->ue_ruc = $request->ue_ruc;
            $uejecutora->ue_nombre = $request->ue_nombre;
            $uejecutora->ue_direccion = $request->ue_direccion;
            $uejecutora->ue_logo = $name;
            $uejecutora->save();

        } 
    }

    
    public function destroy($id)
    {
        //
    }
}
