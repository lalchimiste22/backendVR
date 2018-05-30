@extends('app')

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <h3>Sobreescribir Recurso</h3>
            {!! Form::open(['url' => '/user/overrides']) !!}
            <div class="form-group">
                {!! Form::label('Jugadores Afectados') !!}
                {!! Form::text('jugadores','',['placeholder' => 'Jugadores', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Recurso a Sobreescribir') !!}
                {!! Form::select('recurso_id',[],null,['data-placeholder' => 'Recurso', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Nombre') !!}
                {!! Form::text('nombre','',['placeholder' => 'Nombre', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Descripción') !!}
                {!! Form::textarea('descripcion','',['placeholder' => 'Descripción', 'class' => 'form-control', 'rows' => '5','required' => 'required']) !!}
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-8">
                    {!! Form::submit('Sobreescribir',['class'=>'btn btn-primary btn-block']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $('input[name="jugadores"]').selectize({
                        valueField: 'id',
                        labelField: 'nombre',
                        options:{!! $jugadores !!}
                    }
            );

            var overrides = {!! $overrides->keyBy('id') !!};
            $('select[name="recurso_id"]').selectize({
                        valueField: 'id',
                        labelField: 'codigo',
                        options:{!! $overrides !!},
                        onChange: function(value){
                            actualizarCampos(value);
                        }
                    }
            );

            function actualizarCampos(overrideId) {
                var r = overrides[overrideId];
                $('input[name="nombre"]').val(r.nombre);
                $('textarea[name="descripcion"]').val(r.descripcion);
            }
        });
    </script>
@append