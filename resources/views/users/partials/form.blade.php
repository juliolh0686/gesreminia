<div class="form-group">
  <label for="name">Apellidos y Nombres</label>
  <input type="text" id="name" name="name" value="{{$user->name}}" class="form-control">
</div>
<div class="form-group">
  <label for="username">Nombre de Usuario</label>
  <input type="text" id="username" name="username" value="{{$user->username}}" class="form-control">
</div>
<div class="form-group">
  <label for="email">Correo Electrónico</label>
  <input type="text" id="email" name="email" value="{{$user->email}}" class="form-control">
</div>
<hr>
<h3>Lista de Roles</h3>
<div class='form-group'>
<ul class='list-unstyled'>
    @foreach($roles as $role)
        <li>
            <label>
              <input type="checkbox" name="{{$roles}}" value="{{$role->id}}">
                {{--{{ Form::checkbox('roles[]',$role->id,null) }} --}}
                {{ $role->name }}
                <em>({{$role->description ?: 'Sin descripcion'}})</em>
            </label>
        </li>
    @endforeach
</ul>
</div>

<div class="form-group">
   {{-- {{ Form::submit('Guardar',['class'=>'btn btn-sm btn-primary']) }} --}}
</div>

<label>
