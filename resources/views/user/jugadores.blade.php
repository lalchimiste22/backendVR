
@extends('user.wrapper')
@section('nav-content')
    <div class="row">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <div class="btn-group">
                    <button class="btn btn-primary registrar-jugador">
                        <span class="glyphicon glyphicon-plus"></span> Crear Jugador
                    </button>
                </div>
            </div>
            <h3 class="header">Jugadores Asociados</h3>
        </div>
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="list-group">
                        @foreach($jugadores as $jugador)
                            <a href="{{URL::to('/user/jugadores/' . $jugador->id)}}"><li class="list-group-item col-xs-4 card"><strong>{{$jugador->codigo}}</strong> <br> {{$jugador->nombre}}</li></a>
                        @endforeach
                    </ul>
                    {{$jugadores->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function(){
            $('.registrar-jugador').on('click',function(){
                window.location.href = "{{  URL::to('/') . '/user/jugadores/nuevo' }}"
            });
        });
    </script>
@endsection