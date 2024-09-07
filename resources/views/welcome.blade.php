<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GesRem</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
         <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') }}">

        <!-- Styles -->
        <style>
        
            html, body {
                background-image: url(img/imgfondo.png);
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                color: #fff;
                font: 700 50px/1 "Oswald", sans-serif;
                letter-spacing: 0;
                padding: .25em 0 .325em;
                display: block;
                margin: 0 auto;
                text-shadow: 0 0 80px rgba(255,255,255,.5);
            }

            .links > a {
                text-decoration: none;
                padding: 10px;
                font-weight: 600;
                font-size: 15px;
                color: #ffffff;
                background-color: #2A3F54;
                border-radius: 6px;
                border: 2px solid #F7F7F7;
            }

            .links > a:hover{
                color: #1883ba;
                background-color: #ffffff;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Registro</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Aplicación Web de Gestión de Remuneraciones
                </div>

                <div class="links">
                    <a href="{{ route('login') }}">Ingresar a la Aplicación</a>
                </div>
            </div>
        </div>
    </body>
</html>