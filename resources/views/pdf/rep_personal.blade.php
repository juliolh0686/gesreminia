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

  <div class="titulo">REPORTE DE PERSONAL</div>
  
  <table class="tablarep">
   <thead>
       <tr>
          <th>N°</th>
          <th>COD_PERSONAL</th>
          <th>N_DOCUMENTO</th>
          <th>APE_PATERNO</th>
          <th>APE_MATERNO</th>
          <th>NOMBRES</th>
          <th>F_NAC</th>
          <th>SEXO</th>
          <th>E_CIVIL</th>
          <th>RUC</th>
          <th>DIRECCION</th>
          <th>CORREO</th>
          <th>TELEFONO</th>
          <th>CELULAR</th>
          <th>REG_PENSION</th>
          <th>CUSPP</th>
          <th>F_AFILIACION</th>
          <th>BANCO</th>
          <th>CUENTA</th>
       </tr>
   </thead>
   <tbody>
      @foreach($personal as $rpersonal)
       <tr>
           <td align="center"> {{++$loop->index}} </td>
           <td> {{$rpersonal->cod_personal}} </td>
           <td> {{$rpersonal->p_num_doc}} </td>
           <td> {{$rpersonal->p_a_paterno}} </td>
           <td> {{$rpersonal->p_a_materno}} </td>
           <td> {{$rpersonal->p_nombres}} </td>
           <td> {{$rpersonal-> p_fech_nac}} </td>
           <td> {{$rpersonal->sexo_cod_sexo}} </td>
           <td> {{$rpersonal->estado_civil_cod_estado_civil}} </td>
           <td> {{$rpersonal->p_ruc}} </td>
           <td> {{$rpersonal->p_direccion}} </td>
           <td> {{$rpersonal->p_correo}} </td>
           <td> {{$rpersonal->p_telefono}} </td>
           <td> {{$rpersonal->p_celular}} </td>
           <td> {{$rpersonal->admin_pension_cod_admin_pension}} </td>
           <td> {{$rpersonal->p_cuspp}} </td>
           <td> {{$rpersonal->p_fech_afiliacion}} </td>
           <td> {{$rpersonal->banco_cod_banco}} </td>
           <td> {{$rpersonal->p_num_cuenta}} </td>
       </tr>
       @endforeach
   </tbody>
</table>

  

</body>

</html>