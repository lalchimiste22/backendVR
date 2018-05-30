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
        <h3 class="header">Detalles de Recurso Sobreescrito</h3>
    </div>
    <div class="row">
        <div class="col-xs-2 text-right">
            <strong>Código:</strong>
        </div>
        <div class="col-xs-10 text-left">
            {{$override->recurso->codigo}}
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2 text-right">
            <strong>Nombre:</strong>
        </div>
        <div class="col-xs-10 text-left">
            {{$override->nombre}}
        </div>
    </div>
    <div class="row buffer-top-small">
        <div class="col-xs-2 text-right">
            <strong>Descripción:</strong>
        </div>
        <div class="col-xs-10 text-left">
            {{nl2br($override->descripcion)}}
        </div>
    </div>
    <div class="row buffer-top-small">
        <div class="col-xs-2 text-right">
            <strong>Jugadores Afectados:</strong>
        </div>
        <div class="col-xs-10 text-left">
            @foreach($override->jugadores as $j)
                <div class="col-xs-2 infobox">
                    <strong>{{$j->nombre}}</strong>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            $('.edit').on('click', function () {
                window.location.href = "{{\Illuminate\Support\Facades\URL::to('/user/overrides/' . $override->id . '/editar')}}";
            });

            $('.modal-delete-confirm').on('click', function () {
                $.ajax("{{\Illuminate\Support\Facades\URL::to('/user/overrides/' . $override->id)}}", {
                    'method': 'DELETE',
                    'data': {
                        '_token': "{{ csrf_token() }}"
                    },
                    'success': function () {
                        window.location.href = "{{\Illuminate\Support\Facades\URL::to('/user/overrides')}}";
                    }
                });
            });
        });
    </script>
@endsection