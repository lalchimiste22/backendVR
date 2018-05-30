@extends('app')
@section('content')
<div class="row">
    <div class="col-xs-offset-3 col-xs-6 col-sm-6 col-sm-offset-3">
        <div class="text-center">
            <!--<img class="logo" src="{{asset('img/logo.png')}}"/>-->
        </div>
        <h3 class="text-center">Bienvenido a VRForKids</h3>
        <div class="col-xs-12 separator bottom-buffer"></div>
        {!! Form::open(['url' => 'login']) !!}
        <div class="form-group">
            {!! Form::text('email','', ['placeholder' => 'Email', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::password('password',['placeholder' => 'Password', 'class' => 'form-control']) !!}
        </div>
        <div class="row">
            <div class="col-xs-6 col-xs-offset-6">
                <div class="form-group">
                    {!! Form::submit('Ingresar',['class'=> 'btn btn-primary btn-block']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="col-xs-12 separator bottom-buffer"></div>
        <div class="col-xs-12 text-right">
            <span>¿No tienes una cuenta? <a href="/register">Registrate</a></span>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(function(){
            $('body').addClass('login');
        });
    </script>
@append