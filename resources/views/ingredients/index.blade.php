@extends('layout')
@section('content')
    <div ng-controller="ingredients_ctrl">
       <div ng-include="helptpl"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col_fix"><h4>Listado de ingredientes por producto.</h4></div>
            <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 text-right col_fix"><label id="msj-success"></label></div>
        </div>
        <!-- Panel de acciones -->
        <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col_fix">
            <div class="row">
                <div class="panel panel-default panel_bnt_fix">
                    <div class="panel-body">
                        <div class="col-xs-4 col-sm-6 col-md-6 col-lg-6 col_fix">
                            <div ng-controller="setingres_clr">
                            <a ng-class="{disabled: idclon == null}" ng-click="toggle()" class="btn btn-default btn-sm"><i class="fa fa-edit fa-1x"></i>&nbsp;Añadir</a>
                            <!-- <button class="btn btn-default btn-sm"><i class="fa fa-print fa-1x"></i>Imprimir</button> -->
                                <div ng-include="createtpl"></div>
                            </div>
                        </div>
                        <div class="col-xs-8 col-sm-6 col-md-64 col-lg-6 col_fix">
                            <eafilter field="code" caret="on"></eafilter>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Visor de datos -->
            <div class="panel panel-default pnl_second">
                    <div class="panel-heading panel-heading_fix">
                        <div class="row">
                            <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6 col_data"><eafieldorder display="CODIGO" field="products.code" idfs="iproductcode"></eafieldorder></div>
                            <div class="col-xs-4 col-sm-6 col-md-6 col-lg-6"> <eafieldorder display="NOMBRE" field="products.name" idfs="iproductsname"></eafieldorder></div>
                        </div>
                    </div>
                    <div class="panel-body pnl_fix">
                        <div ng-repeat="entity in lista"  ng-class="{'selectedtr':$index == selectedRow}"  ng-click="setClickedRow($index, entity.id)" class="row rowtable mouse div_hover">
                            <div class="col-xs-8 col-sm-6 col-md-6  col-lg-6 text-justify col_data"><%entity.code%></div>
                            <div class="col-xs-4 col-sm-6 col-md-6  col-lg-6 text-justify"><%entity.name%></div>
                        </div>
                    </div>
                    <div class="panel-footer panel-footer_dix"></div>
            </div>
         </div>
         <div class="col-sm-6 col-md-6 col-lg-6 col_fix" style="padding-left: 3px;">  <!-- panel de ingredientes-->
             <div class="row">
                 <div class="panel panel-default panel_bnt_fix">
                     <div class="panel-body" style="padding: 10px;">
                         Ingredientes
                     </div>
                 </div>
             </div>
             <!-- Visor de datos -->
             <div class="panel panel-default pnl_second">
                 <div class="panel-heading panel-heading_fix">
                     <div class="row" style="padding-bottom: 4px;">
                         <div class="col-xs-6 col-sm-7 col-md-3 col-lg-3 col_data">CODIGO</div>
                         <div class="hidden-xs hidden-sm col-md-6 col-lg-6">NOMBRE</div>
                     </div>
                 </div>
                 <div class="panel-body pnl_fix">
                     <div ng-repeat="x in ingredients"  class="row rowtable mouse div_hover">
                         <div class="col-xs-6 col-sm-7 col-md-3  col-lg-3 text-justify col_data"><%x.code%></div>
                         <div class="hidden-xs hidden-sm col-md-6  col-lg-6 text-justify"><%x.name%></div>
                         <div class="col-xs-4 col-sm-3 col-md-2  col-lg-2 text-justify"><input ng-model="x.cant" class="form-control input-sm"></div>
                         <div class="col-xs-1 col-sm-1 col-md-1  col-lg-1 text-justify" ng-click="setdel(x)"><button class="btn btn-danger btn-xs"><i class="fa fa-close"></i> </button></div>
                     </div>
                 </div>
                 <div class="panel-footer panel-footer_fix text-right">
                     <a ng-class="{disabled: ingredients.length == 0}" ng-click="save()" class="btn btn-default btn-sm">Guardar</a>
                 </div>
             </div>
         </div>
         </div>
        <div ng-include="erasertpl"></div>

    </div>		<!-- fin controllador-->
@endsection
@section('scripts')
    <script src="app/ingredients.js"></script>
    <script src="app/setingres.js"></script>
@endsection