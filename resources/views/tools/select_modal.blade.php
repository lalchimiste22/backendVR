<?php
$data = isset($data) ? $data : [];

if(!function_exists("array_check")){
    function array_check(array $array, $key, $default = '') {
        return array_key_exists($key,$array) ? $array[$key] : $default;
    }
}

?>
<div id="{{array_get($data,'id','modal-select')}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{array_get($data,'title','Seleccionar Elementos')}}</h4>
            </div>
            <div class="modal-body">
                <select multiple title="select" type="text"></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success confirm" data-dismiss="modal">{{array_get($data,'confirm-button','Confirmar')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#{{array_get($data,'id','modal-select')}} select').selectize({
            valueField:'value',
            labelField:'text',
            create:false,
            options:{!! json_encode(array_check($data,'options',[])) !!}
        });
    });
</script>