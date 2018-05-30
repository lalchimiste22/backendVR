@extends('user.wrapper')
@section('nav-content')
    <div class="row">
        <div class="page-header">
            <div class="btn-toolbar pull-right">
                <div class="btn-group">
                    <button class="btn btn-primary registrar-recurso">
                        <span class="glyphicon glyphicon-plus"></span> Sobreescribir Recurso
                    </button>
                </div>
            </div>
            <h3 class="header">Mis Recursos Sobreescritos</h3>
        </div>
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    @if(count($overrides) > 0)
                        <table class="table table-responsive table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Jugadores</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($overrides as $override)
                                <tr class="override-row" data-id={!! $override->id !!}>
                                    <td>
                                        {!! $override->recurso->codigo !!}
                                    </td>
                                    <td>
                                        {!! $override->nombre !!}
                                    </td>
                                    <td>
                                        {!! implode(',',$override->jugadores->pluck('nombre')->all()) !!}
                                    </td>
                                    <td>
                                        {!! $override->created_at !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{$overrides->links()}}

                    @else
                        <div class="col-xs-12 text-center buffer-top">
                            <small>No existen registros.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function(){
            $('.override-row').on('click', function () {
                window.location.href = "{{\Illuminate\Support\Facades\URL::to('/user/overrides') . '/'}}" + $(this).data('id');
            });

            $('.registrar-recurso').on('click',function(){
                window.location.href = "{{  URL::to('/') . '/user/overrides/nuevo' }}"
            });
        });
    </script>
@endsection