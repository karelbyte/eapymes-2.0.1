<div class="modal fade " id="modal_discounts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center" style="width: 505px;" role="document">
            <div class="modal-content">
                <div class="modal-header mdl-header_fix">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Descuentos a productos.</h4>
                </div>
                <div class="modal-body mdl-body_fix" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                    <div class="form-group input-group-sm ">
                        <label class="label1">CODIGO: <%produc.code%>  </label>
                    </div>
                    <div class="form-group input-group-sm ">
                        <label class="label1">NOMBRE: <%produc.name%></label>
                    </div>
                    <hr class="hr_fix">
                    <div class="form-group input-group-sm ">
                        <div ng-repeat="x in dislist" >
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" ng-model="chek" ng-click="setchek_disc(x.id, chek)" ng-checked="permits_disc(x.id)" >
                                    <%x.name%>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mdl_footer_fix">
                    <div  id="msj-success_dis" role="alert" class="hide_left"></div>
                    <button type="button" class="btn btn-default btn-sm" id="btn-save" ng-click="save_discount(produc.id)">Guardar</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
