@extends('principal')

@section('contenido')
<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Usuario<small> / Editar</small></h3>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="">
                      @include('users.partials.form')
                    </form>
                  {{-- {!! Form::model($user,['route'=>['users.update',$user->id],'method'=>'PUT']) !!}
                        @include('users.partials.form')
                    {!! Form::close() !!}  --}}
                </div>
                </div>

                </div>
                </div>
            
          </div>
        </div>

@endsection