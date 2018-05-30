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
        <h3 class="header">Detalles de Jugador</h3>
    </div>
    <div class="row">
        <div class="col-xs-2 text-right">
            <strong>Código:</strong>
        </div>
        <div class="col-xs-10 text-left">
            {{$jugador->id}}
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2 text-right">
            <strong>Nombre:</strong>
        </div>
        <div class="col-xs-10 text-left">
            {{$jugador->nombre}}
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function () {
            $('.edit').on('click', function () {
                window.location.href = "{{\Illuminate\Support\Facades\URL::to('/user/jugadores/' . $jugador->id . '/editar')}}";
            });

            $('.modal-delete-confirm').on('click', function () {
                $.ajax("{{\Illuminate\Support\Facades\URL::to('/user/jugadores/' . $jugador->id)}}", {
                    'method': 'DELETE',
                    'data': {
                        '_token': "{{ csrf_token() }}"
                    },
                    'success': function () {
                        window.location.href = "{{\Illuminate\Support\Facades\URL::to('/user/jugadores')}}";
                    }
                });
            });
        });
    </script>
@endsection