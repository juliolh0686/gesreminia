<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GesRem') }}</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    
    <script src="https://kit.fontawesome.com/d729663d22.js" crossorigin="anonymous"></script>
    
    <!-- NProgress -->
    <link rel="stylesheet" href="{{ asset('gentelella/vendors/nprogress/nprogress.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('gentelella/vendors/iCheck/skins/flat/green.css') }}">
    <!-- bootstrap-progressbar -->
    <link rel="stylesheet" href="{{ asset('gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('gentelella/vendors/jqvmap/dist/jqvmap.min.css') }}">
    <!-- bootstrap-daterangepicker -->
    <link rel="stylesheet" href="{{ asset('gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap-wysiwyg -->
    <link rel="stylesheet" href="{{ asset('gentelella/vendors/google-code-prettify/bin/prettify.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('gentelella/vendors/select2/dist/css/select2.min.css') }}">
     <!-- Switchery -->
     <link rel="stylesheet" href="{{ asset('gentelella/vendors/switchery/dist/switchery.min.css') }}">
     <!-- starrr -->
     <link rel="stylesheet" href="{{ asset('gentelella/vendors/starrr/dist/starrr.css') }}">
    <!-- jQuery custom content scroller -->
    <link rel="stylesheet" rel="stylesheet" href="{{ asset('gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}">

    <!-- Chart.js -->
    <script src="{{ asset('gentelella/vendors/Chart.js/dist/Chart.min.js') }}"></script>

    <!-- Custom Theme Style -->
    <link rel="stylesheet" rel="stylesheet" href="{{ asset('gentelella/build/css/custom.css') }}">

    <!-- Estilos adicionales -->
    <link rel="stylesheet" rel="stylesheet" href="{{ asset('css/plantilla.css') }}">


  </head>

  <body class="nav-md footer_fixed">
  <div id="app">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{route('home')}}" class="site_title"><i class="fa-solid fa-person-shelter"></i><span> &nbsp;&nbsp;GESREM</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{ asset('gentelella/images/user.png')}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2>{{auth()->user()->name}}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
                 @include('plantilla.sidebar')
            <!-- /sidebar menu -->

            
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    {{auth()->user()->name}}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Perfil</a></li>
                    <li><a href="javascript:;">Ayuda</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i>Salir</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                    </form>
                  </ul>
                </li>

                
              </ul>
            </nav>
          </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
           @yield('contenido')
        <!-- /page content -->

</div>
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Creado por<a href="http://www.julioloarte.com/" target="_blank"> Julio Loarte Huerto</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>


    <script src="js/app.js"></script>
    
    <!-- jQuery -->
    <script src="{{ asset('gentelella/vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('gentelella/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('gentelella/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('gentelella/vendors/nprogress/nprogress.js') }}"></script>
     
    <!-- jQuery Sparklines -->
    <script src="{{ asset('gentelella/vendors/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
      <!-- gauge.js -->
    <script src="{{ asset('gentelella/vendors/gauge.js/dist/gauge.min.js') }}"></script>
     <!-- bootstrap-progressbar -->
    <script src="{{ asset('gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('gentelella/vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('gentelella/vendors/skycons/skycons.js') }}"></script>
     <!-- Flot -->
     <script src="{{ asset('gentelella/vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('gentelella/vendors/DateJS/build/date.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('gentelella/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('gentelella/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- jQuery custom content scroller -->
    <script src="{{ asset('gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>


    <!-- Custom Theme Scripts -->
    <script src="{{ asset('gentelella/build/js/custom.js') }}"></script>
    
    
    <script src="js/plantilla.js"></script>


  </body>
</html>