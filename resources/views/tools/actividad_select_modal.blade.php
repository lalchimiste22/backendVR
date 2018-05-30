<?php
$data = isset($data) ? $data : [];

?>
<div id="{{array_get($data,'id','actividad-select-modal')}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-wide">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{array_get($data,'title','Seleccionar Actividad')}}</h4>
            </div>
            <div class="modal-body">
                <!-- START -->
                <div class="row filters">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <input type="text" class="form-control search" placeholder="Buscar"/>
                            <span class="input-group-btn">
                            <button class="btn btn-default search-commit"><span
                                        class="glyphicon glyphicon-search"></span></button>
                                </span>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div id="filtros-avanzados" style="display: none;">
                            <div class="row">
                                <div class="col-xs-6  buffer-top-small">
                                    {!! Form::text('ramos','',['id' => 'ramos-selectize', 'placeholder' => 'Ramos', 'class' => 'form-control']) !!}
                                </div>
                                <div class="col-xs-6  buffer-top-small">
                                    {!! Form::text('cursos','',['id' => 'cursos-selectize', 'placeholder' => 'Cursos', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6  buffer-top-small">
                                    {!! Form::text('seccion','',['id' => 'secciones-selectize', 'placeholder' => 'Sección', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button id="mostrar-filtros" class="btn btn-sm buffer-top-small">Más filtros</button>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div style="height: 50vh; overflow-y:scroll;" class="col-xs-12">
                        <div class="search-results columns"></div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <ul class="pagination">
                            <li class="disabled"><a href="#" data-target="">«</a></li>
                            <li class="disabled"><a href="#" data-target="">»</a></li>
                        </ul>
                    </div>
                </div>
                <!-- END -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success confirm disabled"
                >{{array_get($data,'confirm-button','Confirmar')}}</button>
                <input type="hidden" class="handler"/>
            </div>
        </div>
    </div>
</div>
@section('tool-scripts')
    <script>
        $(function () {
            var currentPage = 0;
            var dataTemplate = '<div class="buffer-top-small actividad-container card">' +
                    '<img class="img-responsive img-rounded"/>' +
                    '<h4></h4>' +
                    '<p></p>' +
                    '<div class="user-data row"><div class="col-xs-4"><img class="img-circle img-responsive user-avatar-small"/></div><div class="col-xs-8 text-left"><strong class="user-name"></strong></div></div>' +
                    '</div>';

            var fillData = function (paginator) {
                currentPage = paginator.current_page;
                var data = paginator.data;
                var $container = $("#{{array_get($data,'id','actividad-select-modal')}} .search-results");
                $container.html('');

                //Crear resultados
                for (var i = 0; i < data.length; i++) {
                    var d = data[i];
                    var $t = $(dataTemplate);
                    $t.attr('data-id', d.id);
                    $t.find('img').attr('src', d.avatar);
                    $t.find('h4').html(d.nombre);
                    $t.find('p').html(d.objetivos.replace(/(?:\r\n|\r|\n)/g, '<br />'));
                    $t.find('.user-avatar').attr('src', d.user.avatar);
                    $t.find('.user-name').html(d.user.nombre);

                    $container.append($t);
                }

                //Iterate paginator
                var $prevLi = $('<li><a href="#" data-target="">«</a></li>');
                var $nextLi = $('<li><a href="#" data-target="">»</a></li>');

                if (paginator.current_page > 1)
                    $prevLi.find('a').attr('data-target', paginator.current_page - 1);
                else
                    $prevLi.addClass('disabled')

                if (paginator.current_page < paginator.last_page)
                    $nextLi.find('a').attr('data-target', paginator.current_page + 1);
                else
                    $nextLi.addClass('disabled');

                //Clear paginator
                var $paginator = $('.pagination');
                $paginator.html('');

                //Add the first arrow
                $paginator.append($prevLi);

                //Create li for each link
                var liTemplate = '<li><a href="#"></a></li>';
                var numberOfPages = {{array_get('max_page',$data,10)}} ;
                var halfNumber = parseInt(numberOfPages / 2);
                for (var i = 0; i < paginator.last_page; i++) {

                    //Check if the page should be rendered (not between 10 and last page)
                    var resumedPage = false;
                    var displayPage = false;
                    if (i == 0 || i == (paginator.last_page - 1) || (i > (paginator.current_page - halfNumber) && (i < (paginator.current_page + halfNumber ))))
                        displayPage = true;
                    else if ((i == paginator.current_page + halfNumber) || (i == paginator.current_page - halfNumber))
                        resumedPage = true;
                    else
                        continue;

                    var $li = $(liTemplate);

                    if ((i + 1 == paginator.current_page) || resumedPage) {
                        $li.addClass('disabled');
                    }
                    else {
                        $li.find('a').attr('data-target', i + 1);
                    }

                    if (resumedPage)
                        $li.find('a').html('...');
                    else
                        $li.find('a').html(i + 1);
                    $paginator.append($li);
                }

                //Close with next item
                $paginator.append($nextLi);

            };

            var search = function (page) {
                page = page == null ? 1 : page;
                var secciones = $('#{{array_get($data,'id','actividad-select-modal')}} #secciones-selectize')[0].selectize.getValue();
                var ramos = $('#{{array_get($data,'id','actividad-select-modal')}} #ramos-selectize')[0].selectize.getValue();
                var cursos = $('#{{array_get($data,'id','actividad-select-modal')}} #cursos-selectize')[0].selectize.getValue();
                var busqueda = $('#{{array_get($data,'id','actividad-select-modal')}} input.search').val();

                var query = [];

                if (busqueda.length > 0)
                    query.push("q=" + busqueda);

                if (secciones.length > 0)
                    query.push("seccion=" + secciones.split(',').join('|'));

                if (ramos.length > 0)
                    query.push("ramo.id=" + ramos.split(',').join('|'));

                if (cursos.length > 0)
                    query.push("curso.id=" + cursos.split(',').join('|'));

                //Abort if no search
                if (query.length == 0 && page == currentPage)
                    return;

                query.push('page=' + page);

                $.ajax('/actividades?' + query.join('&'), {
                    success: function (data) {
                        fillData(data);
                    }
                });
            };

            //Primero cargar todas las actividades
            $.ajax('/actividades', {
                success: function (data) {
                    fillData(data);
                }
            });

            $("#{{array_get($data,'id','actividad-select-modal')}} .search").keypress(function (e) {
                if (e.which == 13) {
                    search();
                }
            });
            $('button.search-commit').on('click', function () {
                search();
            });

            $("#{{array_get($data,'id','actividad-select-modal')}} .pagination").on('click', 'a', function () {
                var $this = $(this);

                //Check if not disabled
                if (!$this.closest('li').hasClass('disabled'))
                    search($this.attr('data-target'));
            });

            $("#{{array_get($data,'id','actividad-select-modal')}} .search-results").on('click', '.actividad-container', function () {
                    $("#{{array_get($data,'id','actividad-select-modal')}} .actividad-container").removeClass('selected');
                $(this).addClass('selected');

                $("#{{array_get($data,'id','actividad-select-modal')}} .confirm").removeClass('disabled');
                $("#{{array_get($data,'id','actividad-select-modal')}} .confirm").attr('data-dismiss', 'modal');
            });

            $("#{{array_get($data,'id','actividad-select-modal')}} .confirm").on('click', function () {
                var $this = $(this);
                if ($(this).hasClass('disabled'))
                    return;

                var $selected = $this.closest('#{{array_get($data,'id','actividad-select-modal')}}').find('.selected');

                if ($selected.legth == 0)
                    return;

                var selectedId = $selected.attr('data-id');
                $('#{{array_get($data,'id','actividad-select-modal')}} .handler').trigger('selected', [selectedId]);
            });

            $('#{{array_get($data,'id','actividad-select-modal')}} #mostrar-filtros').on('click', function () {
                $filtros = $('#filtros-avanzados');
                $filtros.toggle();
                $this = $(this);

                if ($filtros.is(":visible"))
                    $this.text('Mostrar menos');
                else
                    $this.text('Más filtros');

            });

            $('#{{array_get($data,'id','actividad-select-modal')}} #ramos-selectize').selectize({
                valueField: 'id',
                searchField: ['nombre'],
                options:{!! \App\Ramo::select('id','nombre','descripcion')->get() !!},
                render: {
                    option: function (item, escape) {
                        return '<div class="row">' +
                                '<div class="col-xs-12"><strong>' + escape(item.nombre) + '</strong></div>' +
                                '</div>';
                    },
                    item: function (item, escape) {
                        return '<div class="row">' +
                                '<div class="col-xs-12"><strong>' + escape(item.nombre) + '</strong></div>' +
                                '</div>';
                    }
                }
            });

            $('#{{array_get($data,'id','actividad-select-modal')}} #cursos-selectize').selectize({
                valueField: 'id',
                searchField: ['nombre'],
                options:{!! \App\Curso::select('id','nombre','descripcion')->get() !!},
                render: {
                    option: function (item, escape) {
                        return '<div class="row">' +
                                '<div class="col-xs-12"><strong>' + escape(item.nombre) + '</strong></div>' +
                                '</div>';
                    },
                    item: function (item, escape) {
                        return '<div class="row">' +
                                '<div class="col-xs-12"><strong>' + escape(item.nombre) + '</strong></div>' +
                                '</div>';
                    }
                }
            });

            $('#{{array_get($data,'id','actividad-select-modal')}} #secciones-selectize').selectize({
                valueField: 'value',
                labelField: 'label',
                options: [
                    {value: 'inicio', label: 'Inicio'},
                    {value: 'desarrollo', label: 'Desarrollo'},
                    {value: 'cierre', label: 'Cierre'}
                ]
            });
        });
    </script>
@append