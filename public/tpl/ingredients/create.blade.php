<div class="modal fade " id="modal_add_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="vertical-alignment-helper">
    <div class="modal-dialog vertical-align-center" role="document">
        <div class="modal-content">
            <div class="modal-header mdl-header_fix">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="myModalLabel">Añadir ingredientes</h5>
            </div>
            <div class="modal-body mdl-body_fix" style="padding: 0">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                <div class="panel panel-default pnl_second"  style="margin-bottom: 0">
                    <div class="panel-heading panel-heading_fix">
                        <div class="row">
                            <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 col_data"><eafieldorder display="CODIGO" field="products.code" idfs="iproductcode_ingre"></eafieldorder></div>
                            <div class="hidden-xs col-sm-5 col-md-5 col-lg-5"> <eafieldorder display="NOMBRE" field="products.name" idfs="iproductsname_ingre"></eafieldorder></div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4"> <eafilter field="code" caret="off"></eafilter></div>

                        </div>
                    </div>
                    <div class="panel-body pnl_fix">
                        <div ng-repeat="ingre in listaingres" class="row rowtable mouse div_hover">
                            <div class="col-xs-6 col-sm-3 col-md-3  col-lg-3 text-justify col_data"><%ingre.code%></div>
                            <div class="hidden-xs col-sm-5 col-md-6  col-lg-6 text-justify"><%ingre.name%></div>
                            <div class="col-xs-4 col-sm-3 col-md-2  col-lg-2 text-justify"><input class="form-control input-sm" ng-model="ingre.cant"></div>
                            <div class="col-xs-1 col-sm-1 col-md-1  col-lg-1 text-justify" ng-click="set(ingre)"><button class="btn btn-default btn-xs"><i class="fa fa-plus-circle"></i> </button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mdl_footer_fix">
                <div  id="msj-success" role="alert" class="hide_left"></div>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
    </div>
</div>

