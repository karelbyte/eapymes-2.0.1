app.controller('setopens_clr', ['$scope', '$http', 'restAPI',  function ($scope, $http, restAPI) {
    $scope.createtpl = "/tpl/opens/create.blade.php";
    $scope.order = {
        field : 'products.code',
        type : 'asc',
        idfs : 'iproductcode_ingre'
    };
    
    $scope.filter = {
        name: '',
        code : ''

    };
    $scope.setorder = function(field, idfs) {
        setorders(field, idfs,$scope)
    };

    $scope.setfilter = function (id, op, fillobjet) {
        $scope.filter[id] = op.id;
        fillobjet.selected = op.name;
    };
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
            url: "/opens/products/" + $scope.id,
            method: "GET",
            params: {start : page-1, take: $scope.recordpage, fillter : $scope.filter, order: $scope.order}
        }).then(function (response) {
            $scope.products = response.data.data;
            $scope.data_shelves.availableOptions = response.data.shelves;
            $scope.totalpage =  Math.ceil(parseInt(response.data.total)/ $scope.recordpage);
        })
    };
    $scope.$watch('recordpage + filter.code + filter.name + order.field + order.type', function(){
        $scope.getresult($scope.currentpage);
    });

    $scope.toggle = function (id) {
        $scope.id = id;
        $scope.getresult($scope.currentpage);
        $('#modal_add_edit').modal('show');
    };

    function id_exis(id, arrays){
        for (xpro in arrays) {
            if (arrays[xpro].id == id) return true;
        } return false;
    }
    
    $scope.data_shelves = {
        valor: null,
        availableOptions: []
    };
    $scope.set = function (i) {
        product = i;
        product.idstore = $scope.id;
        if (!isNaN(i.cant)){
                restAPI.rest('/opens').save(product).$promise.then(function successCallback(response) {
                    alertas("#msj-success", response,  null);
                    $scope.products = _.without($scope.products, i);
                }, function errorCallback(msj) {
                    alertas("#msj-success", msj.data,  null);
                });
            } else{
                alertas("#msj-success", {codigo: 500, msj : 'Existen datos erroneos' }, null);

            }
        };

}]);
