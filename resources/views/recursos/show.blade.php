@extends('app')
@section('content')
    @include('tools.delete_modal')
    <div class="page-header">
        <div class="btn-toolbar pull-right">
            <div class="btn-group">
                <button class="btn btn-primary edit">Editar</button>
                <button class="btn btn-danger delete" data-toggle="modal" data-target="#modal-delete">Eliminar</button>
            </div>
        </div>
        <h3 class="header">Detalles de Recurso</h3>
    </div>
    <div class="row">
        <div class="col-xs-2 text-right">
            <strong>Código:</strong>
        </div>
        <div class="col-xs-10 text-left">
            {{$recurso->codigo}}
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2 text-right">
            <strong>Nombre:</strong>
        </div>
        <div class="col-xs-10 text-left">
            {{$recurso->nombre}}
        </div>
    </div>
    <div class="row buffer-top-small">
        <div class="col-xs-2 text-right">
            <strong>Descripción:</strong>
        </div>
        <div class="col-xs-10 text-left">
            {{nl2br($recurso->descripcion)}}
        </div>
    </div>

    <h3>Contenidos:</h3>

    <div class="row">
        <div class="col-md-12">
            @if(count($recurso->contenidos) === 0)
                <small>No hay contenido agregado.</small>
            @else
                <ul class="list-group">
                    @foreach($recurso->contenidos as $c)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-2">
                                    <small>{{$c->tipo}}</small>
                                </div>
                                <div class="col-md-10">
                                    <span>{{$c->data}}</span>

                                    @if($c->tipo === 'pregunta')
                                        <hr/>
                                        <small>Opciones:</small>
                                        <ul class="list-group">
                                            @foreach($c->opciones as $o)
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            {{$o->data}}
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span class="glyphicon {{$o->correcto ? 'glyphicon-check' : 'glyphicon-unchecked'}}"></span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            $('.edit').on('click', function () {
                window.location.href = "{{\Illuminate\Support\Facades\URL::to('/recursos/' . $recurso->id . '/editar')}}";
            });

            $('.modal-delete-confirm').on('click', function () {
                $.ajax("{{\Illuminate\Support\Facades\URL::to('/recursos/' . $recurso->id)}}", {
                    'method': 'DELETE',
                    'data': {
                        '_token': "{{ csrf_token() }}"
                    },
                    'success': function () {
                        window.location.href = "{{\Illuminate\Support\Facades\URL::to('/recursos')}}";
                    }
                });
            });
        });
    </script>
@endsection