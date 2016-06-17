app.controller('shelves_ctrl', ['$scope', '$http', '$resource', 'restAPI', 'userauth', function ($scope, $http, $resource, restAPI, userauth ) {
    $scope.createtpl = "/tpl/shelves/create.blade.php";
    $scope.paging = "/tpl/paginator.php";
    $scope.erasertpl = "/tpl/eraser.blade.php";

    // ordernar y filtrar
    $scope.order = {
        field : 'shelves.name',
        type : 'asc',
        idfs : 'icode'
    };
    $scope.filter = {
        name: '',
        idstore : ''
    };
    $scope.setorder = function(field, idfs) {
        setorders(field, idfs,$scope)
    };
    // ayuda
    userauth.idhelp = 11;
    function showhelp() {
        $http({
            url: "/helps/showhelp",
            method: "GET",
            params: {user : userauth}
        }).then(function (response) {
            if ( !response.data) $scope.helptpl = "/tpl/shelves/help.php";
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

    $scope.data_store = {
        valor: null,
        availableOptions: []
    };
    $scope.getresult = function getResultPages(page)
    {
        $http({
            url: "/shelves/lists",
            method: "GET",
            params: {start : page-1, take: $scope.recordpage, fillter : $scope.filter, order: $scope.order}
        }).then(function (response) {
            $scope.lista = response.data.data;
            $scope.data_store.availableOptions = response.data.stores;
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
        idstore :0
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
                    $scope.data_store.valor = null;
                    angular.copy({}, $scope.entity);
                    $scope.form_title = "Agregar un estante.";
                } else {
                    restAPI.rest('/shelves').get({id: id}).$promise.then(function(response){
                        $scope.form_title = "Clonar estante.";
                        $scope.entity = response;
                        $scope.data_store.valor = response.idstore.toString();

                    });
                }
                break;
            case 'edit':
                restAPI.rest('/shelves').get({id: id}).$promise.then(function(response){
                    $scope.form_title = "Detalles del estante.";
                    $scope.entity = response;
                    $scope.data_store.valor = response.idstore.toString();
                });
                break;
            default:
                break;
        }
        $('#modal_add_edit').modal('show');
    };

    $scope.save = function(modalstate, id){
        $scope.entity.idstore = $scope.data_store.valor;
        store('/shelves', id, restAPI, $scope, '#name', modalstate);
    };

    $scope.setkill = function(name, id){
        $scope.killname = name;
        $scope.kill = id;
    };

    $scope.delete = function () {
        eraser('/shelves', restAPI, $scope);
    }

}]);




