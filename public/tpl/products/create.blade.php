<div class="modal fade " id="modal_add_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center mdl_fix" role="document">
            <div class="modal-content">
                <div class="modal-header mdl-header_fix">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5   class="modal-title" id="myModalLabel"><%form_title%></h5>
                </div>
                <div class="modal-body mdl-body_fix" >
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6  col-lg-7 col_fix">
                            <div  class="form-group input-group-sm form-group_fix">
                                <label class="label1">Codigo</label>
                                <input type="text" class="form-control" ng-model = "entity.code"  id="code" placeholder="Codigo del producto...">
                                <div ng-if="retorno.code"> <label class="retorno"><%retorno.code[0]%></label></div>
                            </div>

                            <div  class="form-group input-group-sm form-group_fix">
                                <label class="label1">Nombre del producto</label>
                                <input type="text" class="form-control" ng-model = "entity.name"  placeholder="Nombre del producto...">
                                <div ng-if="retorno.name"> <label class="retorno"><%retorno.name[0]%></label></div>
                            </div>
                            <div class="form-group input-group-sm form-group_fix">
                                <label class="label1">Unidad de Medida</label>
                                <select class="form-control input-sm"  ng-model="data_um.valor">
                                    <option value=""></option>
                                    <option ng-repeat="um in data_um.availableOptions" value="<%um.id%>"><%um.name%></option>
                                </select>
                                <div ng-if="retorno.idmeasure"> <label class="retorno"><%retorno.idmeasure[0]%></label></div>
                            </div>
                            <div class="form-group input-group-sm form-group_fix">
                                <label class="label1">Categoria</label>
                                <select class="form-control input-sm"  ng-model=" data_categories.valor">
                                    <option value=""></option>
                                    <option ng-repeat="typ in data_categories.availableOptions" value="<%typ.id%>"><%typ.name%></option>
                                </select>
                                <div ng-if="retorno.idcategorie"> <label class="retorno"><%retorno.idcategorie[0]%></label></div>
                            </div>
                            <div  class="form-group input-group-sm form-group_fix">
                                <label class="label1">Precio</label>
                                <input type="text" class="form-control" ng-model="entity.price" placeholder="Precio del producto...">
                                <div ng-if="retorno.price"> <label class="retorno"><%retorno.price[0]%></label></div>
                            </div>
                       </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-5 ">
                            <div  class="form-group form-group_fix" style="padding-top:25px;">
                                <p class="swpading"><toggle-switch ng-model="entity.active" class="switch-small switch-default" knob-label="Activo" on-label="SI" off-label="NO"></toggle-switch></p>
                                <p class="swpading"><toggle-switch ng-model="entity.service" class="switch-small switch-default" knob-label="Servicio" on-label="SI" off-label="NO"></toggle-switch> </p>
                                <p class="swpading"><toggle-switch ng-model="entity.storable" class="switch-small switch-default" knob-label="Inventariable" on-label="SI" off-label="NO"></toggle-switch> </p>
                                <p class="swpading"><toggle-switch ng-model="entity.produced" class="switch-small switch-default" knob-label="Producible" on-label="SI" off-label="NO"></toggle-switch> </p>
                                <p class="swpading"><toggle-switch ng-model="entity.saleable" class="switch-small switch-default" knob-label="Vendible" on-label="SI" off-label="NO"></toggle-switch> </p>
                                <p class="swpading"><toggle-switch ng-model="entity.purchase" class="switch-small switch-default" knob-label="Comprable" on-label="SI" off-label="NO"></toggle-switch> </p>
                                <p class="swpading"><toggle-switch ng-model="entity.mix" class="switch-small switch-default" knob-label="Mesclable" on-label="SI" off-label="NO"></toggle-switch> </p>
                                <p class="swpading"><toggle-switch ng-model="entity.reward" class="switch-small switch-default" knob-label="Obsequiable" on-label="SI" off-label="NO"></toggle-switch> </p>
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

