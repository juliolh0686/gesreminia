@extends('layouts.appadmin')

@section('content')
<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Roles<small>/Lista de Roles</small></h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                @can('roles.create')
                <a href="{{route('roles.create')}}" class="btn btn-primary float-right">Crear</a>
                @endcan

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">ID</th>
                            <th class="column-title">Role</th>
                            <th class="column-title no-link last"  colspan="3"><span class="nobr">Action</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        @foreach($rol as $roles)
                          <tr class="even pointer">
                            <td class=" ">{{$roles->id}}</td>
                            <td class=" ">{{$roles->name}}</td>
                            <td width="10px">
                            @can('roles.show')
                            <a href="{{route('roles.show',$roles->id)}}" class="btn btn-info btn-sm">Ver</a>
                            @endcan
                            </td>
                            <td width="10px">
                            @can('roles.edit')
                            <a href="{{route('roles.edit',$roles->id)}}" class="btn btn-primary btn-sm">Editar</a>
                            @endcan
                            </td>
                            <td width="10px">
                            @can('roles.destroy')         
                            {!! Form::open(['route'=>['roles.destroy',$roles->id],'method'=>'DELETE']) !!}
                            {{ Form::submit('Eliminar',['class'=>'btn btn-sm btn-danger']) }}
                            {!! Form::close() !!}
                            @endcan
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{$rol->render()}}
                    </div>
							
						
                  </div>

                </div>

                </div>
                </div>
            
          </div>
        </div>
@endsection
