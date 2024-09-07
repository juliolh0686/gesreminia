<!DOCTYPE html>
<html>
<head>
  <title>Reporte Personal</title>

  <meta http-equiv="content-type" content="text-html; charset=utf-8">

  <style type="text/css">

  html {
    margin: 0;
  }

  body{
    font-family: serif;
    font-size: 7px;
    margin: 5mm 5mm 5mm 5mm;
  }

  .btitulo1{
      font-weight: bold;
      font-size: 12px;
    }

    .btitulo2{
      font-weight: bold;
      font-size: 12px;
      margin-bottom: 5px;
    }

    .btitulo3{
      font-weight: bold;
      font-size: 15px;
      margin-bottom: 10px;
      text-align: center;
    }


   .tablarep {
        border-collapse: collapse;
        width: 100%;
    }

    .bordesuperior {
        border-top: 1px solid #000;
    }

    .bordeinferior {
        border-bottom: 1px solid #000;
    }

    .bordederecha {
        border-right: 1px solid #000;
    }

    .bordeizquierda {
        border-left: 1px solid #000;
    }

    .tablarep td, #tablarep th {
        /*border: 1px solid #ddd;*/
        padding: 2px;
        font-size: 10px;
        width: 16.66%;
    }

  .tablarep th {
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: #4CAF50;
        font-size: 10px;
        color: white;
}
  
  .detallemontos{
    vertical-align: top;
  }

  .datospersonales{
    margin: 10px 0;
  }

  .montos{
    margin: 5px 0;
    height: 220px;
  }

  .totales{
    margin-bottom: 15px;
    height: 55px;
    width: 100%;
  }

  .alinearnumero{
    text-align: right;
  }

  .tabladet td, #tabladet th {
        font-size: 10px;
        width: 50%;
    }

  .mensajes{
    margin-bottom: 10px 0;
    width: 100%;
  }

  </style>
</head>

<body>

  @foreach($boletas as $boletas)
  <div class="btitulo3">BOLETA DE PAGO - CONTRATO ADMINISTRATIVO DE SERVICIOS - D.L. N° 1057</div>
  <div class="datospersonales">
  <table class="tablarep">
   <tbody>
        <tr>
          <td colspan="5"><div class="btitulo1">UNIDAD DE GESTION EDUCATIVA LOCAL N° 07</div></td>
          <td>PERIODO: {{$boletas->pll_periodo}}</td>
        </tr>
        <tr>
          <td colspan="5"><div class="btitulo2">RUC:20334929281</div></td>
          <td>Numero: {{++$loop->index}}</td>
        </tr>
         <tr>
           <td class="bordesuperior">COD_PERSONAL</td>
           <td class="bordesuperior"> {{$boletas->cod_personal}} </td>
           <td class="bordesuperior">RUC</td>
            <td class="bordesuperior">{{$boletas->p_ruc}} </td>
            <td class="bordesuperior">N° CONTRATO</td>
           <td class="bordesuperior">  {{$boletas->c_numero}} </td>
        </tr>
        <tr>
           <td>APE_PATERNO</td>
           <td colspan="3"> {{$boletas->p_a_paterno}} </td>
           <td>FECH_INICIO</td>
           <td> {{$boletas->c_fech_ini }}</td>
        </tr>
        <tr>
           <td>APE_MATERNO</td>
           <td colspan="3"> {{$boletas->p_a_materno}} </td>
           <td>FECH_TERMINO</td>
           @if($boleta->c_fech_ter == '2999-12-31') {
              <td>Indeterminado</td>
            @else
              <td> {{$boleta->c_fech_ter}}</td>
            @endif
        </tr>
        <tr>
           <td>NOMBRES</td>
           <td colspan="3"> {{$boletas->p_nombres}} </td>
           <td>REG_LABORAL</td>
           <td> {{$boletas->rl_regimen_laboral}} </td>
        </tr>
        <tr>
           <td>SEXO</td>
           <td> {{$boletas->s_sexo}} </td>
           <td>ADM. PENSION</td>
           <td> {{$boletas->ap_admin_pension}} </td>
           <td>TIP_TRABAJADOR</td>
           <td> {{$boletas->tt_tipo_trabajador}} </td>
        </tr>
        <tr>
           <td>N° DOCUMENTO</td>
           <td> {{$boletas->p_num_doc}} </td>
           <td>CUSPP</td>
           <td> {{$boletas->p_cuspp}} </td>
           <td>N° CUENTA</td>
           <td> {{$boletas->p_num_cuenta}} </td>
        </tr>
        <tr>
           <td>FECH_NACIMIENTO</td>
           <td> {{$boletas->p_fech_nac}} </td>
           <td>FECH_AFIL</td>
           <td> {{$boletas->p_fech_afiliacion}} </td>
           <td>PLAZA</td>
           <td> {{$boletas->c_plaza}} </td>
        </tr>
        <tr>
           <td>AREA</td>
           <td colspan='5'> {{$boletas->a_abrev_area}} </td>
        </tr>
        <tr>
           <td>CARGO</td>
           <td colspan='5'> {{$boletas->c_abrev_cargo}} </td>
        </tr>

        </tbody>
</table>
</div>
<div class="montos bordeinferior">
<table class="tablarep">
        <tr>
          <td class="bordesuperior bordeinferior bordederecha bordeizquierda">INGRESOS</td>
          <td class="bordesuperior bordeinferior bordederecha bordeizquierda">DESCUENTOS</td>
          <td class="bordesuperior bordeinferior bordederecha bordeizquierda">APORTES DEL EMPLEADOR</td>
       </tr>
       
        <tbody>
       <tr class="detallemontos">
        <td>
        <table>
        @foreach($boletas->Planilla_Conceptos as $boletasmas)
        @if (($boletasmas->tipo_concepto_cod_tip_concepto==1) || ($boletasmas->tipo_concepto_cod_tip_concepto==3))
            <tr>
              <td> {{$boletasmas->concepto_cod_concepto}}-{{$boletasmas->con_abrev}}</td>
              <td> {{$boletasmas->pll_id_monto}}</td>
            </tr>
        @endif
        @endforeach
        </table>
      </td>
        <td>
        <table>
        @foreach($boletas->Planilla_Conceptos as $boletasmas)
        @if ($boletasmas->tipo_concepto_cod_tip_concepto==2)
            <tr>
              <td> {{$boletasmas->concepto_cod_concepto}}-{{$boletasmas->con_abrev}}</td>
              <td> {{$boletasmas->pll_id_monto}}</td>
            </tr>
        @endif
        @endforeach
        </table>
        </td>
         <td>
        <table>
        @foreach($boletas->Planilla_Conceptos as $boletasmas)
        @if ($boletasmas->tipo_concepto_cod_tip_concepto==4)
            <tr>
              <td> {{$boletasmas->concepto_cod_concepto}}-{{$boletasmas->con_abrev}}</td>
              <td> {{$boletasmas->pll_id_monto}}</td>
            </tr>
        @endif
        @endforeach
        </table>
        </td>
       </tr>
       
   </tbody>
</table>
</div>

<div class="totales">
<table class="tablarep bordesuperior bordeinferior bordederecha bordeizquierda">
   <tbody>
        <tr>
          <td>
          <table class="tabladet">
            <tr>
              <td>TOTAL REMUNERACION</td>
              <td class="alinearnumero">{{$boletas->dpll_bruto}}</td>
            </tr> 
          </table>
          </td>
          <td>
          <table class="tabladet">
            <tr>
              <td>TOTAL DESCUENTOS</td>
              <td>{{$boletas->dpll_descuentos}}</td>
            </tr>
          </table>
          </td>
          <td>
          <table class="tabladet alinearnumero">
            <tr>
              <td>TOTAL APORTACION</td>
              <td>{{$boletas->dpll_aport}}</td>
            </tr>
          </table>
          </td>
        </tr>

        <tr>
          <td>
          <table class="tabladet alinearnumero">
            <tr>
              <td>MONTO BASE CALCULO</td>
              <td>{{$boletas->dpll_base_calculo}}</td>
            </tr>
          </table>
          </td>
          <td>
          </td>
          <td>
          <table class="tabladet alinearnumero">
            <tr>
              <td>MONTO LIQUIDO</td>
              <td>{{$boletas->dpll_liquido}}</td>
            </tr>
          </table>
          </td>
        </tr>
        </tbody>
</table>
</div>
<div style="page-break-after:always;"></div>
@endforeach

</body>

</html>