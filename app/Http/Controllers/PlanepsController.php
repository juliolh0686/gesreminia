<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PlanEps;

class PlanepsController extends Controller
{
    public function selectPlaneps(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $planeps = PlanEps::select('cod_plan_eps','pe_des_plan_eps')->orderBy('cod_plan_eps','asc')->get();
        return ['planeps'=>$planeps];
    }
}
