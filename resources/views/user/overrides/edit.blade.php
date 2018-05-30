@extends('app')

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <h3>Actualizar Recurso</h3>
            {!! Form::open(['url' => '/user/overrides/' . $override->id, 'method' => 'put']) !!}
            <div class="form-group">
                {!! Form::label('Jugadores Afectados') !!}
                {!! Form::text('jugadores','',['placeholder' => 'Jugadores', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Nombre') !!}
                {!! Form::text('nombre',$override->nombre,['placeholder' => 'nombre', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Descripción') !!}
                {!! Form::textarea('descripcion',$override->descripcion,['placeholder' => 'Descripción','rows' => '5', 'class' => 'form-control']) !!}
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
@section('script')
    <script>
        $(function () {
            var $jugadoresSel = $('input[name="jugadores"]').selectize({
                        valueField: 'id',
                        labelField: 'nombre',
                        options:{!! $jugadores !!},
                        onChange: function (value) {
                            actualizarCampos(value);
                        }
                    }
            );

            var selectize = $jugadoresSel[0].selectize;
            @foreach($override->jugadores as $j)
                selectize.addItem({{$j->id}});
            @endforeach
        });
    </script>
@append