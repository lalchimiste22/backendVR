@extends('user.wrapper')
@section('nav-content')
    <?php $user = Auth::user();?>
    <div class="row">
        <div class="col-xs-8 profile-info">
            <div class="row">
                <div class="col-xs-12">
                    <!--<strong>Nombre: </strong>-->
                    <h2><strong>{{$user->nombre}} <a href="/user/edit" class="edit"><span
                                        class="glyphicon glyphicon-cog"></span></a></strong></h2>
                </div>
                @if(!\Auth::user()->isAdmin())
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-1">
                            <strong>Colegios:</strong>
                        </div>
                        <div class="col-xs-11">
                            <?php $i = \Auth::user()->colegios->count();?>
                            @foreach(\Auth::user()->colegios as $colegio)
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <span> {{$i > 0 ? '- ' : ''}}{{$colegio->nombre}}</span>
                                        </div>
                                        <!--<div class="col-xs-12">
                                            <span>{{$colegio->direccion}}</span>
                                        </div>-->
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-1">
                            <strong>Ramos:</strong>
                        </div>
                        <div class="col-xs-11">
                            <?php $i = \Auth::user()->ramos->count();?>
                            @foreach(\Auth::user()->ramos as $ramo)
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <span> {{$i > 0 ? '- ' : ''}}{{$ramo->nombre}}</span>
                                        </div>
                                        <!--<div class="col-xs-12">
                                            <span>{{$ramo->descripcion}}</span>
                                        </div>-->
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-xs-12">
                    <div class="inline-flex">
                        <strong>Sobre mi:</strong>
                    </div>
                    <div class="inline-flex text-justify" style="margin-left:10px;">
                        @if(!empty($user->descripcion))
                            {!! nl2br($user->descripcion) !!}
                        @else
                            <small>No hay nada aquí...</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-4 text-center profile-info">
            @if(!empty($user->avatar))
                <img class="img-responsive img-circle user-avatar" src="{{$user->avatar}}"/>
            @else
                <div class="buffer-top">
                    <small>Sin imágen de perfil</small>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {

            $('.edit').on('click', function () {
                window.location.href = "{{URL::to('/user/edit')}}";
            });
        });
    </script>
@append