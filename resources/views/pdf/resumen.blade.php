<!DOCTYPE html>
<html>
<head>
  <title>Resumen</title>

  <meta http-equiv="content-type" content="text-html; charset=utf-8">

  <style type="text/css">

    html {
        margin: 0;
    }
    body {
        margin: 15mm 25mm;
    }

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
        border: 1px solid #ddd;
        padding: 2px;
        font-size: 12px;
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

  <div class="titulo">RESUMEN - {{$planillatotal['pll_detalle']}}</div>
  
  <table class="tablarep">
   <thead>
       <tr>
          <th>Nº</th>
          <th>CLASIFICADOR</th>
          <th>META</th>
          <th>MONTO BRUTO</th>
          <th>DESCUENTOS</th>
          <th>MONTO LIQUIDO</th>
          <th>APORTES</th>
       </tr>
   </thead>
   <tbody>
      @foreach($dataresumen as $dataresumen)
       <tr>
            <td align="center"> {{++$loop->index}} </td>
            <td align="center">{{$dataresumen->CLASIFICADOR}}</td>
            <td align="center">{{$dataresumen->META}}</td>
            <td align="right">{{number_format($dataresumen->TOTAL_BRUTO,2)}}</td>
            <td align="right">{{number_format($dataresumen->DESCUENTOS,2)}}</td>
            <td align="right">{{number_format($dataresumen->MONTO_LIQUIDO,2)}}</td>
            <td align="right">{{number_format($dataresumen->APORTES,2)}}</td>
       </tr>
       @endforeach
       <tr class="totales">
           <td align="center" colspan="3">TOTAL</td>
           <td align="right">{{number_format($planillatotal['pll_bruto'],2)}}</td>
           <td align="right">{{number_format($planillatotal['pll_desc'],2)}}</td>
           <td align="right">{{number_format($planillatotal['pll_liquido'],2)}}</td>
           <td align="right">{{number_format($planillatotal['pll_aport'],2)}}</td>
       </tr>
   </tbody>
</table>
<br>

</body>

</html>