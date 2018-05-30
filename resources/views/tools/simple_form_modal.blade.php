<?php
$data = isset($data) ? $data : [];

if (!function_exists("array_check")) {
    function array_check(array $array, $key, $default = '')
    {
        return array_key_exists($key, $array) ? $array[$key] : $default;
    }
}

/*
 * fields:
[name => name]
[displayName => name]
[default => defaultValue]
[type => type]
]
 *
 *
 */

?>
<div id="{{array_get($data,'id','modal-create')}}" data-url="{{array_get($data,'url','#')}}"
     data-method="{{array_get($data,'method','POST')}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{array_get($data,'title','Crear Elemento')}}</h4>
            </div>
            <div class="modal-body">
                @foreach(array_get($data,'fields',[]) as $field)

                    <?php
                        //Data
                        $dString = '';
                        foreach(array_get($field,'data',[]) as $key => $value) {
                            $dString .= ' data-' . $key . '=' . $value;
                        }
                    ?>

                    <div class="form-group">
                        <label for="{{$field['name']}}">{{$field['displayName']}}</label>
                        @if($field['type'] == 'text-multiline')
                            <textarea name="{{$field['name']}}" class="form-control {{array_get($field,'class','')}}" {{$dString}}
                                      placeholder="{{$field['displayName']}}">{{$field['default']}}</textarea>
                        @elseif($field['type'] == 'select')
                            <select name="{{$field['name']}}" class="form-control {{array_get($field,'class','')}}" {{$dString}}
                                    data-placeholder="{{$field['displayName']}}"></select>
                        @else
                            <input name="{{$field['name']}}" type="{{$field['type']}}" class="form-control {{array_get($field,'class','')}}" {{$dString}}
                                   placeholder="{{$field['displayName']}}" value="{{$field['default']}}"/>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success confirm"
                        data-dismiss="modal">{{array_get($data,'confirm-button','Registrar')}}</button>
                <button type="button" class="handler" hidden></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#{{array_get($data,'id','modal-create')}} .confirm").on('click', function () {
            var data = {_token: "{{csrf_token()}}"};
            var $inputs = $('#{{array_get($data,'id','modal-create')}} .form-control');
            for (var i = 0; i < $inputs.length; i++) {
                $inp = $($inputs[i])
                data[$inp.attr('name')] = $inp.val();
            }

            //URL and method can be changed on real time
            var url = $("#{{array_get($data,'id','modal-create')}}").data('url')
            var method = $("#{{array_get($data,'id','modal-create')}}").data('method')
            $.ajax(url, {
                method: method,
                data: data,
                success: function (data) {
                    $("#{{array_get($data,'id','modal-create')}} .handler").trigger('success', [data])
                },
                error: function (data) {
                    $("#{{array_get($data,'id','modal-create')}} .handler").trigger('error', [data])
                }
            });
        });

        //Create the select if any
        @foreach(array_get($data,'fields',[]) as $field)
        @if($field['type'] == 'select' && array_get($field,'selectize',false))

        $('select[name="{{$field['name']}}"]').selectize({
            valueField: 'value',
            labelField: 'text',
            options:{!! json_encode(array_get($field,'options',[]))!!}

        });

        @endif
        @endforeach

    })
</script>