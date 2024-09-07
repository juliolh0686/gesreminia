<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adminpension;

class ComprisegController extends Controller
{
    public function Periodoscps(Request $request)
    {
       if (!$request->ajax()) return redirect('/');

            $periodos=Compriseg::select('cpsperiodo')
                                    ->orderBy('cpsperiodo','desc')
                                    ->groupBy('cpsperiodo')
                                    ->get();

            return ['periodos' => $periodos];
    }

    public function Compriseg(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $compriseg=Adminpension::orderBy('cod_admin_pension','desc')->get();

        return ['compriseg' => $compriseg];
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $compriseg= Compriseg::findOrFail($request->cod_compriseg);
        $compriseg->cpscomision = $request->cpscomision;
        $compriseg->spsprima = $request->spsprima;
        $compriseg->cpsaporte = $request->cpsaporte;
        $compriseg->save();
    }


    
}
