<!DOCTYPE html>
<html>
<head>
  <title>Reporte Personal</title>

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

  <div class="titulo">DETALLE DE DESCUENTO DE AFP PLANILLA CAS - PERIODO: {{$planillatotal['pll_periodo']}}</div>
  
  <table class="tablarep">
   <thead>
       <tr>
          <th>Nº</th>
          <th>ADMINISTRADOR DE PENSIONES</th>
          <th>CLASIFICADOR</th>
          <th>META</th>
          <th>MONTO</th>
       </tr>
   </thead>
   <tbody>
    @php
        $totalafp = 0;
    @endphp

      @foreach($dataafpresumen as $dataafpresumen)
       <tr>
            <td align="center"> {{++$loop->index}} </td>
            <td align="left">{{$dataafpresumen->det_resumen}}</td>
            <td align="right">{{$dataafpresumen->clasificador}}</td>
            <td align="right">{{$dataafpresumen->meta}}</td>
            <td align="right">{{number_format($dataafpresumen->monto,2)}}</td>
            @php
                $totalafp = $totalafp+$dataafpresumen->monto;
            @endphp
       </tr>
       @endforeach
       <tr class="totales">
           <td align="center" colspan="4">TOTAL</td>
           <td align="right">{{number_format($totalafp,2)}}</td>
       </tr>
   </tbody>
</table>
<br>
<div class="detalle">DETALLE: 
{{$planillatotal['pll_detalle']}}
</div>

  

</body>

</html>