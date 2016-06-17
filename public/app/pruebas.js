app.controller('pruebas_clr', [ '$scope', 'upload', function ($scope, upload){
  $scope.imgrute = 'user2.png';

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
        var name = 'noname'+  Math.trunc(Math.random() * (500 - 1) + 1);
        var file = $scope.file;

        upload.uploadFile(file, name).then(function(res)
        {
            $scope.imgrute = name;
        })
    }
}]);
