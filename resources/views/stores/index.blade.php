@extends('layout')
@section('content')
    <div ng-controller="stores_ctrl">
        <div ng-include="helptpl"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col_fix"><h4>Listado de almacenes.</h4></div>
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
                        <a ng-class="{disabled: idclon == null}" ng-click="closestore(idclon)" class="btn btn-success btn-sm">Activar</a>

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
            <div class="panel panel-default ">
                <div class="panel-heading panel-heading_fix">
                    <div class="row ">
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 "> <eafieldorder display="NOMBRE" field="stores.name" idfs="iname"></eafieldorder></div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col_fix"> <eafieldorder display="TIPO" field="stores.idtype" idfs="itype"></eafieldorder></div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col_fix"> <eafieldorder display="ESTADO" field="stores.state" idfs="istate"></eafieldorder></div>
                        <div class="col-xs-2 col-sm-5 col-md-2 col-lg-2 col_fix"><label class="cursor">ACCIONES</label></div>
                    </div>
                </div>
                <div class="panel-body pnl_fix">
                    <div ng-repeat="entity in lista"  ng-class="{'selectedtr':$index == selectedRow}"  ng-click="setClickedRow($index, entity.id)" class="row rowtable mouse div_hover">
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 text-justify col_data"><%entity.name%></div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-justify col_data"><%entity.type%></div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-justify "><%entity.state%></div>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col_fix">
                            <button class="btn btn-default btn-xs" ng-click="toggle('edit', entity.id)"> <span class="glyphicon glyphicon-edit"></span></button>
                            <button class="btn btn-danger btn-xs" ng-click="setkill('Eliminar almacen.',entity.id)" data-toggle='modal' data-target='#modal_delete'> <span class="glyphicon glyphicon-trash"></span></button>
                        </div>
                    </div>
                </div>
                <div class="panel-footer panel-footer_dix">
                    <div ng-include="paging"></div>
                </div>
            </div>

        <div ng-include="erasertpl"></div>
        <div ng-include="createtpl"></div>

    </div>		<!-- fin controllador-->
@endsection
@section('scripts')
    <script src="app/stores.js"></script>
@endsection