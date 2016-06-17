<div class="modal fade " id="modal_taxs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center" style="width: 505px;" role="document">
            <div class="modal-content">
                <div class="modal-header mdl-header_fix">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Listado de impuestos aplicables al producto.</h4>
                </div>
                <div class="modal-body mdl-body_fix" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                    <div class="form-group input-group-sm">
                        <label class="label1">CODIGO: <%produc.code%>  </label>
                    </div>
                    <div class="form-group input-group-sm">
                        <label class="label1">NOMBRE: <%produc.name%></label>
                    </div>
                    <hr class="hr_fix">
                    <div class="form-group input-group-sm">
                        <div ng-repeat="x in taxlist" >
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" ng-model="chek" ng-click="setchek_taxs(x.id, chek)" ng-checked="permits_taxs(x.id)" >
                                    <%x.name%>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mdl_footer_fix">
                    <div  id="msj-success_tax" role="alert" class="hide_left"></div>
                    <button type="button" class="btn btn-default btn-sm" id="btn-save" ng-click="save_taxs(produc.id)">Guardar</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>