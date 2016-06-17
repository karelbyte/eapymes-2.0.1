app.controller('ingredients_ctrl', ['$scope', '$http', '$resource', 'restAPI', 'entity_ingres', 'userauth',  function ($scope, $http, $resource, restAPI, entity_ingres, userauth ) {
  
    $scope.paging = "/tpl/paginator.php";
    $scope.erasertpl = "/tpl/eraser.blade.php";
    // ordernar y filtrar
    $scope.order = {
        field : 'products.code',
        type : 'asc',
        idfs : 'iproductcode'
    };
    $scope.filter = {
        name: '',
        code : '',
        idcategorie : '',
        price :'',
        active : ''
    };
    $scope.setorder = function(field, idfs) {
        setorders(field, idfs,$scope)
    };

    $scope.categories = {
        values : [{id: "", name: '..sin filtro..'}],
        selected : '..sin filtro..'

    };
    $scope.states = {
        values : [{id: "", name: '..sin filtro..'},{id: 1, name: 'ACTIVO.'},{id: 0, name: 'INACTIVO.'}],
        selected : '..sin filtro..'

    };
    $scope.setfilter = function (id, op, fillobjet) {
        $scope.filter[id] = op.id;
        fillobjet.selected = op.name;
    };
    // ayuda
    userauth.idhelp = 4;
    function showhelp() {
        $http({
            url: "/helps/showhelp",
            method: "GET",
            params: {user : userauth}
        }).then(function (response) {
            if ( !response.data)   $scope.helptpl = "/tpl/ingredients/help.php";
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
    $scope.recordpage = 18;
    $scope.rango = rangoutil;

    $scope.data_categories = {
        valor: null,
        availableOptions: []
    };
    $scope.data_um = {
        valor: null,
        availableOptions: []
    };
    $scope.getresult = function getResultPages(page)
    {
        $http({
            url: "/products/lists",
            method: "GET",
            params: {start : page-1, take: $scope.recordpage, fillter : $scope.filter, order: $scope.order}
        }).then(function (response) {
            $scope.lista = response.data.data;
            $scope.totalpage =  Math.ceil(parseInt(response.data.total)/ $scope.recordpage);
        })
    };
    $scope.$watch('recordpage + filter.code + filter.name + order.field + order.type', function(){
        $scope.getresult($scope.currentpage);
    });

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
/**
 * Created by karel on 31/05/2016.
 */


