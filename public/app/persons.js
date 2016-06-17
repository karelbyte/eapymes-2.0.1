app.controller('persons_ctrl', ['$scope', '$http', '$resource', 'restAPI',  'upload', 'userauth', function ($scope, $http, $resource, restAPI, upload, userauth ) {

  //  $scope.createtpl = "/tpl/persons/create.blade.php";
    $scope.paging = "/tpl/paginator.php";
    $scope.erasertpl = "/tpl/eraser.blade.php";

    // ordernar y filtrar
    $scope.order = {
        field : 'persons.name',
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
    userauth.idhelp = 5;
    function showhelp() {
        $http({
            url: "/helps/showhelp",
            method: "GET",
            params: {user : userauth}
        }).then(function (response) {
            if ( !response.data)   $scope.helptpl = "/tpl/persons/help.php";
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
    // todo sobre img

    $scope.imgrute = 'user.png';

    $scope.setimg = function () {
        $('#imgperson').click();
    };

    $('#imgperson').on('change', function () {
       setTimeout(function () {
             $scope.uploadFile();
        }, 2000)
     });

    $scope.uploadFile = function()
    {
        var name = 'noname'+  Math.trunc(Math.random() * (900 - 1) + 1);
        var file = $scope.file;

        upload.uploadFile(file, name).then(function(res)
        {
            $scope.entity.pic = name;
            console.log( $scope.entity.pic);
        })
    };


    // paginacion y resultados
    $scope.data_type_persons = {
        valor: null,
        availableOptions: []
    };
    $scope.data_reasons = {
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
            url: "/persons/lists",
            method: "GET",
            params: {start : page-1, take: $scope.recordpage, fillter : $scope.filter, order: $scope.order}
        }).then(function (response) {
            $scope.lista = response.data.data;
            $scope.data_type_persons.availableOptions = response.data.types;
            $scope.data_state.availableOptions = response.data.state;
            $scope.data_reasons.availableOptions = response.data.reasons;
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
        angular.copy({}, $scope.retorno);
        $scope.modalstate = modalstate;
        switch (modalstate) {
            case 'add':
                if (id == null){
                    $scope.form_title = "Agregar una persona.";
                    angular.copy({},$scope.entity);
                    $scope.data_reasons.valor = "";
                    $scope.data_type_persons.valor = "";
                    $scope.entity.comercial_name = "-";
                    $scope.entity.pic = 'user.png';
                } else {
                    restAPI.rest('/persons').get({id: id}).$promise.then(function(response){
                        $scope.form_title = "Clonar datos de una persona.";
                        $scope.entity = response;
                        $scope.typeopcion($scope.entity.idreason);
                        $scope.entity.active = (response.active !== 0);
                        $scope.data_reasons.valor = response.idreason.toString();
                        $scope.data_type_persons.valor = response.idtype.toString();
                    });
                }
                break;
            case 'edit':
                restAPI.rest('/persons').get({id: id}).$promise.then(function(response){
                    $scope.form_title = "Detalles de persona.";
                    $scope.entity = response;
                    $scope.typeopcion($scope.entity.idreason);
                    $scope.entity.active = (response.active !== 0);
                    $scope.data_reasons.valor = response.idreason.toString();
                    $scope.data_type_persons.valor = response.idtype.toString();
                });
                break;
            default:
                break;
        }
        $('#modal_add_edit').modal('show');
    };

    $scope.save = function(modalstate, id){
        $scope.entity.idreason = $scope.data_reasons.valor;
        $scope.entity.idtype = $scope.data_type_persons.valor;
        $scope.entity.active =   $scope.entity.active ? 1 : 0;
        store('/persons', id, restAPI, $scope, '#namepersons', modalstate);
        $scope.entity.active =  $scope.entity.active == 1;
    };

    $scope.setkill = function(name, id){
        $scope.killname = name;
        $scope.kill = id;
    };
    $scope.moraloff = false;
    $scope.typeopcion = function(op){
        $scope.moraloff = (op !=1)
    };
    $scope.delete = function () {
        eraser('/persons', restAPI, $scope);
    }

}]);



