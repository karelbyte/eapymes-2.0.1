<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>eapymes</title>
    <!-- Estilos -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
    <div class="row" style="margin-top: 25px;">
        <div class="col-xs-1 col-lg-4 col-md-4 col-sm-2"></div>
        <div class="col-xs-10 col-lg-4 col-md-4 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading mdl-header_fix">
                  eapymes
                </div>
            	<div class="panel-body mdl-body_fix">
                    <form action="/auth/login" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label>Usuario:</label>
                            <input class="form-control input-sm" style="text-shadow: 1px 1px 1px rgba(0,0,0,0.3);" id="nick" name="nick">
                        </div>
                        <div class="form-group">
                            <label >Clave:</label>
                            <input type="password" class="form-control input-sm" id="password" name="password">
                        </div>
            	</div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;Acceder</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-1 col-lg-4 col-md-4 col-sm-2"></div>
   </div>
</div>

</body>
</html>