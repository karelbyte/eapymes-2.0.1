app.controller('opens_ctrl', ['$scope', '$http', '$resource', 'restAPI',  'userauth',function ($scope, $http, $resource, restAPI, userauth ) {
    $scope.createtpl = "/tpl/opens/create.blade.php";
    $scope.paging = "/tpl/paginator.php";
    $scope.erasertpl = "/tpl/eraser.blade.php";

    // ordernar y filtrar
    $scope.order = {
        field : 'stores.name',
        type : 'asc',
        idfs : 'iname'
    };
    $scope.filter = {
        name: ''
    };
    $scope.setorder = function(field, idfs) {
        setorders(field, idfs,$scope)
    };

    // ayuda
    userauth.idhelp = 12;
    function showhelp() {
        $http({
            url: "/helps/showhelp",
            method: "GET",
            params: {user : userauth}
        }).then(function (response) {
            if ( !response.data)   $scope.helptpl = "/tpl/opens/help.php";
        })
    }
    $scope.visto = function () {
        $http({
            url: "/helps/showhelpoff",
            method: "post",
            params: {user : userauth}
        }).then(function (response) {
        })
    };
    showhelp();
    // paginacion y resultados
    $scope.currentpage = 1;
    function setpage(page){
        $scope.currentpage = page;
        $scope.getresult(page)
    }

    $scope.setpage = setpage;
    $scope.recordpage = 10;
    $scope.rango = rangoutil;

    $scope.getresult = function getResultPages(page)
    {
        $http({
            url: "/opens/lists",
            method: "GET",
            params: {start : page-1, take: $scope.recordpage, fillter : $scope.filter, order: $scope.order}
        }).then(function (response) {
            $scope.lista = response.data.data;
            $scope.totalpage =  Math.ceil(parseInt(response.data.total)/ $scope.recordpage);
            $scope.modules = response.data.modules;
        })
    };
    $scope.$watch('recordpage + filter.name + order.field + order.type', function(){
        $scope.getresult($scope.currentpage);
    });

    //---------------------
    $scope.entity = {
        id : 0,
        name : "",
        permits : []
    };
    $scope.permits = function (id) {
        return  $scope.entity.permits.indexOf(id) !== -1;
    };

    $scope.setchek = function (value, chek) {
        if (chek){
            if ( $scope.entity.permits.indexOf(value) == -1) $scope.entity.permits.push(value)
        }  else {
            if ( $scope.entity.permits.indexOf(value) !== -1)  $scope.entity.permits = _.without( $scope.entity.permits, value);
        }
    };

    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        angular.copy({}, $scope.retorno);
        switch (modalstate) {
            case 'add':
                if (id == null){
                    $scope.form_title = "Agregar un perfil con sus permisos.";
                    $scope.entity.permits = [];
                    $scope.entity.id =  0;
                    $scope.entity.name = "";
                } else {
                    restAPI.rest('/opens').get({id: id}).$promise.then(function(response){
                        $scope.form_title = "Clonar un perfil con sus permisos.";
                        $scope.entity.permits = [];
                        $scope.entity.id =  response.profile.id;
                        $scope.entity.name = response.profile.name;
                        for (var i in response.profile_details) {
                            $scope.entity.permits.push(response.profile_details[i].idmodule);
                        }

                    });
                }
                break;
            case 'edit':
                restAPI.rest('/opens').get({id: id}).$promise.then(function(response){
                    $scope.form_title = "Actualizar perfil con sus permisos.";
                    $scope.entity.permits = [];
                    $scope.entity.id =  response.profile.id;
                    $scope.entity.name = response.profile.name;
                    for (var i in response.profile_details) {
                        $scope.entity.permits.push(response.profile_details[i].idmodule);
                    }

                });
                break;
            default:
                break;
        }
        $('#modal_add_edit').modal('show');
    };

    $scope.retorno ={};

    $scope.save = function(modalstate, id) {
        angular.copy({}, $scope.retorno);
        if (modalstate === 'edit'){
            restAPI.rest('/opens').update({id: id}, $scope.entity).$promise.then(function successCallback(response) {
                alertas("#msj-success", response, "#name");
                $scope.getresult($scope.currentpage);
            }, function errorCallback(msj) {
                angular.copy({}, $scope.retorno);
                $scope.retorno = msj.data;

            });
        } else {
            restAPI.rest('/opens').save($scope.entity).$promise.then(function successCallback(response) {
                alertas("#msj-success", response, "#name");
                $scope.getresult($scope.currentpage);
            }, function errorCallback(msj) {
                $scope.retorno = msj.data;
            });
        }
    };

    $scope.setkill = function(name, id){
        $scope.killname = name;
        $scope.kill = id;
    };

    $scope.delete = function(){
        restAPI.rest('/opens').delete({id:$scope.kill}).$promise.then(function(response){
            $("#modal_delete").modal('toggle');
            alertas("#msj-success", response, null);
            $scope.getresult($scope.currentpage);
            $scope.idclon = null;
        });
    };

    $scope.selectedRow = null;
    $scope.idclon = null;
    $scope.setClickedRow = function(index, idclon){
        $scope.selectedRow = index;
        $scope.idclon = idclon;
    }
}]);





