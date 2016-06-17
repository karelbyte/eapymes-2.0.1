app.controller('products_ctrl', ['$scope', '$http', '$resource', 'restAPI', 'userauth', function ($scope, $http, $resource, restAPI, userauth ) {
    $scope.createtpl = "/tpl/products/create.blade.php";
    $scope.paging = "/tpl/paginator.php";
    $scope.erasertpl = "/tpl/eraser.blade.php";
    $scope.discounttpl = "/tpl/products/products_discounts.blade.php";
    $scope.taxstpl = "/tpl/products/products_taxs.blade.php";
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
    userauth.idhelp = 6;
    function showhelp() {
        $http({
            url: "/helps/showhelp",
            method: "GET",
            params: {user : userauth}
        }).then(function (response) {
            if ( !response.data)  $scope.helptpl = "/tpl/products/help.php";
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
    $scope.recordpage = 15;
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
            $scope.categories.values =[{id: "", name: '..sin filtro..'}];
            $scope.categories.values =_.union($scope.categories.values, response.data.categories);
            $scope.data_categories.availableOptions = response.data.categories;
            $scope.data_um.availableOptions = response.data.um;
            $scope.totalpage =  Math.ceil(parseInt(response.data.total)/ $scope.recordpage);
        })
    };
    $scope.$watch('recordpage + filter.code + filter.name + filter.idcategorie + filter.price + filter.active + order.field + order.type', function(){
        $scope.getresult($scope.currentpage);
    });

    // guardar elimiar y editar

    $scope.entity = {
        id : 0,
        name : '',
        percent: 0
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
                    $scope.data_categories.valor = null;
                    $scope.data_um.valor = null;
                    angular.copy($scope.product_new, $scope.entity);
                    $scope.form_title = "Agregar un producto.";
                } else {
                    restAPI.rest('/products').get({id: id}).$promise.then(function(response){
                        $scope.form_title = "Clonar producto.";
                        $scope.entity = response;
                        $scope.entity.price = Number(response.price).toFixed(2);
                        $scope.data_categories.valor = response.idcategorie.toString();
                        $scope.data_um.valor = response.idmeasure.toString();
                        
                    });
                }
                break;
            case 'edit':
                restAPI.rest('/products').get({id: id}).$promise.then(function(response){
                    $scope.form_title = "Detalles del producto";
                    $scope.entity = response;
                    $scope.entity.price = Number(response.price).toFixed(2);
                    $scope.data_categories.valor = response.idcategorie.toString();
                    $scope.data_um.valor = response.idmeasure.toString();
                });
                break;
            default:
                break;
        }
        $('#modal_add_edit').modal('show');
    };

    $scope.save = function(modalstate, id){
        $scope.entity.idcategorie = $scope.data_categories.valor;
        $scope.entity.idmeasure = $scope.data_um.valor;
        store('/products', id, restAPI, $scope, '#name', modalstate);
    };

    $scope.setkill = function(name, id){
        $scope.killname = name;
        $scope.kill = id;
    };

    $scope.delete = function () {
        eraser('/products', restAPI, $scope);
    };
    
    // codigo para impuestos
    $scope.taxstrue = [];

    $scope.permits_taxs = function (id) {
        return  $scope.taxstrue.indexOf(id) !== -1;

    };

    $scope.setchek_taxs = function (value, chek) {
        if (chek){
            if (   $scope.taxstrue.indexOf(value) == -1) $scope.taxstrue.push(value)
        }  else {
            if (   $scope.taxstrue.indexOf(value) !== -1) $scope.taxstrue = _.without($scope.taxstrue, value);
        }
    };
    $scope.taxsform = function (id) {
        $http({
            url: "products/taxs/"+id,
            method: "GET"
        }).then(function (response) {
            $scope.taxstrue = [];
            for (var i in response.data.taxstrue) {
                $scope.taxstrue.push(response.data.taxstrue[i].id);
            }
            $scope.taxlist = response.data.taxlist;
            $scope.produc =  _.findWhere($scope.lista, {id: id});
            if  ($scope.taxlist.length > 0 ){
                $('#modal_taxs').modal('show');}
            else {
                alertas("#msj-success", {codigo : 200, msj : 'No existen impuestos para mostrar.'}, null);
            }
        });

    };

    $scope.save_taxs = function (id) {
        restAPI.rest('products/taxs/stores').save({taxstrue : $scope.taxstrue, id : id}).$promise.then(function successCallback(response) {
            alertas("#msj-success", response, null);
        }, function errorCallback(msj) {
            alertas("#msj-success", msj, null);

        });

    };
    // codigo para descuentos
    $scope.distrues = [];

    $scope.permits_disc = function (id) {
        return  $scope.distrues.indexOf(id) !== -1;
    };

    $scope.setchek_disc = function (value, chek) {
        if (chek){
            if (   $scope.distrues.indexOf(value) == -1) $scope.distrues.push(value)
        }  else {
            if (   $scope.distrues.indexOf(value) !== -1) $scope.distrues = _.without($scope.distrues, value);
        }
    };
    $scope.discountsform = function (id) {
        $http({
            url: "products/discounts/" + id,
            method: "GET"
        }).then(function (response) {
            $scope.distrues = [];
            for (var i in response.data.distrues) {
                $scope.distrues.push(response.data.distrues[i].id);
            }
            $scope.dislist = response.data.dislist;
            $scope.produc =  _.findWhere($scope.lista, {id: id});
            if  ($scope.dislist.length > 0 ){
                $('#modal_discounts').modal('show');}
            else {
                alertas("#msj-success", {codigo : 500, msj : 'No existen descuentos para mostrar.'}, null);
            }
        });


    };

    $scope.save_discount = function (id) {
        restAPI.rest('products/discounts/stores').save({distrues : $scope.distrues, id : id}).$promise.then(function successCallback(response) {
            alertas("#msj-success", response, null);
        }, function errorCallback(msj) {
            alertas("#msj-success", msj, null);
        });

    };
}]);
/**
 * Created by karel on 31/05/2016.
 */

