@extends('app')

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <h3>Actualizar Recurso</h3>
            {!! Form::open(['url' => '/recursos/' . $recurso->id, 'method' => 'put']) !!}
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
                            <li class="list-group-item contenido">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="tipo" name="contenidos[{{$i}}][tipo]" style="width:100%;">
                                            <option value="texto" {{$c->tipo === 'texto' ? 'selected' : ''}}>Texto
                                            </option>
                                        <!--<option value="imagen" {{$c->tipo === 'imagen' ? 'selected' : ''}}>Imágen</option>-->
                                            <option value="pregunta" {{$c->tipo === 'pregunta' ? 'selected' : ''}}>
                                                Pregunta
                                            </option>
                                        </select>
                                    </div>
                                    <textarea placeholder="Texto" class="col-md-9" name="contenidos[{{$i}}][data]"
                                              rows="2"
                                              required>{{$c->data}}</textarea>
                                    <input type="hidden" name="contenidos[{{$i}}][id]" value="{{$c->id}}"/>
                                </div>

                                @if($c->tipo === 'pregunta')
                                    <div class="row opciones-wrapper">
                                        <hr/>
                                        <div class="col-md-12">
                                            <div class="text-center"><h5>Opciones</h5></div>
                                            <ul class="opciones">
                                                @for($j = 0; $j < count($c->opciones); $j++)
                                                    <?php $o = $c->opciones[$j];?>
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-md-1">Opcion:</div>
                                                            <div class="col-md-9">
                                                                <input type="text"
                                                                       name="contenidos[{{$i}}][opciones][{{$j}}][data]"
                                                                       required style="width:100%;" value="{{$o->data}}">
                                                            </div>
                                                            <div class="col-md-1">Correcto:</div>
                                                            <div class="col-md-1">
                                                                <input type="checkbox"
                                                                       name="contenidos[{{$i}}][opciones][{{$j}}][correcto]" {{$o->correcto ? 'checked' : ''}}>
                                                            </div>
                                                            <input type="hidden" name="contenidos[{{$i}}][opciones][{{$j}}][id]" value="{{$o->id}}"/>
                                                        </div>
                                                    </li>
                                                    @endfor
                                                    <li class="list-group-item list-group-item-small add agregar-opcion">
                                                        <span class="glyphicon glyphicon-plus-sign"></span> Opcion
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