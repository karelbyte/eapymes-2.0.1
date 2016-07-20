<div class="modal fade" id="modal_add_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header mdl-header_fix">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="myModalLabel">Añadir productos para apertura.</h5>
            </div>
            <div class="modal-body mdl-body_fix" style="padding: 0">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                <div class="panel panel-default pnl_second"  style="margin-bottom: 0">
                    <div class="panel-heading panel-heading_fix">
                        <div class="row " style="padding-right: 10px; padding-left: 10px;">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-left col_fix"><label id="msj-success"></label></div>
                            <div class="col-sm-offset-7 col-md-offset-7 col-lg-offset-7 text-right"><eafilter field="code" caret="off"></eafilter> </div>
                        </div>
                        <hr style="margin-bottom: 4px; margin-top: 4px;">
                        <div class="row">
                            <div class="col-xs-6 col-sm-2 col-md-2 col-lg-2"><eafieldorder display="CODIGO" field="products.code" idfs="iproductcode_ingre"></eafieldorder></div>
                            <div class="hidden-xs col-sm-4 col-md-3 col-lg-3"> <eafieldorder display="NOMBRE" field="products.name" idfs="iproductsname_ingre"></eafieldorder></div>
                            <div class="hidden-xs col-sm-2 col-md-3 col-lg-3"><label>ESTANTE </label></div>
                            <div class="hidden-xs col-sm-1 col-md-2 col-lg-2"><label>CANTIDAD</label></div>
                            <div class="hidden-xs col-sm-1 col-md-1 col-lg-1"><label>ACCION</label></div>

                        </div>
                    </div>
                    <div class="panel-body pnl_fix">
                        <div ng-repeat="pro in products" class="row rowtable mouse div_hover">
                            <div class="col-xs-6 col-sm-2 col-md-2 col-lg-2 text-justify"><%pro.code%></div>
                            <div class="hidden-xs col-sm-5 col-md-3  col-lg-3 text-justify"><%pro.name%></div>
                            <div class="col-xs-4 col-sm-2 col-md-3  col-lg-3 text-justify">
                                <select class="form-control input-sm" ng-model="pro.idshelve">
                                    <option value=""></option>
                                    <option ng-repeat="shel in data_shelves.availableOptions" value="<%shel.id%>"><%shel.name%></option>
                                </select>
                            </div>
                            <div class="col-xs-1 col-sm-2 col-md-2  col-lg-2 text-justify"><input class="form-control input-sm" ng-model="pro.cant"></div>
                            <div class="col-xs-1 col-sm-1 col-md-1  col-lg-1 text-justify" ng-click="set(pro)"><button class="btn btn-default btn-xs"><i class="fa fa-plus-circle"></i> </button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mdl_footer_fix">
                <div class="row">
                    <div class="col-ms-8 col-md-8 col-lg-8 col_fix">
                        <div ng-include="paging" class="text-left"></div>
                        <div  id="msj-success" role="alert" class="hide_left"></div>
                    </div>
                    <div class="col-ms-4 col-md-4 col-lg-4 col_fix">

                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
