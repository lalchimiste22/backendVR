@extends('app')

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <h3>Actualizar Jugador</h3>
            {!! Form::open(['url' => '/user/jugadores/' . $jugador->id, 'method' => 'put']) !!}
            <div class="form-group">
                {!! Form::label('Nombre') !!}
                {!! Form::text('nombre',$jugador->nombre,['placeholder' => 'nombre', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Descripción') !!}
                {!! Form::textarea('descripcion',$jugador->descripcion,['placeholder' => 'Descripción', 'class' => 'form-control']) !!}
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-8">
                    {!! Form::submit('Actualizar',['class'=>'btn btn-primary btn-block']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection