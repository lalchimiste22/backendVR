@section('script')
    <script>
        var contenidoTemplate = '<li class="list-group-item contenido">' +
            '                            <div class="row">' +
            '                                <div class="col-md-3">' +
            '                                    <select class="tipo" name="contenidos[{i}][tipo]" style="width:100%;">' +
            '                                        <option value="texto">Texto</option>' +
            //'                                        <option value="imagen">Imágen</option>' +
            '                                        <option value="pregunta">Pregunta</option>' +
            '                                    </select>' +
            '                                </div>' +
            '                                <textarea placeholder="Texto" class="col-md-9" name="contenidos[{i}][data]" rows="2" required></textarea>' +
            '                            </div>' +
            '                        </li>';
        var opcionWrapperTemplate = '<div class="row opciones-wrapper"><hr/>\n' +
            '        <div class="col-md-12">\n' +
            '            <div class="text-center"><h5>Opciones</h5></div>\n' +
            '            <ul class="opciones">\n' +
            '                <li class="list-group-item list-group-item-small add agregar-opcion">\n' +
            '                    <span class="glyphicon glyphicon-plus-sign"></span> Opcion\n' +
            '                </li>\n' +
            '            </ul>\n' +
            '        </div>\n' +
            '    </div>';

        var opcionTemplate = '<li class="list-group-item">\n' +
            '                            <div class="row">\n' +
            '                                <div class="col-md-1">Opcion:</div>\n' +
            '                                <div class="col-md-9">\n' +
            '                                    <input type="text" name="contenidos[{i}][opciones][{j}][data]" required style="width:100%;">\n' +
            '                                </div>\n' +
            '                                <div class="col-md-1">Correcto: </div>\n' +
            '                                <div class="col-md-1">\n' +
            '                                    <input type="checkbox" name="contenidos[{i}][opciones][{j}][correcto]">\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </li>';


        $(function () {
            $('ul.contenidos li.agregar-contenido').on('click', function () {
                var siguienteIndice = $(this).closest('.contenidos').children('li').length - 1;
                var html = contenidoTemplate.replace(/{i}/g,siguienteIndice);
                var $contenido = $(html);
                $contenido.attr('data-indice',siguienteIndice);
                $(this).before($contenido);
            });

            $('.contenidos').on('change', 'select.tipo', function () {
                //Check type
                var value = $(this).val();
                if (value === 'texto') {
                    $(this).closest('.contenido').find('[name="data"]').val('').attr('placeholder', 'Texto');

                    //Quitar posibles opciones
                    $(this).closest('.contenido').find('.opciones-wrapper').remove();
                }
                else if (value === 'imagen') {
                    //TODO

                    //Quitar posibles opciones
                    $(this).closest('.contenido').find('.opciones-wrapper').remove();
                }
                else if (value === 'pregunta') {
                    //Data es la pregunta, limpiarla
                    $(this).closest('.contenido').find('[name="data"]').val('').attr('placeholder', 'Pregunta');

                    //Debemos mostrar el apartado de opciones
                    $(this).closest('.contenido').append(opcionWrapperTemplate);
                }
            });

            $('.contenidos').on('click', 'ul.opciones li.agregar-opcion', function () {
                var siguienteIndice = $(this).closest('ul').children('li').length - 1;
                var html = opcionTemplate.replace(/{i}/g,$(this).closest('.contenido').attr('data-indice')).replace(/{j}/g,siguienteIndice);
                $(this).before($(html));
            });
        });
    </script>
@append