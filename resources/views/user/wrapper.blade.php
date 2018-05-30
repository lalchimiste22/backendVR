@extends('app')
@section('content')
    <div class="row">
        <ul id="tab-view" class="nav nav-tabs">
            <li class="{{Request::is('user/profile') ? 'active' : ''}}">
                <a class="tab-trigger" data-target="profile-wrapper" href="/user/profile">Mi Perfil</a>
            </li>
            <li class="{{Request::is('user/jugadores') ? 'active' : ''}}">
                <a class="tab-trigger" data-target="recurso-wrapper" href="/user/jugadores">Jugadores Asociados</a>
            </li>
            <li class="{{Request::is('user/overrides') ? 'active' : ''}}">
                <a class="tab-trigger" data-target="recurso-wrapper" href="/user/overrides">Mis recursos</a>
            </li>
        </ul>

        <div class="col-xs-12">
            @yield('nav-content')
        </div>
    </div>
@endsection