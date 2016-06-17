app.controller('measures_ctrl', ['$scope', '$http', '$resource', 'restAPI', 'userauth', function ($scope, $http, $resource, restAPI, userauth ) {

    $scope.createtpl = "/tpl/measures/create.blade.php";
    $scope.paging = "/tpl/paginator.php";
    $scope.erasertpl = "/tpl/eraser.blade.php";

    // ordernar y filtrar
    $scope.order = {
        field : 'name',
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
    userauth.idhelp = 1;
    function showhelp() {
        $http({
            url: "/helps/showhelp",
            method: "GET",
            params: {user : userauth}
        }).then(function (response) {
           if ( !response.data) $scope.helptpl = "/tpl/measures/help.php";;
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
            url: "/measures/lists",
            method: "GET",
            params: {start : page-1, take: $scope.recordpage, fillter : $scope.filter, order: $scope.order}
        }).then(function (response) {
            $scope.lista = response.data.data;
            $scope.totalpage =  Math.ceil(parseInt(response.data.total)/ $scope.recordpage);
        })
    };
    $scope.$watch('recordpage + filter.name + order.field + order.type', function(){
        $scope.getresult($scope.currentpage);
    });

    // guardar elimiar y editar

    $scope.entity = {
      id : 0,
      name : ''
    };
    $scope.setClickedRow = function(index, idclon){
        $scope.selectedRow = index;
        $scope.idclon = idclon;
    };

    $scope.toggle = function(modalstate, id) {
        labels = {
          add : 'Crear una unidad de medida',
          clon : 'Clonar unidad de medidad',
          edit : 'Actualizar medida'
        };
     toggleform ('/measures', modalstate, id, $scope, restAPI, labels)
    };
    

    $scope.save = function(modalstate, id){
       store('/measures', id, restAPI, $scope, '#name', modalstate);
    };

    $scope.setkill = function(name, id){
        $scope.killname = name;
        $scope.kill = id;
    };

    $scope.delete = function () {
        eraser('/measures', restAPI, $scope);
    }

}]);



