var app = angular.module('ea', ['ngResource', 'toggle-switch']).config(function($interpolateProvider)
{
  $interpolateProvider.startSymbol('<%').endSymbol('%>')
})
    
.directive('paginate', function() {
  return {templateUrl: '../tpl/paginator.php'}
})
    
.service('restAPI',  function($resource) {
  this.rest = function (url) {
    return $resource(url + '/:id', { id: '@_id' }, {update: { method: 'PUT', params : {id : '@_id'}}})
  }
})

.directive('eafilter', function() {
    return {
        restrict: 'E',
        template: function (elem, attr ) {
            var caretstar = (attr.caret !== 'off')? '<div class="input-group input-group-sm">':'';
            var caretend = (attr.caret !== 'off') ?'<span class="input-group-addon" id="sizing-addon1"><i class="fa fa-search"></i></span></div>' :'';
            return caretstar +
            '<input ng-class="{changefilter : filter.'+attr.field +' !== \'\'}" class="form-control input-sm" placeholder="buscar.." ng-model="filter.' + attr.field +'">'
            + caretend;
        }

    }
})
.directive('eafilterselect', function() {
        return {
            restrict: 'E',
            template: function (elem, attr ) {
            return  '<div class="btn-group bnt_filter_fix">'+
                    '<button ng-class="{\'bnt_filter_change\':'+attr.filtertobj+ '.selected!==\'..sin filtro..\'}" type="button" class="btn btn-default dropdown-toggle btn-sm bnt_filter_fix" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                    '<%'+ attr.filtertobj +'.selected%> &nbsp;<i class="fa fa-search"></i></button><ul class="dropdown-menu">'+
                    '<li  ng-repeat="op in '+attr.filtertobj+'.values" ng-click="setfilter(\'' + attr.field +'\', op,' + attr.filtertobj+')"><a href="#"><%op.name%></a></li></ul></div>';

            }
        }
})
.directive('eafieldorder', function() {
        return {
            template: function (elem, attr ) {
                return '<label>' + attr.display + ' &nbsp;<i id="' + attr.idfs +'" ng-click="setorder(\'' + attr.field+ '\', \''+ attr.idfs + '\')" class="fa fa-sort mouse"></i></label>';
            }

        }
})
.service('entity_ingres', [function() {

    return  {id : 0, values : []}

}])
    
.factory('userauth', [function() {

        return  {id : 0, idhelp : 0}

}])
    
.directive('uploaderModel', ["$parse", function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, iElement, iAttrs)
            {
                iElement.on("change", function(e)
                {
                    $parse(iAttrs.uploaderModel).assign(scope, iElement[0].files[0]);
                });
            }
        };
}])

.service('upload', ["$http", "$q", function ($http, $q)
    {
        this.uploadFile = function(file, name)
        {
            var deferred = $q.defer();
            var formData = new FormData();
            formData.append("name", name);
            formData.append("file", file);
            return $http.post("/persons/imgstore", formData, {
                headers: {
                    "Content-type": undefined
                },
                transformRequest: angular.identity
            })
                .success(function(res)
                {
                    deferred.resolve(res);
                })
                .error(function(msg, code)
                {
                    deferred.reject(msg);
                });
            return deferred.promise;
        }
}]);


