<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aseguradora;

class AseguradoraController extends Controller
{

    public function selectAseguradora(Request $request){
        
        if (!$request->ajax()) return redirect('/');
 
         $aseguradora = Aseguradora::select('cod_aseguradora','aseguradora')->orderBy('aseguradora','asc')->get();
         return ['aseguradora'=>$aseguradora];
     }
    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
