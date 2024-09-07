<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adminpension;

class AdminpensionController extends Controller
{

  public function index(Request $request)
  {
    if (!$request->ajax()) return redirect('/');

    $buscar= $request->buscar;
    $criterio = $request->criterio;

    if($buscar==''){
      $adminpension= Adminpension::join('reg_pensiones','admin_pensiones.regimen_pension_cod_regimen_pension','=','reg_pensiones.cod_regimen_pension')
        ->orderBy('ap_admin_pension','asc')->paginate(10);
    }
    else
    {
      $adminpension = Adminpension::where($criterio,'like','%'.$buscar.'%')
        ->join('reg_pensiones','admin_pensiones.regimen_pension_cod_regimen_pension','=','reg_pensiones.cod_regimen_pension')
        ->orderBy('ap_admin_pension','asc')
        ->paginate(10);
    }

    
    return [
        'pagination' =>[
            'total'         => $adminpension->total(),
            'current_page'  => $adminpension->currentPage(),
            'per_page'      => $adminpension->perpage(),
            'last_page'     => $adminpension->lastPage(),
            'from'          => $adminpension->firstItem(),
            'to'            => $adminpension->lastItem(),
        ],
        'adminpension' => $adminpension
    ];
  }
    
    public function selectAdminpension(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        $idregimenpension= $request->idregimenpension;

        $adminpension=Adminpension::select('cod_admin_pension','ap_admin_pension')->where('regimen_pension_cod_regimen_pension','=',$idregimenpension)->orderBy('ap_admin_pension','asc')->get();
        return ['adminpension'=>$adminpension];
    }

    public function Adminpensiones(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $adminpensiones=Adminpension::orderBy('ap_admin_pension','asc')->paginate(8);

        return [
            'pagination' =>[
                'total'         => $adminpensiones->total(),
                'current_page'  => $adminpensiones->currentPage(),
                'per_page'      => $adminpensiones->perpage(),
                'last_page'     => $adminpensiones->lastPage(),
                'from'          => $adminpensiones->firstItem(),
                'to'            => $adminpensiones->lastItem(),
            ],
            'adminpensiones' => $adminpensiones
        ];

    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $total_des_aport=round($request->ap_comision+$request->ap_prima+$request->ap_aporte+$request->ap_aporte_fijo,2);

        $adminpen= Adminpension::findOrFail($request->cod_admin_pension);
        $adminpen->ap_admin_pension = $request->ap_admin_pension;
        $adminpen->regimen_pension_cod_regimen_pension = $request->regimen_pension_cod_regimen_pension;
        $adminpen->ap_comision = $request->ap_comision;
        $adminpen->ap_prima = $request->ap_prima;
        $adminpen->ap_aporte = $request->ap_aporte;
        $adminpen->ap_aporte_fijo = $request->ap_aporte_fijo;
        $adminpen->ap_total_admpen = $total_des_aport;
        $adminpen->save();
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $total_des_aport=round($request->ap_comision+$request->ap_prima+$request->ap_aporte+$request->ap_aporte_fijo,2);

        //*Guardar Datos en la tabla
        $adminpen= new Adminpension();
        $adminpen->cod_admin_pension = $request->cod_admin_pension;
        $adminpen->ap_admin_pension = $request->ap_admin_pension;
        $adminpen->regimen_pension_cod_regimen_pension = $request->regimen_pension_cod_regimen_pension;
        $adminpen->ap_comision = $request->ap_comision;
        $adminpen->ap_prima = $request->ap_prima;
        $adminpen->ap_aporte = $request->ap_aporte;
        $adminpen->ap_aporte_fijo = $request->ap_aporte_fijo;
        $adminpen->ap_total_admpen = $total_des_aport;
        $adminpen->save();


    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $adminpen= Adminpension::find($request->cod_admin_pension);
        $adminpen->delete();
    }


}
