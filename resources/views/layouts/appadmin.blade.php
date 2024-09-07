<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GESREM</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

  </head>

  <body>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation"><a href="{{route('users.index')}}">Usuarios</a></li>
            <li role="presentation"><a href="{{route('roles.index')}}">Roles</a></li>
            <li role="presentation"><a href="{{route('home')}}">Retornar Aplicación</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Administración de Usuarios y Roles</h3>
      </div>

      

      <div class="row marketing">
        <div class="col-lg-12">
        @yield('content')
        </div>
       
      </div>

      <footer class="footer">
        <p>JCreativos - Julio Loarte Huerto</p>
      </footer>

    </div> <!-- /container -->
  

</body></html>
