@extends('layout')
@section('content')
    <div ng-controller="persons_ctrl">
      <!--  <div ng-include="createtpl"></div> -->
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
                                <div class="col-sm-6 col-md-6 col-lg-6 col_fix_5">
                                    <div class="form-group input-group-sm form-group_fix text-center" style="padding-top: 20px;">
                                        <img ng-src="../../storage/<%entity.pic%>" ng-click="setimg()" class="img-rounded mouse" height="100" width="100">
                                        <input type="file" name="file" style="display: none;" uploader-model="file" id="imgperson">
                                    </div>
                                </div>
                               <div class="col-sm-6 col-md-6 col-lg-6 col_fix_5">
                                   <div class="form-group input-group-sm form-group_fix">
                                       <label class="label1">* Rason Social</label>
                                       <select ng-change="typeopcion(data_reasons.valor)" class="form-control" name="reasons" id="reasons" ng-model="data_reasons.valor">
                                           <option ng-repeat="option in data_reasons.availableOptions" value="<%option.id%>"><%option.name%></option>
                                       </select>
                                       <div ng-if="retorno.idreason"> <label  class="retorno"><%retorno.idreason[0]%></label></div>
                                   </div>

                                   <div class="form-group input-group-sm form-group_fix">
                                       <label class="label1">* Tipo Persona</label>
                                       <select class="form-control" name="type_persons" id="type_persons" ng-model="data_type_persons.valor">
                                           <option ng-repeat="opti in data_type_persons.availableOptions" value="<%opti.id%>"><%opti.name%></option>
                                       </select>
                                       <div ng-if="retorno.idtype"> <label  class="retorno"><%retorno.idtype[0]%></label></div>
                                   </div>

                               </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6 col_fix_5">

                                    <div class="form-group input-group-sm form-group_fix">
                                        <label class="label1">* Nombre y apellidos</label>
                                        <input type="text" id="namepersons" class="form-control" ng-model = "entity.name" placeholder="Nombre y apellidos..." value="<%name%>">
                                        <div ng-if="retorno.name"> <label  class="retorno"><%retorno.name[0]%></label></div>
                                    </div>
                                    <div ng-if="moraloff" class="form-group input-group-sm form-group_fix">
                                        <label class="label1">* Nombre Comercial</label>
                                        <input type="text" class="form-control" ng-model = "entity.comercial_name" placeholder="Nombre comercial si posee..." value ="%comername%>">
                                        <div ng-if="retorno.comercial_name"> <label  class="retorno"><%retorno.comercial_name[0]%></label></div>
                                    </div>
                                    <div class="form-group input-group-sm form-group_fix">
                                        <label class="label1">* Direccion personal</label>
                                        <input type="text" class="form-control" ng-model = "entity.address" placeholder="Direccion personal..." value ="%address%>">
                                        <div ng-if="retorno.address"> <label  class="retorno"><%retorno.address[0]%></label></div>
                                    </div>
                                    <div class="form-group input-group-sm form-group_fix">
                                        <label class="label1">* Codigo postal</label>
                                        <input type="text" class="form-control" ng-model = "entity.zip" placeholder="Codigo postal..." value ="%zip%>">
                                        <div ng-if="retorno.zip"> <label  class="retorno"><%retorno.zip[0]%></label></div>
                                    </div>
                                    <div class="form-group input-group-sm form-group_fix">
                                        <label class="label1">* Estado/Región</label>
                                        <input type="text" class="form-control" ng-model = "entity.state" placeholder="Estado/Región" value ="%state%>">
                                        <div ng-if="retorno.state"> <label  class="retorno"><%retorno.state[0]%></label></div>
                                    </div>
                                    <div class="form-group input-group-sm form-group_fix">
                                        <label class="label1">* Pais</label>
                                        <input type="text" class="form-control" ng-model = "entity.country" placeholder="Pais..." value ="%country%>">
                                        <div ng-if="retorno.country"> <label  class="retorno"><%retorno.country[0]%></label></div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 col-lg-6 col_fix_5">

                                    <div class="form-group input-group-sm form-group_fix">
                                        <label class="label1">* Telefono</label>
                                        <input type="text" class="form-control" ng-model = "entity.phone" placeholder="Telefono (phone)" value ="%phone%>">
                                    </div>
                                    <div class="form-group input-group-sm form-group_fix">
                                        <label class="label1">Celular</label>
                                        <input type="text" class="form-control" ng-model = "entity.cell" placeholder="Celular (cell)" value ="%cell%>">
                                    </div>
                                    <div class="form-grou form-group_fix">
                                        <label class="label1">* Email</label>
                                        <div class="input-group input-group-sm ">
                                            <input type="mail" class="form-control" ng-model = "entity.email" placeholder="Correo electronico valido..." value ="%email%>">
                                            <span class="input-group-addon">@</span>

                                        </div>
                                        <div ng-if="retorno.email"> <label  class="retorno"><%retorno.email[0]%></label></div>
                                    </div>
                                    <div class="form-group input-group-sm form-group_fix">
                                        <label class="label1">* RFC</label>
                                        <input type="text" class="form-control" ng-model = "entity.rfc" placeholder="Registro federal del contribuyente (RFC)" value ="%rfc%>">
                                        <div ng-if="retorno.rfc"> <label  class="retorno"><%retorno.rfc[0]%></label></div>
                                    </div>
                                    <div ng-if="!moraloff" class="form-group input-group-sm form-group_fix">
                                        <label class="label1">* CURP</label>
                                        <input type="text" class="form-control" ng-model = "entity.curp" placeholder="Clave unica reguistro poblacion (CURP)" value ="%curp%>">
                                        <div ng-if="retorno.curp"> <label  class="retorno"><%retorno.curp[0]%></label></div>
                                    </div>
                                    <label>
                                        <input type="checkbox" ng-checked="entity.active"  ng-model="entity.active">
                                        Activo
                                    </label>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mdl_footer_fix">
                            <button type="button" class="btn btn-default btn-sm" id="btn-save" ng-click="save(modalstate, entity.id)">Guardar</button>
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div ng-include="helptpl"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col_fix"><h4>Listado de personas registradas.</h4></div>
            <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 text-right col_fix"><label id="msj-success"></label></div>
        </div>
        <!-- Panel de acciones -->
        <div class="row">
            <div class="panel panel-default panel_bnt_fix">
                <div class="panel-body">
                    <div class="col-xs-4 hidden-sm hidden-md hidden-lg col_fix">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Acciones <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" ng-click="toggle('add', null)"><i class="fa fa-edit fa-1x"></i>&nbsp;Añadir</a></li>
                                <li ng-class="{disabled: idclon == null}"><a href="#" ng-click="toggle('add', idclon)"><i class="fa fa-clone fa-1x"></i>&nbsp;Clonar</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="hidden-xs col-sm-8 col-md-8 col-lg-8 col_fix">
                        <button  class="btn btn-default btn-sm" ng-click="toggle('add', null)"><i class="fa fa-edit fa-1x"></i>&nbsp;Añadir</button>
                        <a ng-class="{disabled: idclon == null}" ng-click="toggle('add', idclon)" class="btn btn-default btn-sm"><i class="fa fa-clone fa-1x"></i>&nbsp;Clonar</a>
                        <!-- <button class="btn btn-default btn-sm"><i class="fa fa-print fa-1x"></i>Imprimir</button> -->
                    </div>
                    <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4 col_fix">
                        <eafilter field="name"></eafilter>
                    </div>
                </div>
            </div>
        </div>
        <!-- Visor de datos -->
            <div class="row">
            </div>
            <div class="panel panel-default">
                <div class="panel-heading panel-heading_fix">
                    <div class="row ">
                        <div class="hidden-xs col-sm-2 col-md-2 col-lg-2"><label>FOTO</label></div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 col_fix"> <eafieldorder display="NOMBRE" field="persons.name" idfs="iname"></eafieldorder></div>
                        <div class="hidden-xs col-sm-3 col-md-3 col-lg-3 col_fix"> <eafieldorder display="DIRECCION" field="address" idfs="iaddress"></eafieldorder></div>
                        <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2 col_fix"> <eafieldorder display="ESTADO" field="persons.active" idfs="istate"></eafieldorder></div>
                        <div class="hidden-xs col-sm-1 col-md-1 col-lg-1 col_fix"><label class="cursor">ACCIONES</label></div>
                    </div>
                </div>
                <div class="panel-body pnl_fix">
                    <div ng-repeat="entity in lista"  ng-class="{'selectedtr':$index == selectedRow}"  ng-click="setClickedRow($index, entity.id)" class="row rowtable mouse div_hover">
                        <div class="hidden-xs col-sm-2 col-md-2 col-lg-2"><img ng-src="../../storage/<%entity.pic%>" class="img-rounded mouse" height="50" width="50"></div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 col_fix col_fix_p10"><%entity.name%> </div>
                        <div class="hidden-xs col-sm-3 col-md-3 col-lg-3 col_fix col_fix_p10"><%entity.address%></div>
                        <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2  col_fix col_fix_p10"><%entity.state%></div>
                        <div class="col-xs-2 col-sm-1 col-md-1 col-lg-1 col_fix col_fix_p10">
                            <button class="btn btn-default btn-xs" ng-click="toggle('edit', entity.id)"> <span class="glyphicon glyphicon-edit"></span></button>
                            <button class="btn btn-danger btn-xs" ng-click="setkill('Eliminar una persona.',entity.id)" data-toggle='modal' data-target='#modal_delete'> <span class="glyphicon glyphicon-trash"></span></button>
                        </div>
                    </div>
                </div>
                <div class="panel-footer panel-footer_dix">
                    <div ng-include="paging"></div>
                </div>
            </div>

        <div ng-include="erasertpl"></div>


    </div>		<!-- fin controllador-->
@endsection
@section('scripts')
    <script src="app/persons.js"></script>
@endsection