@section('script')
    <script>
        var contenidoTemplate = '<li class="list-group-item contenido">' +
            '                               <div class="row">\n' +
            '                                    <div class="col-md-2 col-md-offset-10 text-right">\n' +
            '                                        <div class="btn-group" role="group">\n' +
            '                                            <button type="button" class="btn btn-sm btn-secondary contenido-up"><span\n' +
            '                                                        class="glyphicon glyphicon-arrow-up"></span></button>\n' +
            '                                            <button type="button" class="btn btn-sm btn-secondary contenido-down"><span\n' +
            '                                                        class="glyphicon glyphicon-arrow-down"></span></button>\n' +
            '                                            <button type="button" class="btn btn-sm btn-danger contenido-remove"><span\n' +
            '                                                        class="glyphicon glyphicon-trash"></span></button>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                </div>' +
            '                            <div class="row buffer-top-small">' +
            '                                <div class="col-md-2">' +
            '                                    <select class="tipo" name="contenidos[{i}][tipo]" style="width:100%;">' +
            '                                        <option value="texto">Texto</option>' +
            //'                                        <option value="imagen">Imágen</option>' +
            '                                        <option value="pregunta">Pregunta</option>' +
            '                                        <option value="vof">Verdadero/Falso</option>' +
            '                                        <option value="pares">Unir Pares</option>' +
            '                                    </select>' +
            '                                </div>' +
            '                                <textarea placeholder="Texto" style="resize:vertical;" class="col-md-5" name="contenidos[{i}][data]" rows="2" required></textarea>' +
            '                               <div class="col-md-5">' +
            '                                  <div class="row img-cont-wrapper">' +
            '                                  </div>' +
            '                               </div>' +
            '                            </div>' +
            '                        </li>';

        var opcionImgPickerTemplate = '                                     <div class="col-md-12">' +
            '                                        <strong>Imágen</strong>' +
            '                                      </div>' +
            '                                      <div class="col-md-12">' +
            '                                         <input type="file" name="contenidos[{i}][imagen]">' +
            '                                      </div>';

        var opcionItemWrapper = '<li class="list-group-item">' +
            '<div class="row">' +
            '<div class="col-md-10 opcion-item-canvass"></div>' +
            '<div class="col-md-2 opcion-item-toolbox text-right">' +
            '<div class="btn-group" role="group">' +
            '<button type="button" class="btn btn-sm btn-secondary item-up"><span class="glyphicon glyphicon-arrow-up"></span></button>' +
            '<button type="button" class="btn btn-sm btn-secondary item-down"><span class="glyphicon glyphicon-arrow-down"></span></button>' +
            '<button type="button" class="btn btn-sm btn-danger item-remove"><span class="glyphicon glyphicon-trash"></span></button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</li>';

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

        var opcionTemplate = '<div class="row">\n' +
            '                                <div class="col-md-9">\n' +
            '                                    <input type="text" name="contenidos[{i}][opciones][{j}][data]" required style="width:100%;">\n' +
            '                                </div>\n' +
            '                                <div class="col-md-2">Correcto: </div>\n' +
            '                                <div class="col-md-1">\n' +
            '                                    <input type="checkbox" name="contenidos[{i}][opciones][{j}][marcado]">\n' +
            '                            </div>';

        var vofWrapperTemplate = '<div class="row opciones-wrapper"><hr/>\n' +
            '        <div class="col-md-12">\n' +
            '            <div class="text-center"><h5>Afirmaciones</h5></div>\n' +
            '            <ul class="opciones">\n' +
            '                <li class="list-group-item list-group-item-small add agregar-opcion-vof">\n' +
            '                    <span class="glyphicon glyphicon-plus-sign"></span> Afirmación\n' +
            '                </li>\n' +
            '            </ul>\n' +
            '        </div>\n' +
            '    </div>';

        var vofTemplate = '<li class="list-group-item">\n' +
            '                            <div class="row">\n' +
            '                                <div class="col-md-9">\n' +
            '                                    <input type="text" name="contenidos[{i}][opciones][{j}][data]" required style="width:100%;">\n' +
            '                                </div>\n' +
            '                                <div class="col-md-2">Verdadero: </div>\n' +
            '                                <div class="col-md-1">\n' +
            '                                    <input type="checkbox" name="contenidos[{i}][opciones][{j}][marcado]">\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </li>';

        var unirParesWrapperTemplate = '<div class="row opciones-wrapper"><hr/>\n' +
            '        <div class="col-md-12">\n' +
            '            <div class="text-center"><h5>Pares</h5></div>\n' +
            '            <ul class="opciones">\n' +
            '                <li class="list-group-item list-group-item-small add agregar-opcion-pares">\n' +
            '                    <span class="glyphicon glyphicon-plus-sign"></span> Par\n' +
            '                </li>\n' +
            '            </ul>\n' +
            '        </div>\n' +
            '    </div>';

        var unirParesOpcionTemplate = '<li class="list-group-item">\n' +
            '                            <div class="row">\n' +
            '                                <div class="col-md-2 text-right">\n' +
            '                                    <label>Par 1:</label>' +
            '                                </div>\n' +
            '                                <div class="col-md-4">\n' +
            '                                    <input type="text" placeholder="Max 15 char." name="contenidos[{i}][opciones][{j}][data]" required style="width:100%;" maxlength="10">\n' +
            '                                    <input type="hidden" name="contenidos[{i}][opciones][{j}][marcado]" checked>\n' +
            '                                </div>\n' +
            '                                <div class="col-md-2 text-right">\n' +
            '                                    <label>Par 2:</label>' +
            '                                </div>\n' +
            '                                <div class="col-md-4">\n' +
            '                                    <input type="text" placeholder="Max 15 char." name="contenidos[{i}][opciones][{j}][data2]" required style="width:100%;" maxlength="10">\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </li>';

        function updateOptionIndex($option) {
            //Get index = number of prev objects
            var index = $option.prevAll().length;

            //Get the mathing iputs
            var $namedInput = $option.find('input').filter(function () {
                return $(this).attr('name').match(/\[opciones\]\[[0-9]+\]/g);
            });

            for (var i = 0; i < $namedInput.length; i++) {
                var $input = $($namedInput[i]);
                //Replace the name with the current value
                var name = $input.attr('name').replace(/\[opciones\]\[[0-9]+\]/g, '[opciones][' + index + ']');
                $input.attr('name', name);
            }
        }

        function updateContentIndex($cont) {
            var index = $cont.prevAll().length;

            //Get the mathing iputs
            var $namedInput = $cont.find('input,select,textarea').filter(function () {
                return $(this).attr('name') !== undefined && $(this).attr('name').match(/contenidos\[[0-9]+\]/g);
            });

            for (var i = 0; i < $namedInput.length; i++) {
                var $input = $($namedInput[i]);
                //Replace the name with the current value
                var name = $input.attr('name').replace(/contenidos\[[0-9]+\]/g, 'contenidos[' + index + ']');
                $input.attr('name', name);
            }

            //@TODO: file input breaks - What to do?
        }

        function getContImagePicker($context){
            var indice = $context.hasClass('contenido') ?  $context.attr('data-indice') : $context.closest('.contenido').attr('data-indice');

            var html = opcionImgPickerTemplate.replace(/{i}/g, indice);
            var $picker = $(html);
            $picker.find('[type="file"]').fileinput({
                showUpload: false,
                showCancel: false,
                showPreview: false
            });

            return $picker
        }

        function cargarContenidos(){
            //@TODO: quiza hacer la carga acá en vez de en BLADE
            //Por el momento solo cargamos los file inputs
            $('.contenido').find('[type="file"]').fileinput({
                showUpload: false,
                showCancel: false,
                showPreview: false
            });
        }

        $(function () {
            //Cargar posibles contenidos existentes
            cargarContenidos();

            $('ul.contenidos li.agregar-contenido').on('click', function () {
                var siguienteIndice = $(this).closest('.contenidos').children('li').length - 1;
                var html = contenidoTemplate.replace(/{i}/g, siguienteIndice);
                var $contenido = $(html);
                $contenido.attr('data-indice', siguienteIndice);
                /*$contenido.find('[type="file"]').fileinput({
                    showUpload: false,
                    showCancel: false,
                    showPreview: false
                });*/
                $contenido.find('.img-cont-wrapper').html(getContImagePicker($contenido));

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
                else if (value === 'pregunta') {
                    //Data es la pregunta, limpiarla
                    $(this).closest('.contenido').find('[name="data"]').val('').attr('placeholder', 'Pregunta');

                    //Quitar posibles opciones
                    $(this).closest('.contenido').find('.opciones-wrapper').remove();

                    //Debemos mostrar el apartado de opciones
                    $(this).closest('.contenido').append(opcionWrapperTemplate);
                }
                else if (value === 'vof') { //VoF  es basicamente lo mismo que opciones, pero cambia el texto desplegado
                    //Data es la pregunta, limpiarla
                    $(this).closest('.contenido').find('[name="data"]').val('').attr('placeholder', 'Texto');

                    //Quitar posibles opciones
                    $(this).closest('.contenido').find('.opciones-wrapper').remove();

                    //Debemos mostrar el apartado de opciones
                    $(this).closest('.contenido').append(vofWrapperTemplate);
                }
                else if (value === 'pares') {
                    //Data es la pregunta, limpiarla
                    $(this).closest('.contenido').find('[name="data"]').val('').attr('placeholder', 'Texto');

                    //Quitar posibles opciones
                    $(this).closest('.contenido').find('.opciones-wrapper').remove();

                    //Debemos mostrar el apartado de opciones
                    $(this).closest('.contenido').append(unirParesWrapperTemplate);
                }
            });

            //Pregunta
            $('.contenidos').on('click', 'ul.opciones li.agregar-opcion', function () {
                var siguienteIndice = $(this).closest('ul').children('li').length - 1;
                var html = opcionTemplate.replace(/{i}/g, $(this).closest('.contenido').attr('data-indice')).replace(/{j}/g, siguienteIndice);
                var wrapper = $(opcionItemWrapper);
                wrapper.find('.opcion-item-canvass').html(html);
                $(this).before(wrapper);
            });

            //VoF
            $('.contenidos').on('click', 'ul.opciones li.agregar-opcion-vof', function () {
                var siguienteIndice = $(this).closest('ul').children('li').length - 1;
                var html = vofTemplate.replace(/{i}/g, $(this).closest('.contenido').attr('data-indice')).replace(/{j}/g, siguienteIndice);
                var wrapper = $(opcionItemWrapper);
                wrapper.find('.opcion-item-canvass').html(html);
                $(this).before(wrapper);
            });

            //Unir Pares
            $('.contenidos').on('click', 'ul.opciones li.agregar-opcion-pares', function () {
                var siguienteIndice = $(this).closest('ul').children('li').length - 1;
                var html = unirParesOpcionTemplate.replace(/{i}/g, $(this).closest('.contenido').attr('data-indice')).replace(/{j}/g, siguienteIndice);
                var wrapper = $(opcionItemWrapper);
                wrapper.find('.opcion-item-canvass').html(html);
                $(this).before(wrapper);
            });

            //Common
            $('.contenidos').on('click', 'ul.opciones .item-up', function () {
                var $li = $(this).closest('li');
                var $prev = $li.prev();
                if ($prev.length === 0)
                    return;

                $li.remove();
                $prev.before($li);

                //We have to update the indexes
                updateOptionIndex($li);
                updateOptionIndex($prev);
            });

            $('.contenidos').on('click', 'ul.opciones .item-down', function () {
                var $li = $(this).closest('li');
                var $next = $li.next();
                if ($next.length === 0)
                    return;

                $li.remove();
                $next.after($li);

                //Update the indexes
                updateOptionIndex($li);
                updateOptionIndex($next);
            });

            $('.contenidos').on('click', 'ul.opciones .item-remove', function () {
                var $li = $(this).closest('li');
                var $nextAll = $li.nextAll();
                $li.remove();

                //Update the indexes of all the following items
                for (var i = 0; i < $nextAll.length; i++)
                    updateOptionIndex($($nextAll[i]));
            });


            $('.contenidos').on('click', 'contenido-up', function () {
                var $li = $(this).closest('li');
                var $prev = $li.prev();
                if ($prev.length === 0)
                    return;

                $li.remove();
                $prev.before($li);

                //We have to update the indexes
                updateContentIndex($li);
                updateContentIndex($prev);
            });

            $('.contenidos').on('click', '.contenido-down', function () {
                var $li = $(this).closest('li');
                var $next = $li.next();
                if ($next.length === 0)
                    return;

                $li.remove();
                $next.after($li);

                //Update the indexes
                updateContentIndex($li);
                updateContentIndex($next);
            });

            $('.contenidos').on('click', '.contenido-remove', function () {
                var $li = $(this).closest('li');
                var $nextAll = $li.nextAll();
                $li.remove();

                //Update the indexes of all the following items
                for (var i = 0; i < $nextAll.length; i++)
                    updateContentIndex($($nextAll[i]));
            });

            $('.contenidos').on('click', '.img-cont-remove', function (e) {
                $(this).closest('.img-cont-wrapper').html(getContImagePicker($(this)));

                //Don't want to send the form
                e.preventDefault();
            });
        });
    </script>
@append