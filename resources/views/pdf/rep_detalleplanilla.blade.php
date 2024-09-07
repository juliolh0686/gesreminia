<!DOCTYPE html>
<html>
<head>
  <title>Reporte Planilla</title>

  <meta http-equiv="content-type" content="text-html; charset=utf-8">

  <style type="text/css">

  .titulo{
    font-size: 20px;
    text-align: center;
    padding-bottom: 10px;
    font-weight: bold;
  }

   .tablarep {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .tablarep td, #tablarep th {
        height: 30px;
        border: 1px solid #ddd;
        padding: 4px;
        font-size: 5px;
    }

    .tablarep tr:nth-child(even){background-color: #f2f2f2;}

    .tablarep tr:hover {background-color: #ddd;}

    .tablarep th {
        padding-top: 8px;
        padding-bottom: 8px;
        text-align: center;
        background-color: #4CAF50;
        font-size: 5px;
        color: white;
}
  </style>
</head>

<body>

<div class="titulo">{{$totalplanilla['pll_detalle']}}</div>
  
  <table class="tablarep">
   <thead>
       <tr>
          <th>N°</th>
          <th>COD_PERSONAL</th>
          <th>N_DOCUMENTO</th>
          <th>APE_PATERNO</th>
          <th>APE_MATERNO</th>
          <th>NOMBRES</th>
          <th>FECHA_NAC.</th>
          <th>SEXO</th>
          <th>RUC</th>
          <th>NUM_CONTRATO</th>
          <th>FECH_INICIO</th>
          <th>FECH_TERMI</th>
          <th>ADM. PENSION</th>
          <th>CUSSP</th>
          <th>AREA</th>
          <th>CARGO</th>
          <th>META</th>
          <th>HR.</th>
          <th>D.L.</th>
          <th>BANCO</th>
          <th>CUENTA</th>
          <th>DETALLE INGRESOS</th>
          <th>MONTO BRUTO</th>
          <th>BASE CALCULO</th>
          <th>DETALLE DE DESCUENTOS</th>
          <th>TOTAL DESCUENTOS</th>
          <th>LIQUIDO</th>
          <th>APORTE</th>
       </tr>
   </thead>
   <tbody>
      @foreach($rp_DetallePlanilla as $rp_DetallePlanilla)
       <tr>
           <td align="center"> {{++$loop->index}} </td>
           <td> {{$rp_DetallePlanilla->cod_personal}} </td>
           <td> {{$rp_DetallePlanilla->p_num_doc}} </td>
           <td> {{$rp_DetallePlanilla->p_a_paterno}} </td>
           <td> {{$rp_DetallePlanilla->p_a_materno}} </td>
           <td> {{$rp_DetallePlanilla->p_nombres}} </td>
           <td> {{$rp_DetallePlanilla-> p_fech_nac}} </td>
           <td> {{$rp_DetallePlanilla->s_sexo}} </td>
           <td> {{$rp_DetallePlanilla->p_ruc}} </td>
           <td> {{$rp_DetallePlanilla->c_numero}} </td>
           <td>{{$rp_DetallePlanilla->c_fech_ini}}</td>
           <td>{{$rp_DetallePlanilla->c_fech_ter}}</td>
           <td>{{$rp_DetallePlanilla->ap_admin_pension}}</td>
           <td>{{$rp_DetallePlanilla->p_cuspp}}</td>
           <td>{{$rp_DetallePlanilla->a_abrev_area}}</td>
           <td>{{$rp_DetallePlanilla->c_abrev_cargo}}</td>
           <td>{{$rp_DetallePlanilla->meta}} </td>
           <td>{{$rp_DetallePlanilla->c_horas}} </td>
           <td>{{$rp_DetallePlanilla->c_dias_lab}} </td>
           <td>{{$rp_DetallePlanilla->b_banco}} </td>
           <td>{{$rp_DetallePlanilla->p_num_cuenta}} </td>
            <td>
            @foreach($rp_DetallePlanilla->Planilla_Conceptos as $conceptos)
            @if(($conceptos->tipo_concepto_cod_tip_concepto==1) || ($conceptos->tipo_concepto_cod_tip_concepto==3))
              <a>{{$conceptos->concepto_cod_concepto}}-{{$conceptos->con_abrev}}:{{number_format($conceptos->pll_id_monto,2)}}</a><br>
            @endif
            @endforeach
            </td>

            <td align="right"> {{number_format($rp_DetallePlanilla->dpll_bruto,2)}} </td>
            <td align="right"> {{number_format($rp_DetallePlanilla->dpll_base_calculo,2)}} </td>

            <td>
            @foreach($rp_DetallePlanilla->Planilla_Conceptos as $conceptos)
            @if ($conceptos->tipo_concepto_cod_tip_concepto==2)
              <a> {{$conceptos->concepto_cod_concepto}}-{{$conceptos->con_abrev}}:{{number_format($conceptos->pll_id_monto,2)}}</a><br>
            @endif
            @endforeach
            </td>

           <td align="right"> {{number_format($rp_DetallePlanilla->dpll_descuentos,2)}} </td>
           <td align="right"> {{number_format($rp_DetallePlanilla->dpll_liquido,2)}} </td>
           <td align="right"> {{number_format($rp_DetallePlanilla->dpll_aport,2)}} </td>
       </tr>
       @endforeach
       <tr>
           <td colspan="22" align="center">Total</td>
           <td align="right">{{number_format($totalplanilla['pll_bruto'],2)}}</td>
           <td></td>
           <td></td>
           <td align="right">{{number_format($totalplanilla['pll_desc'],2)}}</td>
           <td align="right">{{number_format($totalplanilla['pll_liquido'],2)}}</td>
           <td align="right">{{number_format($totalplanilla['pll_aport'],2)}}</td>
       </tr>

      
   </tbody>
</table>

  

</body>

</html>