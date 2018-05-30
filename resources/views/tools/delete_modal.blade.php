<?php $data = isset($data) ? $data : [];?>
<div id="{{array_get($data,'id','modal-delete')}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmar Eliminación</h4>
            </div>
            <div class="modal-body">
                <p>Esta seguro que desea eliminar este elemento?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default modal-delete-cancel" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger modal-delete-confirm">Eliminar</button>
            </div>
        </div>
    </div>
</div>