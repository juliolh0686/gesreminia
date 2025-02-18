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
        height: 15px;
        border: 1px solid #ddd;
        padding: 4px;
        font-size: 12px;
    }

    .tablarep tr:nth-child(even){background-color: #f2f2f2;}

    .tablarep tr:hover {background-color: #ddd;}

    .tablarep th {
        padding-top: 8px;
        padding-bottom: 8px;
        text-align: center;
        background-color: #4CAF50;
        font-size: 12px;                     
        color: white;
    }

    .negrita-resaltado {
      font-weight:bold;
      background-color: #bfbfbf;
    }
  </style>
</head>

<body>

  <div class="titulo">REPORTE DE DESCUENTO: {{$concepto->con_nombre}} - {{$estacion->est_nombre}}</div>

  <table class="tablarep">
    @php
        $totalgeneral = 0;
    @endphp
  @foreach($metas as $meta)
  @foreach($clasificadores as $clasificador)
    @php
      $totaldescuento = 0;
    @endphp
    @foreach($datadescuentos as $datadescuento)
      @if ($datadescuento->meta==$meta->meta && $datadescuento->idclasificador==$clasificador->idclasificador)
      @php
        $totaldescuento = $totaldescuento+$datadescuento->pll_id_monto;
      @endphp
      <tr>
        <td align="center"> {{++$loop->index}} </td>
        <td align="left">{{$datadescuento->p_num_doc}}</td>
        <td align="center">{{$datadescuento->p_a_paterno}}</td>
        <td align="center">{{$datadescuento->p_a_materno}}</td>
        <td align="center">{{$datadescuento->p_nombres}}</td>
        <td align="center">{{$datadescuento->clasificador}}</td>
        <td align="center">{{$datadescuento->meta}}</td>
        <td align="right">{{number_format($datadescuento->pll_id_monto,2)}}</td>     
       </tr>
      @endif
    @endforeach
    @if($totaldescuento>0)
    <tr>
        <td align="center"></td>
        <td align="left"></td>
        <td align="center"></td>
        <td align="center"></td>
        <td align="center" class="negrita-resaltado">Total</td>
        <td align="center" class="negrita-resaltado">{{ $clasificador->clasificador}} </td>
        <td align="center" class="negrita-resaltado">{{$meta->meta}}</td>
        <td align="right" class="negrita-resaltado">{{number_format($totaldescuento,2)}}</td>     
       </tr>
    @endif
    @php
      $totalgeneral = $totalgeneral+$totaldescuento;
    @endphp
  @endforeach
  @endforeach
  <tr>
    <td align="center"></td>
    <td align="left"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="right"></td>     
  </tr>
  <tr>
    <td align="center"></td>
    <td align="left"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center" class="negrita-resaltado">Total General</td>
    <td align="right" class="negrita-resaltado">{{number_format($totalgeneral,2)}}</td>     
  </tr>
  </table>


  

</body>

</html>