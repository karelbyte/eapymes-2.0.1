app.controller('opens_ctrl', ['$scope', '$http', '$resource', 'restAPI',  'userauth', 'entity_ingres', function ($scope, $http, $resource, restAPI, userauth, entity_ingres ) {
    $scope.createtpl = "/tpl/opens/create.blade.php";
    $scope.paging = "/tpl/paginator.php";
    $scope.erasertpl = "/tpl/eraser.blade.php";

    // ordernar y filtrar
    $scope.order = {
        field : 'products.name',
        type : 'asc',
        idfs : 'iname'
    };
    $scope.filter = {
        name: '',
        code: ''
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
            url: "/opens/lists/" + $scope.data_stores.valor,
            method: "GET",
            params: {start : page-1, take: $scope.recordpage, fillter : $scope.filter, order: $scope.order}
        }).then(function (response) {
            $scope.lista = response.data.data;
            $scope.shelves = response.data.shelves;
            $scope.totalpage =  Math.ceil(parseInt(response.data.total)/ $scope.recordpage);
        })
    };
    $scope.$watch('recordpage + filter.name + filter.code + data_stores.valor + order.field + order.type', function(){
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

   $scope.refresh = function () {
       $scope.getresult($scope.currentpage);
   };

    $scope.setkill = function(name, id){
        $scope.killname = name;
        $scope.kill = id;
    };

    $scope.delete = function () {
        eraser('/opens', restAPI, $scope);
    };
}]);





