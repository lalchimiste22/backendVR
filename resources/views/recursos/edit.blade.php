@extends('app')

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <h3>Actualizar Recurso</h3>
            {!! Form::open(['url' => '/recursos/' . $recurso->id, 'method' => 'put','files' => true]) !!}
            <div class="form-group">
                {!! Form::label('Codigo') !!}
                {!! Form::text('codigo',$recurso->codigo,['placeholder' => 'nombre', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Nombre') !!}
                {!! Form::text('nombre',$recurso->nombre,['placeholder' => 'nombre', 'class' => 'form-control', 'required' => 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Descripción') !!}
                {!! Form::textarea('descripcion',$recurso->descripcion,['placeholder' => 'Descripción', 'class' => 'form-control']) !!}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-group contenidos">
                        @for($i = 0; $i < count($recurso->contenidos); $i++)
                            <?php $c = $recurso->contenidos[$i];?>
                            <li class="list-group-item contenido" data-indice="{{$i}}">
                                <div class="row">
                                    <div class="col-md-2 col-md-offset-10 text-right">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-secondary contenido-up"><span
                                                        class="glyphicon glyphicon-arrow-up"></span></button>
                                            <button type="button" class="btn btn-sm btn-secondary contenido-down"><span
                                                        class="glyphicon glyphicon-arrow-down"></span></button>
                                            <button type="button" class="btn btn-sm btn-danger contenido-remove"><span
                                                        class="glyphicon glyphicon-trash"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row buffer-top-small">
                                    <div class="col-md-2">
                                        <select class="tipo" name="contenidos[{{$i}}][tipo]" style="width:100%;">
                                            <option value="texto" {{$c->tipo === 'texto' ? 'selected' : ''}}>Texto
                                            </option>
                                            <option value="pregunta" {{$c->tipo === 'pregunta' ? 'selected' : ''}}>
                                                Pregunta
                                            </option>
                                            <option value="vof" {{$c->tipo === 'vof' ? 'selected' : ''}}>
                                                Verdadero/Falso
                                            </option>
                                            <option value="pares" {{$c->tipo === 'pares' ? 'selected' : ''}}>Unir
                                                Pares
                                            </option>
                                        </select>
                                    </div>
                                    <textarea placeholder="Texto" class="col-md-5" name="contenidos[{{$i}}][data]"
                                              rows="2"
                                              required>{{$c->data}}</textarea>
                                    <div class="col-md-5">
                                        <div class="row img-cont-wrapper">
                                            @if(strlen($c->imagen))
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Imagen: </label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button class="btn btn-block btn-danger img-cont-remove">
                                                                <span class="glyphicon glyphicon-trash"> Eliminar</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <img class="img-responsive" src="{{$c->imagen}}"/>
                                                    <input type="hidden" name="contenidos[{{$i}}][imagen-url]"
                                                           value="{{$c->imagen}}"/>
                                                </div>
                                            @else
                                                <div class="col-md-12">
                                                    <strong>Imágen</strong>
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="file" name="contenidos[{{$i}}][imagen]">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <input type="hidden" name="contenidos[{{$i}}][id]" value="{{$c->id}}"/>
                                </div>

                                @if($c->tipo === 'pregunta' || $c->tipo === 'vof')
                                    <div class="row opciones-wrapper">
                                        <hr/>
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <h5>{{$c->tipo === 'pregunta' ? 'Opciones' : 'Afirmaciones'}}</h5></div>
                                            <ul class="opciones">
                                                @for($j = 0; $j < count($c->opciones); $j++)
                                                    <?php $o = $c->opciones[$j];?>
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-md-10 opcion-item-canvass">
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <input type="text"
                                                                               name="contenidos[{{$i}}][opciones][{{$j}}][data]"
                                                                               required style="width:100%;"
                                                                               value="{{$o->data}}">
                                                                    </div>
                                                                    <div class="col-md-2">Correcto:</div>
                                                                    <div class="col-md-1">
                                                                        <input type="checkbox"
                                                                               name="contenidos[{{$i}}][opciones][{{$j}}][marcado]" {{$o->marcado ? 'checked' : ''}}>
                                                                    </div>
                                                                    <input type="hidden"
                                                                           name="contenidos[{{$i}}][opciones][{{$j}}][id]"
                                                                           value="{{$o->id}}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 opcion-item-toolbox text-right">
                                                                <div class="btn-group" role="group">
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-secondary item-up">
                                                                        <span class="glyphicon glyphicon-arrow-up"></span>
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-secondary item-down">
                                                                        <span class="glyphicon glyphicon-arrow-down"></span>
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-danger item-remove">
                                                                        <span class="glyphicon glyphicon-trash"></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endfor
                                                <li class="list-group-item list-group-item-small add agregar-opcion">
                                                    <span class="glyphicon glyphicon-plus-sign"></span> Opcion
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @elseif($c->tipo === 'pares')
                                    <div class="row opciones-wrapper">
                                        <hr/>
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <h5>Pares</h5></div>
                                            <ul class="opciones">
                                                <?php
                                                $opcionMap = $c->opciones->groupBy('indice');
                                                ?>
                                                @foreach($opcionMap as $key => $value)
                                                    <?php
                                                    $o1 = $value[0];
                                                    $o2 = $value[1];
                                                    ?>
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-md-10 opcion-item-canvass">
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <label>Par 1:</label>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="text"
                                                                               name="contenidos[{{$i}}][opciones][{{$key}}][data]"
                                                                               required style="width:100%;"
                                                                               value="{{$o1->data}}">
                                                                        <input type="hidden"
                                                                               name="contenidos[{{$i}}][opciones][{{$key}}][id]"
                                                                               value="{{$o1->id}}"/>
                                                                        <input type="hidden"
                                                                               name="contenidos[{{$i}}][opciones][{{$key}}][marcado]"
                                                                               value="{{$o1->marcado}}"/>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label>Par 2:</label>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="text"
                                                                               name="contenidos[{{$i}}][opciones][{{$key}}][data2]"
                                                                               required style="width:100%;"
                                                                               value="{{$o2->data}}">

                                                                        <input type="hidden"
                                                                               name="contenidos[{{$i}}][opciones][{{$key}}][id2]"
                                                                               value="{{$o2->id}}"/>
                                                                        <input type="hidden"
                                                                               name="contenidos[{{$i}}][opciones][{{$key}}][marcado2]"
                                                                               value="{{$o2->marcado}}"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 opcion-item-toolbox text-right">
                                                                <div class="btn-group" role="group">
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-secondary item-up">
                                                                        <span class="glyphicon glyphicon-arrow-up"></span>
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-secondary item-down">
                                                                        <span class="glyphicon glyphicon-arrow-down"></span>
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-danger item-remove">
                                                                        <span class="glyphicon glyphicon-trash"></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                <li class="list-group-item list-group-item-small add agregar-opcion">
                                                    <span class="glyphicon glyphicon-plus-sign"></span> Par
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endfor
                        <li class="list-group-item add agregar-contenido">
                            <span class="glyphicon glyphicon-plus-sign"></span> Contenido
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-8">
                    {!! Form::submit('Actualizar',['class'=>'btn btn-primary btn-block']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@include('recursos.script')