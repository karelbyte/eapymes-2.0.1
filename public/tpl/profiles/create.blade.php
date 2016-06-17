<div class="modal fade " id="modal_add_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="vertical-alignment-helper">
    <div class="modal-dialog vertical-align-center" role="document">
        <div class="modal-content">
            <div class="modal-header mdl-header_fix">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="myModalLabel"><%form_title%></h5>
            </div>
            <div class="modal-body mdl-body_fix" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

                <div class="form-group input-group-sm">
                    <label class="label1">Descripcion</label>
                    <input type="text" id="name" class="form-control" ng-model="entity.name" placeholder="..." value ="%entity.name%>">
                    <div ng-if="retorno.name"><label class="retorno"><%retorno.name[0]%></label></div>
                </div>
                <div class="form-group input-group-sm">
                    <label class="label1">Modulos</label>
                    <div ng-repeat="x in modules" >
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" ng-model="chek" ng-click="setchek(x.id, chek)" ng-checked="permits(x.id)" >
                                <%x.name%>
                            </label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer mdl_footer_fix">
                <div  id="msj-success" role="alert" class="hide_left"></div>
                <button type="button" class="btn btn-default btn-sm" id="btn-save" ng-click="save(modalstate, entity.id)">Guardar</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
    </div>
</div>

