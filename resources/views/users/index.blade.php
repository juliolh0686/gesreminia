@extends('principal')

@section('contenido')
<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Usuarios<small> / Lista de Usuarios</small></h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">ID</th>
                            <th class="column-title">Apellidos y Nombres</th>
                            <th class="column-title">Nombre de usuario</th>
                            <th class="column-title">Correo</th>
                            <th class="column-title no-link last"  colspan="3"><span class="nobr">Acción</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        @foreach($user as $users)
                          <tr class="even pointer">
                            <td class=" ">{{$users->id}}</td>
                            <td class=" ">{{$users->name}}</td>
                            <td class=" ">{{$users->username}}</td>
                            <td class=" ">{{$users->email}}</td>
                            <td width="10px">
                            @can('users.show')
                            <a href="{{route('users.show',$users->id)}}" class="btn btn-info btn-sm">Ver</a>
                            @endcan
                            </td>
                            <td width="10px">
                            @can('users.edit')
                            <a href="{{route('users.edit',$users->id)}}" class="btn btn-primary btn-sm">Editar</a>
                            @endcan
                            </td>
                            <td width="10px">
                            @can('users.destroy')
                            
                            @endcan
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{$user->render()}}
                    </div>
							
						
                  </div>

                </div>

                </div>
                </div>
            
          </div>
        </div>

@endsection
