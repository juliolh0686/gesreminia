<!DOCTYPE html>
<html>
<head>
  <title>Boleta de Pago</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <style type="text/css">

    html {
      margin: 0px;
    }

    body{
      font-family: serif;
      font-size: 7px;
      margin: 10mm 10mm 10mm 10mm;
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

    .aling_right {
      text-align: right;
    }

    .logo_boleta {
      align-items: center;
    }

    .logo_boleta img {
      width: 70px;
    }

    .titulo_boleta {
      font-weight: bold;
      font-size: 15px;
      text-align: center;
    }

    .centrarTexto {
      text-align: center;
    }

    .textBold {
      font-weight: bold;
    }

    .anchoResult{
      height: 25px;
      line-height: 20px;
    }

    .alinearderecha {
      text-align: right;
    }

  </style>

</head>
  <body>


  <?php

    $anio = substr($boleta->pll_periodo,0,4);
    $mes = substr($boleta->pll_periodo,4,2);
    $mesAnio = convertirMes($mes,$anio)

  ?>
  
  <table class="tablarep">
    <tr>
      <td style="width:10%;"><div class="logo_boleta"><img src="{{ asset('logoue/'.$Uejecutoras->ue_logo)}}"></div></td>
      <td style="width:80%;">
        <div class="titulo_boleta">BOLETA DE PAGO - PLANILLA DE REMUNERACIONES</div>
        <div class="titulo_boleta">Periodo: {{ $mesAnio }} </div>
          <div>  </div>
      </td>
      <td style="width:10%;">
        <div class="aling_right"></div>
        <div class="aling_right">{{ date("d/m/Y") }} </div>
        <div class="aling_right"> {{date("H:i:s")}} </div>
      </td>
    </tr>
  </table>

  <br/>
  
  <div class="datospersonales">
 
  <table class="tablarep">
   <tbody>
        <tr>
          <td colspan="3">Entidad: {{$Uejecutoras->ue_entidad}}</td>
          <td colspan="3">Rubro de Financiamiento: 00 RECURSOS ORDINARIOS</td>
        </tr>
        <tr>
          <td colspan="3">Empleador: {{ $Uejecutoras->ue_nombre}}</td>
          <td colspan="3">Meta Presupuestal: {{$boleta->meta}}</td>
        </tr>
        <tr>
          <td colspan="3">RUC: {{ $Uejecutoras->ue_ruc}}</td>
          <td colspan="3">Unidad Organica: {{$boleta->a_abrev_area}}</td>
        </tr>
        <br/>
         <tr>
           <td class="bordesuperior">COD_PERSONAL</td>
           <td class="bordesuperior"> {{$boleta->cod_personal}} </td>
           <td class="bordesuperior">RUC</td>
            <td class="bordesuperior">{{$boleta->p_ruc}} </td>
            <td class="bordesuperior">N° CONTRATO</td>
           <td class="bordesuperior">  {{$boleta->c_numero}} </td>
        </tr>
        <tr>
           <td>APE_PATERNO</td>
           <td colspan="3"> {{$boleta->p_a_paterno}} </td>
           <td>FECH_INICIO</td>
           <td> {{$boleta->c_fech_ini }}</td>
        </tr>
        <tr>
           <td>APE_MATERNO</td>
           <td colspan="3"> {{$boleta->p_a_materno}} </td>
           <td>FECH_TERMINO</td>
           @if($boleta->c_fech_ter == '2999-12-31')
              <td>Indeterminado</td>
            @else
              <td> {{$boleta->c_fech_ter}}</td>
            @endif
           
        </tr>
        <tr>
           <td>NOMBRES</td>
           <td colspan="3"> {{$boleta->p_nombres}} </td>
           <td>REG_LABORAL</td>
           <td> {{$boleta->rl_regimen_laboral}} </td>
        </tr>
        <tr>
           <td>SEXO</td>
           <td> {{$boleta->s_sexo}} </td>
           <td>ADM. PENSION</td>
           <td> {{$boleta->ap_admin_pension}} </td>
           <td>TIP_TRABAJADOR</td>
           <td> {{$boleta->tt_tipo_trabajador}} </td>
        </tr>
        <tr>
           <td>N° DOCUMENTO</td>
           <td> {{$boleta->p_num_doc}} </td>
           <td>CUSPP</td>
           <td> {{$boleta->p_cuspp}} </td>
           <td>N° CUENTA</td>
           <td> {{$boleta->p_num_cuenta}} </td>
        </tr>
        <tr>
           <td>FECH_NACIMIENTO</td>
           <td> {{$boleta->p_fech_nac}} </td>
           <td>FECH_AFIL</td>
           <td> {{$boleta->p_fech_afiliacion}} </td>
           <td>PLAZA</td>
           <td> {{$boleta->c_plaza}} </td>
        </tr>
        <tr>
           <td>AREA</td>
           <td colspan='5'> {{$boleta->a_abrev_area}} </td>
        </tr>
        <tr>
           <td>CARGO</td>
           <td colspan='5'> {{$boleta->c_abrev_cargo}} </td>
        </tr>

        <tr>
           <td>DIAS LABORADOS</td>
           <td> {{$boleta->dpll_dias_lab}} </td>
           <td>DIAS SUBSIDIADOS</td>
           <td> {{$boleta->dpll_dias_lic}} </td>
           <td>INASISTENCIAS</td>
           <td> {{$boleta->dpll_desc_dias}} </td>
        </tr>
        <tr>
           <td>TARDANZAS HORAS</td>
           <td> {{$boleta->dpll__desc_horas}} </td>
           <td>TARDANZAS MINUTOS</td>
           <td> {{$boleta->dpll_desc_min}} </td>
           <td>PERMISOS</td>
           <td> {{$boleta->dpll_desc_perm}} </td>
        </tr>

        </tbody>
</table>
</div>

<div>
  <table class="tablarep">
    <tr class="bordesuperior bordeinferior">
      <td class="textBold">CODIGO</td>
      <td class="textBold">CONCEPTO</td>
      <td class="textBold">MONTO</td>
      <td class="textBold">CODIGO</td>
      <td class="textBold">CONCEPTO</td>
      <td class="textBold">MONTO</td>
    </tr>
    <tr><td colspan="6" class="textBold"><br/>INGRESOS</td></tr>
      @foreach($boleta->Planilla_Conceptos as $boletasmas)
      @if (($boletasmas->tipo_concepto_cod_tip_concepto==1) || ($boletasmas->tipo_concepto_cod_tip_concepto==3))
          <tr>
            <td> {{$boletasmas->concepto_cod_concepto}}</td>
            <td> {{$boletasmas->con_abrev}}</td>
            <td> {{number_format($boletasmas->pll_id_monto,2)}}</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
      @endif
      @endforeach
      <br>
      <br>
      <br>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" class="textBold">TOTAL INGRESOS (A)</td>
        <td class="bordesuperior textBold alinearderecha">{{number_format($boleta->dpll_bruto,2)}}</td>
      </tr>
      <br><br>
      <tr><td colspan="6" class="bordesuperior textBold"><br/>DESCUENTOS</td></tr>
        @foreach($boleta->Planilla_Conceptos as $boletasmas)
          @if ($boletasmas->tipo_concepto_cod_tip_concepto==2)
              <tr>
                <td> {{$boletasmas->concepto_cod_concepto}}</td>
                <td> {{$boletasmas->con_abrev}}</td>
                <td> {{number_format($boletasmas->pll_id_monto,2)}}</td>
              </tr>
          @endif
        @endforeach
      <br>
      <br>
      <br>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" class="textBold">TOTAL DESCUENTOS (B)</td>
        <td class="bordesuperior textBold alinearderecha">{{number_format($boleta->dpll_descuentos,2)}}</td>
      </tr>
        <br><br>
        <tr><td colspan="6" class="bordesuperior textBold"><br/>APORTES</td></tr>
        @foreach($boleta->Planilla_Conceptos as $boletasmas)
          @if ($boletasmas->tipo_concepto_cod_tip_concepto==4)
              <tr>
                <td> {{$boletasmas->concepto_cod_concepto}} </td>
                <td> {{$boletasmas->con_abrev}} </td>
                <td> {{number_format($boletasmas->pll_id_monto,2)}} </td>
              </tr>
          @endif
          @endforeach
          <br>
          <br>
          <br>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" class="textBold">TOTAL APORTES</td>
            <td class="bordesuperior textBold alinearderecha">{{number_format($boleta->dpll_aport,2)}}</td>
        </tr>
        <br><br>
        <tr><td colspan="6" class="bordesuperior"><br/></td></tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2">MONTO BASE CALCULO</td>
            <td><div class="anchoResult alinearderecha">{{number_format($boleta->dpll_base_calculo,2)}}</div></td>
        </tr>
        <tr><td colspan="6"><br/></td></tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="2" class="textBold bordesuperior bordeinferior">NETO A PAGAR ( A - B )</td>
            <td class="bordeinferior bordesuperior textBold anchoResult alinearderecha">{{number_format($boleta->dpll_liquido,2)}}</td>
        </tr>
        <?php
        $numeroEnLetras = convertir($boleta->dpll_liquido);
        ?>
        <tr><td colspan="6" class="textBold alinearderecha"><br/>NETO A PAGAR(En letras): {{ $numeroEnLetras}}<br/></td></tr>
        <tr><td colspan="6" class="bordeinferior"><br/></td></tr>
        <tr><td colspan="6"><br/></td></tr>
        <br/><br/><br/><br/><br/><br/><br/><br/>
        <tr>
          <td colspan="2"><br/><p class="bordesuperior centrarTexto textBold">FIRMA DEL SERVIDOR, PENSIONISTAS O BENEFICIARIO</p></td>
          <td colspan="2"><br/><p></p></td>
          <td colspan="2"><br/><p class="bordesuperior centrarTexto textBold">FIRMA DEL RESPONSABLE DE LA OFICINA DE RECURSOS</p></td>
        </tr>
  </table>
</div>

<?php

  //$contador += 1;

  // if($contador < $count_boletas) {
  //   echo "<div style='page-break-after:always;'></div>";
  // }

?>



</body>

</html>