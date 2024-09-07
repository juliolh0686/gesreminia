@extends('principal')

@section('contenido')
<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                  <div class="x_title">
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <div class="panel panel-info">
                  <div class="panel-heading">Detalle de Usuario</div>
                  <div class="panel-body">
                  <p><strong>Apellidos y Nombres: </strong>{{$user->name}}</p>
                  <p><strong>Nombre de Usuario: </strong>{{$user->username}}</p>
                  <p><strong>Correo: </strong>{{$user->email}}</p>
                  </div>
                  <div class="panel-footer">
                  <a href="{{route('users.index')}}" class="btn btn-primary btn-sm">Retornar</a>
                  </div>
                </div>

                </div>
                </div>

                </div>
                </div>
            
          </div>
        </div>

@endsection
