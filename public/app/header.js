app.controller('header_ctrl', ['$scope', 'userauth', function ($scope, userauth ) {
   userauth.id = $('#userauth').val();
     
}]);
