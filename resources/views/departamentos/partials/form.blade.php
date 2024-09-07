<div class="form-group">
    {{ Form::label('dep_departamento','Nombre del Departamento') }}
    {{ Form::text('dep_departamento',null,['class'=>'form-control']) }}
</div>
<div class="form-group">
    {{ Form::submit('Guardar',['class'=>'btn btn-sm btn-primary']) }}
</div>
