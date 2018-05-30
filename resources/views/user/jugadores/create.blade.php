@extends('app')

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <h3>Crear Jugador</h3>
            {!! Form::open(['url' => '/user/jugadores']) !!}
            <div class="form-group">
                {!! Form::label('Nombre') !!}
                {!! Form::text('nombre','',['placeholder' => 'Nombre', 'class' => 'form-control', 'required' => 'required']) !!}
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