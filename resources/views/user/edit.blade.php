@extends('app')
@section('content')
    <?php $user = \Illuminate\Support\Facades\Auth::user()?>
    <div class="row">
        <div class="col-xs-offset-3 col-xs-6 col-sm-6 col-sm-offset-3">
            <h3 class="text-center">Registrar un nuevo usuario</h3>

            <div class="col-xs-12 separator bottom-buffer"></div>
            {!! Form::open(['url' => '/user','method' => 'PUT','files' => true]) !!}
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        {!! Form::label('Nombre:') !!}
                        {!! Form::text('nombre',$user->nombre, ['placeholder' => 'Nombre', 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    {!! Form::label('Imagen de perfil') !!}
                </div>
                <div class="col-xs-4">
                    @if(!empty($user->avatar))
                        <img src="{{$user->avatar}}" class="img-responsive"/>
                    @else
                        <small>Sin imagen de perfil</small>
                    @endif
                </div>
                <div class="col-xs-8">
                    <div class="form-group">
                        {!! Form::label('Cambiar') !!}
                        {!! Form::file('avatar','', ['placeholder' => 'Imagen de perfil', 'class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('Sobre mi:') !!}
                {!! Form::textarea('descripcion',$user->descripcion, ['placeholder' => 'Acerca de mi', 'class' => 'form-control']) !!}
            </div>
            @if(!$user->isAdmin())
                <div class="form-group">
                    {!! Form::label('Colegios:') !!}
                    {!! Form::text('colegios','',['placeholder' => 'Colegios', 'class' => 'form-control', 'id' => 'colegios-selectize', 'required' => 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Ramos:') !!}
                    {!! Form::text('ramos','',['placeholder' => 'Ramos', 'class' => 'form-control', 'id' => 'ramos-selectize', 'required' => 'required']) !!}
                </div>
            @endif
            <div class="row">
                <div class="col-xs-6 col-xs-offset-6">
                    <div class="form-group">
                        {!! Form::submit('Confirmar',['class'=> 'btn btn-primary btn-block']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('script')
    <script>

                @if(!$user->isAdmin())
                var loadSelectizeData = function () {
                    var colegiosSelectize = $('#colegios-selectize')[0].selectize;
                    var ramosSelectize = $('#ramos-selectize')[0].selectize;

                    var colegios = {!! json_encode($user->colegios) !!};
                    var ramos = {!! json_encode($user->ramos) !!};

                    for (var i = 0; i < colegios.length; i++) {
                        colegiosSelectize.addOption(colegios[i]);
                        colegiosSelectize.addItem(colegios[i].id);
                    }

                    for (var i = 0; i < ramos.length; i++) {
                        ramosSelectize.addItem(ramos[i].id);
                    }
                }

        $(function () {
            $('#colegios-selectize').selectize({
                valueField: 'id',
                searchField: ['nombre'],
                options: {!! json_encode($colegios) !!},
                render: {
                    option: function (item, escape) {
                        return '<div class="row">' +
                                '<div class="col-xs-12"><strong>' + escape(item.nombre) + '</strong></div>' +
                                '<div class="col-xs-12"><small>' + escape(item.direccion) + '</small></div>' +
                                '</div>';
                    },
                    item: function (item, escape) {
                        return '<div class="row">' +
                                '<div class="col-xs-12"><strong>' + escape(item.nombre) + '</strong></div>' +
                                '<div class="col-xs-12"><small>' + escape(item.direccion) + '</small></div>' +
                                '</div>';
                    }
                }/*,
                load: function (query, callback) {
                    if (!query.length)
                        return callback();
                    //Load the activities
                    $.ajax({
                        url: "{{URL::to('/colegios/search')}}" + '/q=' + query,
                        type: 'GET',
                        success: function (r) {
                            return callback(r);
                        }
                    });
                }*/
            });

            $('#ramos-selectize').selectize({
                valueField: 'id',
                labelField: 'nombre',
                options: {!! json_encode($ramos) !!}


            });

            loadSelectizeData();
            @endif

        });
    </script>
@append