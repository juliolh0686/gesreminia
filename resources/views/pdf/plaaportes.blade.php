<!DOCTYPE html>
<html>
<head>
  <title>Reporte de Aportes</title>

  <meta http-equiv="content-type" content="text-html; charset=utf-8">

  <style type="text/css">

    html {
        margin: 0;
    }

    body {
        margin: 15mm 25mm;
    }

  .titulo{
    font-size: 18px;
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
        border: 1px solid #ddd;
        padding: 2px;
        font-size: 10px;
    }

    .tablarep tr:nth-child(even){background-color: #f2f2f2;}

    .tablarep tr:hover {background-color: #ddd;}

    .tablarep th {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
        background-color: #4CAF50;
        font-size: 12px;
        color: white;
    }

    .detalle{
        font-size=20px;
    }

    .totales{
        font-weight:bold;
    }

  </style>
</head>

<body>

<div class="titulo">RESUMEN DE APORTES - {{$planillatotal['pll_detalle']}}</div>
  
  <table class="tablarep">
   <thead>
       <tr>
          <th>Nº</th>
          <th>ENTIDAD</th>
          <th>MONTO DESCUENTO</th>
       </tr>
   </thead>
   <tbody>
      @foreach($dataResumen as $datadescuentos)
       <tr>
            <td align="center"> {{++$loop->index}} </td>
            <td align="left">{{$datadescuentos->con_nombre}}</td>
            <td align="right">{{number_format($datadescuentos->monto,2)}}</td>
            
       </tr>
       @endforeach
       <tr class="totales">
           <td align="center" colspan="2">TOTAL</td>
           <td align="right">{{number_format($planillatotal['pll_aport'],2)}}</td>
       </tr>
   </tbody>
</table>

<div style='page-break-after:always;'></div>

<div class="titulo">DETALLE DE APORTES - {{$planillatotal['pll_detalle']}}</div>
  
  <table class="tablarep">
   <thead>
       <tr>
          <th>Nº</th>
          <th>ENTIDAD</th>
          <th>CLASIFICADOR</th>
          <th>META</th>
          <th>MONTO DESCUENTO</th>
       </tr>
   </thead>
   <tbody>
      @foreach($dataDetalle as $datadescuentos)
       <tr>
            <td align="center"> {{++$loop->index}} </td>
            <td align="left">{{$datadescuentos->con_nombre}}</td>
            <td align="center">{{$datadescuentos->clasificador}}</td>
            <td align="center">{{$datadescuentos->meta}}</td>
            <td align="right">{{number_format($datadescuentos->monto,2)}}</td>
            
       </tr>
       @endforeach
       <tr class="totales">
           <td align="center" colspan="4">TOTAL</td>
           <td align="right">{{number_format($planillatotal['pll_aport'],2)}}</td>
       </tr>
   </tbody>
</table>

</body>

</html>