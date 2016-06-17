/**
 * Created by kare on 16/04/2016.
 */
function alertas(selector, response, retorno) {
    var mjsdom = $(selector);
    if (response.codigo !== 500) mjsdom.removeClass('errortext').addClass('alert-success_fix'); else mjsdom.removeClass('alert-success_fixt').addClass('errortext');
    mjsdom.html(response.msj);
    mjsdom.fadeIn().delay(2000).fadeOut();
    if (retorno !== null) $(retorno).select();
}

function rangoutil(totalpage, currentpage){
    var star,  end, total;
    total= (totalpage !== null )? parseInt(totalpage) : 0;
    if (total <= 5)
    {
        star = 1;
        end = total+1;
    } else{
        if ( currentpage <= 2) {
            star = 1;
            end = 6;
        } else if (currentpage + 2 >=  total) {
            star =  total - 5;
            end = total + 1;
        } else {
            star=  currentpage - 2;
            end =  currentpage + 3;
        }

    }
    return  _.range(star, end);
}

 function eraser(url, rest, scope){
     rest.rest(url).delete({id:scope.kill}).$promise.then(function successCallback(response) {
        $("#modal_delete").modal('toggle');
        alertas("#msj-success", response, null);
        if (scope.lista.length < 2)  scope.currentpage--;
        scope.getresult(scope.currentpage);
        scope.selectedRow = null;
        scope.idclon = null;
    }, function errorCallback(response) {
        $("#modal_delete").modal('toggle');
        alertas("#msj-success", response, null);
    })
}


 function store (url,id, rest, scope, idselect, modalstate) {
    angular.copy({}, scope.retorno);
    if (modalstate === 'edit'){
       rest.rest(url).update({id: id},scope.entity).$promise.then(function successCallback(response) {
            alertas("#msj-success", response,  idselect);
           scope.getresult(scope.currentpage);
        }, function errorCallback(msj) {
            scope.retorno = msj.data;
        });
    } else {
       rest.rest(url).save(scope.entity).$promise.then(function successCallback(response) {
            alertas("#msj-success", response,  idselect);
           scope.getresult(scope.currentpage);
        }, function errorCallback(msj) {
            scope.retorno = msj.data;
        });
    }

}


 function setorders(field, idfs, scope) {
    if(scope.order.field !== field) {
        $('#'+scope.order.idfs).removeClass('fa-sort-down fa-sort-up').addClass('fa-sort');
        scope.order.idfs =  idfs;
        scope.order.field = field;
        scope.order.type = scope.order.type == 'desc' ? 'acs': 'desc';
        $('#'+idfs).removeClass('fa-sort-down fa-sort-up').addClass(scope.order.type == 'desc' ? 'fa-sort-down': 'fa-sort-up');

    } else {
        if (scope.order.type == 'desc'){
            $('#'+idfs).removeClass('fa-sort-down fa-sort-up').addClass('fa-sort-up');
            scope.order.type = 'asc';
        } else {
            $('#'+idfs).removeClass('fa-sort-down fa-sort-up').addClass('fa-sort-down');
            scope.order.type = 'desc';
        }
    }
}

 function toggleform (url, modalstate, id, scope, rest, labels) {
    scope.modalstate = modalstate;
    angular.copy({}, scope.retorno);
    switch (modalstate) {
        case 'add':
            if (id == null){
                scope.form_title = labels.add;
                angular.copy({}, scope.entity);
            } else {
                angular.copy({}, scope.entity);
                rest.rest(url).get({id: id}).$promise.then(function(response){
                    scope.form_title = labels.clon;
                    scope.entity = response;
                });
            }
            break;
        case 'edit':
            rest.rest(url).get({id: id}).$promise.then(function(response){
                scope.form_title = labels.edit;
                scope.entity = response;
            });
            break;
        default:
            break;
    }
    $('#modal_add_edit').modal('show');
}