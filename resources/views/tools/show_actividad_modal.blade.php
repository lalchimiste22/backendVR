<?php
$data = isset($data) ? $data : [];
?>
<div id="{{array_get($data,'id','modal-detail')}}" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 70vw; height: 70vh;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center">Cargando...</h2>
                <h5 class="modal-subtitle text-center"></h5>
                <input type="hidden" class="handler"/>
            </div>
            <div class="a-previous">
                <img src="{{asset('img/previous.png')}}"/>
            </div>
            <div class="a-next">
                <img src="{{asset('img/forward.png')}}"/>
            </div>
            <div class="modal-body">
                <div class="data-loading">
                    <div class="loader"></div>
                    <div class="text-center">
                        <small>Cargando datos...</small>
                    </div>
                </div>
                <div class="actividad-data" style="display:none;">
                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-4">
                            <img class="img-responsive img-rounded avatar" src=""/>

                            <div class="detalles">
                                <div class="buffer-top-small row">
                                    <div class="col-xs-3 text-right">
                                        <strong>Unidades Didacticas</strong>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="row unidades"></div>
                                    </div>
                                </div>
                                <div class="buffer-top-small row">
                                    <div class="col-xs-3 text-right">
                                        <strong>Seccion</strong>
                                    </div>
                                    <div class="col-xs-9 text-left seccion">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-offset-1 col-xs-2 bloque-detalles">
                            <div class="buffer-top-small">
                                <strong class="titulo">Materiales</strong>

                                <div class="col-xs-10 col-xs-offset-1 herramientas">
                                </div>
                            </div>
                            <hr>
                            <div class="buffer-top">
                                <strong class="titulo">Recursos</strong>

                                <div class="col-xs-10 col-xs-offset-1 recursos">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row actividad-body">
                        <div class="col-xs-12 buffer-top-small">
                            <h4>Descripción</h4>

                            <p style="padding-left: 15px;" class="descripcion">
                            </p>
                            <h4 class="buffer-top-medium">Instrucciones</h4>
                            <ul class="list-group instrucciones">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        var lastPage = {{array_get($data,'lastPage',1)}};
        var currentPage = {{array_get($data,'currentPages',1)}};

        //Arreglo con indices de actividades
        var _actividades = [];
        var _currentIndex = 0;

        var fillData = function (data) {
            var unidadTemplate = '<div class="col-xs-12">' +
                    '<div class="row">' +
                    '<div class="col-xs-12">' +
                    '<strong class="unombre"></strong>' +
                    '</div>' +
                    '<div class="col-xs-12">' +
                    '<span class=udetalle></span>' +
                    '</div>' +
                    '</div>';

            var instruccionTemplate = '<li class="list-group-item list-group-item-light">' +
                    '<div class="row">' +
                    '<div class="col-xs-2 text-center">' +
                    '<img class="img-responsive" src=""/>' +
                    '<small>Sin imágen asociada</small>' +
                    '</div>' +
                    '<div class="col-xs-10">' +
                    '<span class="inombre"></span>' +
                    '</div>' +
                    '</div>' +
                    '</li>';

            var recursoTemplate = '<div><a href=""></a></div>';

            $this = $("#{{array_get($data,'id','modal-select')}}");

            var titulo = data.nombre;

            @if(\Illuminate\Support\Facades\Auth::check())
                titulo += data.user.id == "{{\Illuminate\Support\Facades\Auth::user()->id}}" || data.user.id == 1 ? ' <a href="/actividades/' + data.id + '/editar"><span class="glyphicon glyphicon-cog danger"></span>' : '';
            @endif

            $this.find('.avatar').attr('src', data.avatar);
            $this.find('.modal-title').html(titulo);
            $this.find('.modal-subtitle').text('Creado por ' + data.user.nombre);
            $this.find('.seccion').text(data.seccion.ucfirst());
            $this.find('.herramientas').text(data.herramientas);
            $this.find('.descripcion').html(data.objetivos.nl2br());

            var $recursos = $this.find('.recursos');
            $recursos.html('');
            for (var i = 0; i < data.recursos.length; i++) {
                var recurso = data.recursos[i];

                var $template = $(recursoTemplate);
                $template.find('a').attr('href', recurso.archivo != null ? recurso.archivo : recurso.url);
                $template.find('a').text(recurso.nombre);

                $recursos.append($template);
            }

            var $instrucciones = $this.find('.instrucciones');
            $instrucciones.html('');
            for (i = 0; i < data.instrucciones.length; i++) {
                var instruccion = data.instrucciones[i];
                var $template = $(instruccionTemplate);

                //Poner imagen
                if (instruccion.imagen != null) {
                    $template.find('small').remove();
                    $template.find('img').attr('src', instruccion.imagen);
                }
                else {
                    $template.find('img').remove();
                }

                $template.find('.inombre').text(instruccion.nombre);

                $instrucciones.append($template);
            }

            var $unidades = $this.find('.unidades');
            $unidades.html('');
            for (var i = 0; i < data.unidades.length; i++) {
                var unidad = data.unidades[i];
                var $template = $(unidadTemplate);

                $template.find('.unombre').text(unidad.nombre);
                $template.find('.udetalle').text(unidad.asignacion.ramo.nombre + ' - ' + unidad.asignacion.curso.nombre);

                $unidades.append($template);
            }

            //Unidad.nombre, $unidad.asignacion.ramo.nombre + ' - ' + $unidad.asignacion.curso.nombre

            $this.find('.data-loading').hide();
            $this.find('.actividad-data').show();
        };

        var cargarActividad = function (index) {
            var $previous = $('#{{array_get($data,'id','modal-select')}} .a-previous');
            var $next = $('#{{array_get($data,'id','modal-select')}} .a-next');

            $previous.removeClass('disabled');
            $next.removeClass('disabled');

            //Check valid
            if (!_actividades.length > index)
                return;

            //Check for last or first item
            if (index == 0 && currentPage == 1)
                $previous.addClass('disabled');

            if (index == (_actividades.length - 1) && currentPage == lastPage)
                $next.addClass('disabled');

            _currentIndex = index;

            //Show loading
            $('#{{array_get($data,'id','modal-select')}} .data-loading').show();
            $('#{{array_get($data,'id','modal-select')}} .actividad-data').hide();

            $.ajax("{{\Illuminate\Support\Facades\URL::to('/actividades')}}/" + _actividades[index], {
                dataType: 'json',
                success: function (data) {
                    fillData(data);
                }
            });
        };

        $(function () {
            $('#{{array_get($data,'id','modal-select')}} .handler').on('load', function (event, value, index) {

                if (Array.isArray(value)) {
                    _actividades = value;
                    index = index !== null ? index : 0;
                }
                else {
                    _actividades = [value];
                    index = 0;
                }

                //Cargar
                cargarActividad(index);

            });

            $('#{{array_get($data,'id','modal-detail')}} .a-next').click(function () {

                var index = _currentIndex + 1;

                if (index < _actividades.length)
                    cargarActividad(index);
                else
                    $('#{{array_get($data,'id','modal-detail')}} .handler').trigger('nextPage');
            });

            $('#{{array_get($data,'id','modal-detail')}} .a-previous').click(function () {

                var index = _currentIndex - 1;

                if (index >= 0)
                    cargarActividad(index);
                else
                    $('#{{array_get($data,'id','modal-detail')}} .handler').trigger('previousPage');

            });
        });
    </script>
@append