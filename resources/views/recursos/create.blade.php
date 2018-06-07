@extends('app')

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <h3>Registrar Nueva Recurso</h3>
            {!! Form::open(['url' => '/recursos']) !!}
            <div class="form-group">
                {!! Form::label('Código') !!}
                {!! Form::text('codigo','',['placeholder' => 'Código', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Nombre') !!}
                {!! Form::text('nombre','',['placeholder' => 'Nombre', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Descripción') !!}
                {!! Form::textarea('descripcion','',['placeholder' => 'Descripción', 'class' => 'form-control', 'rows' => '5']) !!}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-group contenidos">
                        <li class="list-group-item add agregar-contenido">
                            <span class="glyphicon glyphicon-plus-sign"></span> Contenido
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-8">
                    {!! Form::submit('Registrar',['class'=>'btn btn-primary btn-block']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@include('recursos.script')