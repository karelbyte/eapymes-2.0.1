app.controller('opens_ctrl', ['$scope', '$http', '$resource', 'restAPI',  'userauth', 'entity_ingres', function ($scope, $http, $resource, restAPI, userauth, entity_ingres ) {
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
            if ( !response.data) $scope.helptpl = "/tpl/opens/help.php";
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
    
    // obtener los almacenes 

    $scope.data_stores = {
        valor: '',
        availableOptions: []
    };
    $http({
        url: "/opens/getstores",
        method: "GET"
    }).then(function (response) {
        $scope.data_stores.availableOptions = response.data.data;
    });
    
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
            method: "GET"
        }).then(function (response) {
            $scope.lista = response.data.data;
        })
    };
    $scope.$watch('recordpage + filter.name + order.field + order.type', function(){
        $scope.getresult($scope.currentpage);
    });

    //---------------------
    $scope.ingredients = [];
    $scope.setClickedRow = function(index, id){
        $scope.selectedRow = index;
        $scope.idclon = id;
        entity_ingres.id = id;
        $http({
            url: "/ingredients/product/list/"+id,
            method: "GET"
        }).then(function (response) {
            $scope.ingredients =  response.data.ingreslist;
            $scope.noingres = response.data.ingreslist.length == 0;
            entity_ingres.values = response.data.ingreslist;
        })
    };
    function pass(arrays) {
        for (xpro in arrays) {
            if ( isNaN(arrays[xpro].cant)) return true;
        } return false;
    }

    $scope.save = function(){
        if (!pass(entity_ingres.values)){
            restAPI.rest('/ingredients').save(entity_ingres).$promise.then(function successCallback(response) {
                alertas("#msj-success", response,  null);
            }, function errorCallback(msj) {
                alertas("#msj-success", msj.data,  null);
            });
        } else{
            alertas("#msj-success", {codigo: 500, msj : 'Existen datos erroneos' }, null);
        }
    };

    $scope.setkill = function(name, id){
        $scope.killname = name;
        $scope.kill = id;
    };

    $scope.setdel = function (x) {
        $scope.ingredients =  _.without($scope.ingredients, x);
    };
}]);





