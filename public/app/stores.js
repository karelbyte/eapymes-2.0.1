app.controller('stores_ctrl', ['$scope', '$http', '$resource', 'restAPI', 'userauth', function ($scope, $http, $resource, restAPI, userauth) {

    $scope.createtpl = "/tpl/stores/create.blade.php";
    $scope.paging = "/tpl/paginator.php";
    $scope.erasertpl = "/tpl/eraser.blade.php";

    // ordernar y filtrar
    $scope.order = {
        field : 'stores.name',
        type : 'asc',
        idfs : 'icode'
    };
    $scope.filter = {
        name: ''
    };
       
    $scope.setorder = function(field, idfs) {
        setorders(field, idfs,$scope)
    };
    // ayuda
    userauth.idhelp = 8;
    function showhelp() {
        $http({
            url: "/helps/showhelp",
            method: "GET",
            params: {user : userauth}
        }).then(function (response) {
             if  ( !response.data)  $scope.helptpl = "/tpl/stores/help.php";
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
    
    $scope.data_type = {
        valor: null,
        availableOptions: []
    };
    $scope.getresult = function getResultPages(page)
    {
        $http({
            url: "/stores/lists",
            method: "GET",
            params: {start : page-1, take: $scope.recordpage, fillter : $scope.filter, order: $scope.order}
        }).then(function (response) {
            $scope.lista = response.data.data;
            $scope.data_type.availableOptions = response.data.storetype;
            $scope.totalpage =  Math.ceil(parseInt(response.data.total)/ $scope.recordpage);
        })
    };
    $scope.$watch('recordpage + filter.name + order.field + order.type', function(){
        $scope.getresult($scope.currentpage);
    });

    // guardar elimiar y editar

    $scope.entity = {
        id : 0,
        name : '',
        idtype: 0,
        active : null
    };
    $scope.setClickedRow = function(index, idclon){
        $scope.selectedRow = index;
        $scope.idclon = idclon;
    };

    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        angular.copy({}, $scope.retorno);
        switch (modalstate) {
            case 'add':
                if (id == null){
                    $scope.data_type.valor = null;
                    angular.copy($scope.product_new, $scope.entity);
                    $scope.form_title = "Agregar un almacen.";
                } else {
                    restAPI.rest('/stores').get({id: id}).$promise.then(function(response){
                        $scope.form_title = "Clonar almacen.";
                        $scope.entity = response;
                        $scope.data_type.valor = response.idtype.toString();
                    });
                }
                break;
            case 'edit':
                restAPI.rest('/stores').get({id: id}).$promise.then(function(response){
                    $scope.form_title = "Detalles del almacen.";
                    $scope.entity = response;
                    $scope.data_type.valor = response.idtype.toString();
                });
                break;
            default:
                break;
        }
        $('#modal_add_edit').modal('show');
    };

    $scope.close = function(){
        restAPI.rest('/storehouses').update({id:   $scope.idclon}, {name : 'closeQ..'}).$promise.then(function successCallback(response) {
            $("#modal_close").modal('toggle');
            alertas("#msj-success_storehouses", response, null);
            getResultPages($scope.currentpage);
        }, function errorCallback(msj) {
            alertas("#msj-success_storehouses", {codigo:'error', msj : msj.data}, null);

        });
    };

    $scope.save = function(modalstate, id){
       $scope.entity.idtype =  $scope.data_type.valor;
       store('/stores', id, restAPI, $scope, '#name', modalstate);
    };

    $scope.setkill = function(name, id){
        $scope.killname = name;
        $scope.kill = id;
    };

    $scope.delete = function () {
        eraser('/stores', restAPI, $scope);
    }

}]);
/**
 * Created by karel on 31/05/2016.
 */
