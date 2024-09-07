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

  /*CONVERTIR NUMEROS A TEXTO */

    function unidad($numuero){
      switch ($numuero)
      {
        case 9:
        {
          $numu = "NUEVE";
          break;
        }
        case 8:
        {
          $numu = "OCHO";
          break;
        }
        case 7:
        {
          $numu = "SIETE";
          break;
        }
        case 6:
        {
          $numu = "SEIS";
          break;
        }
        case 5:
        {
          $numu = "CINCO";
          break;
        }
        case 4:
        {
          $numu = "CUATRO";
          break;
        }
        case 3:
        {
          $numu = "TRES";
          break;
        }
        case 2:
        {
          $numu = "DOS";
          break;
        }
        case 1:
        {
          $numu = "UNO";
          break;
        }
        case 0:
        {
          $numu = "";
          break;
        }
      }
      return $numu;
    }
  
  function decena($numdero){
  
      if ($numdero >= 90 && $numdero <= 99)
      {
        $numd = "NOVENTA ";
        if ($numdero > 90)
          $numd = $numd."Y ".(unidad($numdero - 90));
      }
      else if ($numdero >= 80 && $numdero <= 89)
      {
        $numd = "OCHENTA ";
        if ($numdero > 80)
          $numd = $numd."Y ".(unidad($numdero - 80));
      }
      else if ($numdero >= 70 && $numdero <= 79)
      {
        $numd = "SETENTA ";
        if ($numdero > 70)
          $numd = $numd."Y ".(unidad($numdero - 70));
      }
      else if ($numdero >= 60 && $numdero <= 69)
      {
        $numd = "SESENTA ";
        if ($numdero > 60)
          $numd = $numd."Y ".(unidad($numdero - 60));
      }
      else if ($numdero >= 50 && $numdero <= 59)
      {
        $numd = "CINCUENTA ";
        if ($numdero > 50)
          $numd = $numd."Y ".(unidad($numdero - 50));
      }
      else if ($numdero >= 40 && $numdero <= 49)
      {
        $numd = "CUARENTA ";
        if ($numdero > 40)
          $numd = $numd."Y ".(unidad($numdero - 40));
      }
      else if ($numdero >= 30 && $numdero <= 39)
      {
        $numd = "TREINTA ";
        if ($numdero > 30)
          $numd = $numd."Y ".(unidad($numdero - 30));
      }
      else if ($numdero >= 20 && $numdero <= 29)
      {
        if ($numdero == 20)
          $numd = "VEINTE ";
        else
          $numd = "VEINTI".(unidad($numdero - 20));
      }
      else if ($numdero >= 10 && $numdero <= 19)
      {
        switch ($numdero){
        case 10:
        {
          $numd = "DIEZ ";
          break;
        }
        case 11:
        {
          $numd = "ONCE ";
          break;
        }
        case 12:
        {
          $numd = "DOCE ";
          break;
        }
        case 13:
        {
          $numd = "TRECE ";
          break;
        }
        case 14:
        {
          $numd = "CATORCE ";
          break;
        }
        case 15:
        {
          $numd = "QUINCE ";
          break;
        }
        case 16:
        {
          $numd = "DIECISEIS ";
          break;
        }
        case 17:
        {
          $numd = "DIECISIETE ";
          break;
        }
        case 18:
        {
          $numd = "DIECIOCHO ";
          break;
        }
        case 19:
        {
          $numd = "DIECINUEVE ";
          break;
        }
        }
      }
      else
        $numd = unidad($numdero);
    return $numd;
  }
  
    function centena($numc){
      if ($numc >= 100)
      {
        if ($numc >= 900 && $numc <= 999)
        {
          $numce = "NOVECIENTOS ";
          if ($numc > 900)
            $numce = $numce.(decena($numc - 900));
        }
        else if ($numc >= 800 && $numc <= 899)
        {
          $numce = "OCHOCIENTOS ";
          if ($numc > 800)
            $numce = $numce.(decena($numc - 800));
        }
        else if ($numc >= 700 && $numc <= 799)
        {
          $numce = "SETECIENTOS ";
          if ($numc > 700)
            $numce = $numce.(decena($numc - 700));
        }
        else if ($numc >= 600 && $numc <= 699)
        {
          $numce = "SEISCIENTOS ";
          if ($numc > 600)
            $numce = $numce.(decena($numc - 600));
        }
        else if ($numc >= 500 && $numc <= 599)
        {
          $numce = "QUINIENTOS ";
          if ($numc > 500)
            $numce = $numce.(decena($numc - 500));
        }
        else if ($numc >= 400 && $numc <= 499)
        {
          $numce = "CUATROCIENTOS ";
          if ($numc > 400)
            $numce = $numce.(decena($numc - 400));
        }
        else if ($numc >= 300 && $numc <= 399)
        {
          $numce = "TRESCIENTOS ";
          if ($numc > 300)
            $numce = $numce.(decena($numc - 300));
        }
        else if ($numc >= 200 && $numc <= 299)
        {
          $numce = "DOSCIENTOS ";
          if ($numc > 200)
            $numce = $numce.(decena($numc - 200));
        }
        else if ($numc >= 100 && $numc <= 199)
        {
          if ($numc == 100)
            $numce = "CIEN ";
          else
            $numce = "CIENTO ".(decena($numc - 100));
        }
      }
      else
        $numce = decena($numc);
  
      return $numce;
  }
  
    function miles($nummero){
      if ($nummero >= 1000 && $nummero < 2000){
        $numm = "MIL ".(centena($nummero%1000));
      }
      if ($nummero >= 2000 && $nummero <10000){
        $numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
      }
      if ($nummero < 1000)
        $numm = centena($nummero);
  
      return $numm;
    }
  
    function decmiles($numdmero){
      if ($numdmero == 10000)
        $numde = "DIEZ MIL";
      if ($numdmero > 10000 && $numdmero <20000){
        $numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
      }
      if ($numdmero >= 20000 && $numdmero <100000){
        $numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
      }
      if ($numdmero < 10000)
        $numde = miles($numdmero);
  
      return $numde;
    }
  
    function cienmiles($numcmero){
      if ($numcmero == 100000)
        $num_letracm = "CIEN MIL";
      if ($numcmero >= 100000 && $numcmero <1000000){
        $num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
      }
      if ($numcmero < 100000)
        $num_letracm = decmiles($numcmero);
      return $num_letracm;
    }
  
    function millon($nummiero){
      if ($nummiero >= 1000000 && $nummiero <2000000){
        $num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
      }
      if ($nummiero >= 2000000 && $nummiero <10000000){
        $num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
      }
      if ($nummiero < 1000000)
        $num_letramm = cienmiles($nummiero);
  
      return $num_letramm;
    }
  
    function decmillon($numerodm){
      if ($numerodm == 10000000)
        $num_letradmm = "DIEZ MILLONES";
      if ($numerodm > 10000000 && $numerodm <20000000){
        $num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
      }
      if ($numerodm >= 20000000 && $numerodm <100000000){
        $num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
      }
      if ($numerodm < 10000000)
        $num_letradmm = millon($numerodm);
  
      return $num_letradmm;
    }
  
    function cienmillon($numcmeros){
      if ($numcmeros == 100000000)
        $num_letracms = "CIEN MILLONES";
      if ($numcmeros >= 100000000 && $numcmeros <1000000000){
        $num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
      }
      if ($numcmeros < 100000000)
        $num_letracms = decmillon($numcmeros);
      return $num_letracms;
    }
  
    function milmillon($nummierod){
      if ($nummierod >= 1000000000 && $nummierod <2000000000){
        $num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
      }
      if ($nummierod >= 2000000000 && $nummierod <10000000000){
        $num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
      }
      if ($nummierod < 1000000000)
        $num_letrammd = cienmillon($nummierod);
  
      return $num_letrammd;
    }
  
  
      function convertir($numero){
              $num = str_replace(",","",$numero);
              $num = number_format($num,2,'.','');
              $cents = substr($num,strlen($num)-2,strlen($num)-1);
              $num = (int)$num;
      
              $numf = milmillon($num);
      
          return $numf." CON ".$cents."/100 SOLES";
      }

      /********************************************* */

      /*VARIABLES PARA EL CONTADOR DE BOLETAS*/

      $contador = 0;

      $count_boletas= count($boletas);

      /********************************************* */
      /*CONVERTIR MES DE NUMERO A TEXTO*/

      function convertirMes($mes, $anio) {

        switch ($mes) {
          case '01':
            $mes_texto='Enero';
            break;
          case '02':
            $mes_texto='Febrero';
            break;
          case '03':
            $mes_texto='Marzo';
            break;
          case '04':
            $mes_texto='Abril';
            break;
          case '05':
            $mes_texto='Mayo';
            break;
          case '06':
            $mes_texto='Junio';
            break;
          case '07':
            $mes_texto='Julio';
            break;
          case '08':
            $mes_texto='Agosto';
            break;
          case '09':
            $mes_texto='Septiembre';
            break;
          case '10':
            $mes_texto='Octubre';
            break;
          case '11':
            $mes_texto='Noviembre';
            break;
          case '12':
            $mes_texto='Diciembre';
            break;
          default:
            $mes_texto='No Encontrado';
          }
          
          return $mes_texto . " - " . $anio;

      }

   ?>


  @foreach($boletas as $boleta)

  <?php

    $anio = substr($boleta->pll_periodo,0,4);
    $mes = substr($boleta->pll_periodo,4,2);
    $mesAnio = convertirMes($mes,$anio)

  ?>
  
  <table class="tablarep">
    <tr>
      <td style="width:10%;"><div class="logo_boleta"><img src="{{ asset('logoue/'.$Uejecutoras->ue_logo)}}"></div></td>
      <td style="width:80%;">
        <div class="titulo_boleta">BOLETA DE PAGO - PLANILLA CAS</div>
        <div class="titulo_boleta">Periodo: {{ $mesAnio }} </div>
          <div>  </div>
      </td>
      <td style="width:10%;">
        <div class="aling_right">{{++$loop->index}}</div>
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
        <!--<tr>
          <td colspan="2"><br/><p class="bordesuperior centrarTexto textBold">FIRMA DEL SERVIDOR, PENSIONISTAS O BENEFICIARIO</p></td>
          <td colspan="2"><br/><p></p></td>
          <td colspan="2"><br/><p class="bordesuperior centrarTexto textBold">FIRMA DEL RESPONSABLE DE LA OFICINA DE RECURSOS</p></td>
        </tr> -->
  </table>
</div>

<?php

  $contador += 1;

  if($contador < $count_boletas) {
    echo "<div style='page-break-after:always;'></div>";
  }

?>

@endforeach

</body>

</html>