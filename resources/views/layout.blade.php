<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>eapymes</title>
    <!-- Estilos -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/toggle-switch.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-resource.min.js"></script>
    <script src="js/toggle-switch.js"></script>
    <script src="js/underscore.js"></script>
    <script src="js/utiles.js"></script>
    <script src="app/ea.js"></script>
    <script src="app/header.js"></script>
    @yield('scripts')
</head>
<body ng-app="ea">
@include('app.header')
@yield('content')
@include('app.footer')
</body>
</html>