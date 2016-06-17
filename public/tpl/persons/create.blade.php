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
                    <div class="row">
                        <div class="form-group input-group-sm text-center">
                            <img ng-src="../../storage/<%imgrute%>" ng-click="setimg()" class="img-rounded mouse" height="100" width="100">
                            <input type="file" name="file" style="display: none;" uploader-model="file" id="imgperson">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6 col_fix_5">
                            <div class="form-group input-group-sm">
                                <label class="label1">Rason Social</label>
                                <select ng-change="typeopcion(data_reasons.valor)" class="form-control" name="reasons" id="reasons" ng-model="data_reasons.valor">
                                    <option ng-repeat="option in data_reasons.availabelOptions" value="<%option.id%>"><%option.descrip%></option>
                                </select>
                                <div ng-if="retorno.idreason"> <label  class="retorno"><%retorno.idreason%></label></div>
                             </div>

                            <div class="form-group input-group-sm">
                                <label class="label1">Tipo Persona</label>
                                <select class="form-control" name="type_persons" id="type_persons" ng-model="data_type_persons.valor">
                                    <option ng-repeat="opti in data_type_persons.availabelOptions" value="<%opti.id%>"><%opti.descrip%></option>
                                </select>
                                <div ng-if="retorno.idtype"> <label  class="retorno"><%retorno.idtype%></label></div>

                            </div>

                            <div class="form-group input-group-sm">
                                <label class="label1">* Nombre y apellidos</label>
                                <input type="text" id="namepersons" class="form-control" ng-model = "person.name" placeholder="Nombre y apellidos..." value="<%name%>">
                                <div ng-if="retorno.name"> <label  class="retorno"><%retorno.name%></label></div>
                            </div>
                            <div ng-if="moraloff" class="form-group input-group-sm">
                                <label class="label1">* Nombre Comercial</label>
                                <input type="text" class="form-control" ng-model = "person.comercial_name" placeholder="Nombre comercial si posee..." value ="%comername%>">
                                <div ng-if="retorno.comercial_name"> <label  class="retorno"><%retorno.comercial_name%></label></div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label class="label1">* Direccion personal</label>
                                <input type="text" class="form-control" ng-model = "person.address" placeholder="Direccion personal..." value ="%address%>">
                                <div ng-if="retorno.address"> <label  class="retorno"><%retorno.address%></label></div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label class="label1">* Codigo postal</label>
                                <input type="text" class="form-control" ng-model = "person.zip" placeholder="Codigo postal..." value ="%zip%>">
                                <div ng-if="retorno.zip"> <label  class="retorno"><%retorno.zip%></label></div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label class="label1">* Estado/Región</label>
                                <input type="text" class="form-control" ng-model = "person.state" placeholder="Estado/Región" value ="%state%>">
                                <div ng-if="retorno.state"> <label  class="retorno"><%retorno.state%></label></div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label class="label1">* Pais</label>
                                <input type="text" class="form-control" ng-model = "person.country" placeholder="Pais..." value ="%country%>">
                                <div ng-if="retorno.country"> <label  class="retorno"><%retorno.country%></label></div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-lg-6 col_fix_5">

                            <div class="form-group input-group-sm">
                                <label class="label1">* Telefono</label>
                                <input type="text" class="form-control" ng-model = "person.phone" placeholder="Telefono (phone)" value ="%phone%>">
                            </div>
                            <div class="form-group input-group-sm">
                                <label class="label1">Celular</label>
                                <input type="text" class="form-control" ng-model = "person.cell" placeholder="Celular (cell)" value ="%cell%>">
                            </div>
                            <div class="form-group">
                                <label class="label1">* Email</label>
                                <div class="input-group input-group-sm">
                                    <input type="mail" class="form-control" ng-model = "person.email" placeholder="Correo electronico valido..." value ="%email%>">
                                    <span class="input-group-addon">@</span>
                                </div>
                                <div ng-if="retorno.email"> <label  class="retorno"><%retorno.email%></label></div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label class="label1">* RFC</label>
                                <input type="text" class="form-control" ng-model = "person.rfc" placeholder="Registro federal del contribuyente (RFC)" value ="%rfc%>">
                                <div ng-if="retorno.rfc"> <label  class="retorno"><%retorno.rfc%></label></div>
                            </div>
                            <div ng-if="!moraloff" class="form-group input-group-sm">
                                <label class="label1">* CURP</label>
                                <input type="text" class="form-control" ng-model = "person.curp" placeholder="Clave unica reguistro poblacion (CURP)" value ="%curp%>">
                                <div ng-if="retorno.curp"> <label  class="retorno"><%retorno.curp%></label></div>
                            </div>
                            <div class="form-group input-group-sm">
                                <label class="label1">Identificacion personal</label>
                                <input type="text" class="form-control" ng-model = "person.identity_card" placeholder="Identificacion personal..." value ="%identity_card%>">
                            </div>
                             <label style="margin-top: 25px; margin-left: 20px;" >
                                    <input type="checkbox" ng-checked="person.active"  ng-model="person.active">
                                    Activo
                             </label>

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

