@extends('app')
@section('content')
    <div class="row">
        <div class="col-xs-offset-3 col-xs-6 col-sm-6 col-sm-offset-3">
            <h3 class="text-center">Registrar un nuevo usuario</h3>

            <div class="col-xs-12 separator bottom-buffer"></div>
            {!! Form::open(['url' => 'register','files' => true]) !!}
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        {!! Form::label('Nombre:') !!}
                        {!! Form::text('nombre','', ['placeholder' => 'Nombre', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        {!! Form::label('Imagen de perfil') !!}
                        {!! Form::file('avatar','', ['placeholder' => 'Imagen de perfil', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('Email:') !!}
                {!! Form::text('email','', ['placeholder' => 'Email', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Sobre mi:') !!}
                {!! Form::textarea('descripcion','', ['placeholder' => 'Acerca de mi', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Password:') !!}
                {!! Form::password('password',['placeholder' => 'Password', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::password('password_confirmation',['placeholder' => 'Confirmar Password', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="row">
                <div class="col-xs-6 col-xs-offset-6">
                    <div class="form-group">
                        {!! Form::submit('Ingresar',['class'=> 'btn btn-primary btn-block']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection