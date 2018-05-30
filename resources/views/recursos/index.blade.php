@extends('app')

@section('content')
    <div class="page-header">
        <div class="btn-toolbar pull-right">
            <div class="btn-group">
                <button class="btn btn-primary registrar-recurso">
                    <span class="glyphicon glyphicon-plus"></span> Crear Recurso
                </button>
            </div>
        </div>
        <h3 class="header">Listado de Recursos</h3>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @if(count($recursos) > 0)
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($recursos as $recurso)
                        <tr class="recurso-row" data-id={!! $recurso->id !!}>
                            <td>
                                {!! $recurso->codigo !!}
                            </td>
                            <td>
                                {!! $recurso->nombre !!}
                            </td>
                            <td>
                                {!! $recurso->created_at !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{$recursos->links()}}

            @else
                <div class="col-xs-12 text-center buffer-top">
                    <small>No existen registros.</small>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('.recurso-row').on('click', function () {
                window.location.href = "{{\Illuminate\Support\Facades\URL::to('/recursos') . '/'}}" + $(this).data('id');
            });

            $('.registrar-recurso').on('click', function () {
                window.location.href = "{{\Illuminate\Support\Facades\URL::to('/recursos/nuevo')}}";
            });
        });
    </script>
@append