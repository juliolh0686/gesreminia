<!DOCTYPE html>
<html>
<head>
  <title>Reporte Personal</title>

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
        border: 1px solid #ddd;
        padding: 4px;
        font-size: 8px;
    }

    .tablarep tr:nth-child(even){background-color: #f2f2f2;}

    .tablarep tr:hover {background-color: #ddd;}

    .tablarep th {
        padding-top: 8px;
        padding-bottom: 8px;
        text-align: center;
        background-color: #4CAF50;
        font-size: 10px;
        color: white;
}
  </style>
</head>

<body>

  <div class="titulo">DESCUENTO JUDICIAL - {{$planilla->pll_detalle}} </div> 
  
  <table class="tablarep">
   <thead>
       <tr>
          <th>N°</th>
          <th>APE_PATERNO</th>
          <th>APE_MATERNO</th>
          <th>NOMBRES</th>
          <th>NUM_DOC</th>
          <th>RESOLUCION JUDICIAL</th>
          <th>FECHA_RES_JUD</th>
          <th>M_FIJO</th>
          <th>PORCENTAJE</th>
          <th>MONTO</th>
          <th>CUENTA</th>
          <th>OBSERVACION</th>
       </tr>
   </thead>
   <tbody>

      @foreach($planillajudicial as $judicial)
       <tr>
           <td align="center"> {{++$loop->index}}</td>
           <td> {{$judicial->b_paterno}} </td>
           <td> {{$judicial->b_materno}} </td>
           <td> {{$judicial->b_nombres}} </td>
           <td> {{$judicial->b_numdoc}} </td>
           <td> {{$judicial->b_resjudicial}} </td>
           <td> {{$judicial-> b_fechjudicial}} </td>
           <td> {{$judicial->b_fijo}} </td>
           <td> {{$judicial->b_porcentaje}} </td>
           <td> {{$judicial->b_cuenta}} </td>
           <td> {{$judicial->pj_monto}} </td>
           <td> {{$judicial->b_observacion}} </td>
       </tr>
       @endforeach
   </tbody>
</table>

  

</body>

</html>