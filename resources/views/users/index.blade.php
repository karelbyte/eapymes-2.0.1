@extends('layout')
@section('content')
    <div ng-controller="users_ctrl">
        <div ng-include="createtpl"></div>
        <div ng-include="helptpl"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col_fix"><h4>Listado de usuarios del sistema.</h4></div>
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
                        <div class="hidden-xs col-sm-2 col-md-2 col-lg-2"><eafieldorder display="NICK" field="users.nick" idfs="inick"></eafieldorder></div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 col_fix"><eafieldorder display="NOMBRE" field="users.idperson" idfs="iperson"></eafieldorder></div>
                        <div class="hidden-xs col-sm-3 col-md-3 col-lg-3 col_fix"> <eafieldorder display="PERFIL" field="users.idprofile" idfs="iprofile"></eafieldorder></div>
                        <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2 col_fix"> <eafieldorder display="ESTADO" field="users.active" idfs="istate"></eafieldorder></div>
                        <div class="hidden-xs col-sm-1 col-md-1 col-lg-1 col_fix"><label class="cursor">ACCIONES</label></div>
                    </div>
                </div>
                <div class="panel-body pnl_fix">
                    <div ng-repeat="entity in lista"  ng-class="{'selectedtr':$index == selectedRow}"  ng-click="setClickedRow($index, entity.id)" class="row rowtable mouse div_hover">
                        <div class="hidden-xs col-sm-2 col-md-2 col-lg-2"><%entity.nick%></div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 col_fix"><%entity.name%></div>
                        <div class="hidden-xs col-sm-3 col-md-3 col-lg-3 col_fix"><%entity.profile%></div>
                        <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2 col_fix"><%entity.state%></div>
                        <div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
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
    <script src="app/users.js"></script>
@endsection