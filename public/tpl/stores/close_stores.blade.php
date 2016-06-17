<div class="modal fade modal-vertical-centered" id="modal_close" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header  panelh">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="myModalLabel">Cerrar almacen.</h5>
            </div>
            <div class="modal-body" style="background-color: white; color : #2b2b2b;">
                <input type="hidden" id="iddelete">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                <p>Cuidado! Esta acción es irreversible. Desea proceder?</p>
            </div>
            <div class="modal-footer">
                <button ng-click="close()" class="btn btn-default">SI</button>
                <a href="#" data-dismiss="modal" class="btn secondary">No</a>
            </div>
        </div>
    </div>
</div>
