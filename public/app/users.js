app.controller('users_ctrl', ['$scope', '$http', '$resource', 'restAPI', 'userauth', function ($scope, $http, $resource, restAPI, userauth) {

    $scope.createtpl = "/tpl/users/create.blade.php";
    $scope.paging = "/tpl/paginator.php";
    $scope.erasertpl = "/tpl/eraser.blade.php";

    // ordernar y filtrar
    $scope.order = {
        field : 'nick',
        type : 'asc',
        idfs : 'inick'
    };
    $scope.filter = {
        name: '',
        nick :'',
        idprofile :''
    };

    $scope.setorder = function(field, idfs) {
        setorders(field, idfs,$scope)
    };

// ayuda
    userauth.idhelp = 10;
    function showhelp() {
        $http({
            url: "/helps/showhelp",
            method: "GET",
            params: {user : userauth}
        }).then(function (response) {
            if ( !response.data) $scope.helptpl = "/tpl/users/help.php";
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
    $scope.data_profiles = {
        valor: null,
        availableOptions: []
    };
    $scope.data_persons = {
        valor: null,
        availableOptions: []
    };
    $scope.data_state = {
        state: null,
        availableOptions: []
    };

    $scope.currentpage = 1;
    function setpage(page){
        $scope.currentpage = page;
        $scope.getresult(page)
    }

    $scope.setpage = setpage;
    $scope.recordpage = 8;
    $scope.rango = rangoutil;

    $scope.getresult = function getResultPages(page)
    {
        $http({
            url: "/users/lists",
            method: "GET",
            params: {start : page-1, take: $scope.recordpage, fillter : $scope.filter, order: $scope.order}
        }).then(function (response) {
            $scope.lista = response.data.data;
            $scope.totalpage =  Math.ceil(parseInt(response.data.total)/ $scope.recordpage);
            $scope.data_profiles.availableOptions = response.data.profiles;
            $scope.data_persons.availableOptions = response.data.datapersons;
        })
    };
    $scope.$watch('recordpage + filter.name + order.field + order.type', function(){
        $scope.getresult($scope.currentpage);
    });

    // guardar elimiar y editar


    $scope.entity = {
        id : 0,
        idperson : 0,
        idprofile : 0,
        nick : "",
        password : "",
        password_confirmation : ""
    };

    $scope.pass = true;

    $scope.setpass = function (ss) {
        $scope.pass = ss ? false : true;
        angular.copy({}, $scope.retorno);
        $scope.entity.password = "";
        $scope.entity.password_confirmation = "";
    };
//---------------------

    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        angular.copy({}, $scope.retorno);
        angular.copy({}, $scope.entity);
        switch (modalstate) {
            case 'add':
                if (id == null){
                    $scope.setpass(false);
                    $scope.form_title = "Agregar una usuario.";
                    $scope.data_profiles.valor = "";
                    $scope.data_persons.valor = "";
                } else {
                    $scope.setpass(false);
                    restAPI.rest('/users').get({id: id}).$promise.then(function(response){
                        $scope.form_title = "Clonar un usuario.";
                        $scope.entity = response;
                        $scope.data_persons.valor = $scope.entity.idperson.toString();
                        $scope.data_profiles.valor =  $scope.entity.idprofile.toString();
                        $scope.entity.active = (response.active !== 0);
                    });
                }
                break;
            case 'edit':
                $scope.setpass(true);
                restAPI.rest('/users').get({id: id}).$promise.then(function(response){
                    $scope.form_title = "Detalles de la persona.";
                    $scope.entity = response;
                    $scope.data_persons.valor = $scope.entity.idperson.toString();
                    $scope.data_profiles.valor =  $scope.entity.idprofile.toString();
                    $scope.entity.active = (response.active !== 0);
                });
                break;
            default:
                break;
        }
        $('#modal_add_edit').modal('show');
    };

    $scope.retorno ={};

    $scope.save = function(modalstate, id) {
        $scope.confir = false;
        angular.copy({}, $scope.retorno);
        $scope.entity.idperson = $scope.data_persons.valor;
        $scope.entity.idprofile  = $scope.data_profiles.valor;
        $scope.entity.active =   $scope.entity.active ? 1 : 0;
        if (modalstate === 'edit'){
            if ($scope.pass){
                if ($scope.entity.password.length <6) {$scope.retorno.password = "Tamaño de contraseña no valido";    $scope.confir = true}
                if ($scope.entity.password == "" || $scope.entity.password == null) {$scope.retorno.password = "No se introdujo una contraseña";    $scope.confir = true}
                if ($scope.entity.password_confirmation == "" ||  $scope.entity.password_confirmation == null) {$scope.retorno.password_confirmation = "No se confirmo la contraseña" ;  $scope.confir = true}
                if ($scope.entity.password !=  $scope.entity.password_confirmation) {$scope.retorno.password_confirmation = "Las contraseñas no coinciden";    $scope.confir = true }
            }
            if (!$scope.confir){
                restAPI.rest('/users').update({id: id}, $scope.entity).$promise.then(function successCallback(response) {
                    alertas("#msj-success", response, "#nick");
                    $scope.getresult($scope.currentpage);
                }, function errorCallback(msj) {
                    angular.copy({}, $scope.retorno);
                    $scope.retorno = msj.data;

                });}
        } else {
            restAPI.rest('/users').save($scope.entity).$promise.then(function successCallback(response) {
                $scope.retorno = response;
                alertas("#msj-success", response, "#nick");
                $scope.getresult($scope.currentpage);
            }, function errorCallback(msj) {
                $scope.retorno = msj.data;

            });
        }
        $scope.entity.active =  $scope.entity.active == 1;
    };

    $scope.setkill = function(name, id){
        $scope.killname = name;
        $scope.kill = id;
    };
    $scope.delete = function(){
        restAPI.rest('/users').delete({id:$scope.kill}).$promise.then(function(response){
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



