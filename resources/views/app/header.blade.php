<div ng-controller="header_ctrl" >
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand nbarcolor" href="/abaut">eapymes </a>

        </div>

        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <!-- Catalogos -->
            <ul class="nav navbar-nav navbar-left">
                <li><a href="/"><i class="fa fa-home"></i>&nbsp;Inicio</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catalogos&nbsp;&nbsp;<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/measures"><i class="fa fa-crop"></i>&nbsp;&nbsp;Medidas</a></li>
                        <li><a href="/categories"><i class="fa fa-umbrella"></i>&nbsp;&nbsp;Categorias</a></li>
                        <li><a href="/taxs"><i class="fa fa-money"></i>&nbsp;&nbsp;Impuestos</a></li>
                        <li><a href="/discounts"><i class="fa fa-percent"></i>&nbsp;&nbsp;Descuentos</a></li>
                        <li class="divider"></li>
                        <li><a href="/products"><i class="fa fa-cube"></i>&nbsp;&nbsp;Productos</a></li>
                        <li><a href="/ingredients"><i class="fa fa-spinner"></i>&nbsp;&nbsp;Ingredientes</a></li>
                        <li class="divider"></li>
                        <li><a href="/persons"><i class="fa fa-users"></i>&nbsp;&nbsp;Personas</a></li>
                        <li><a href="/profiles"><i class="fa fa-unlock"></i>&nbsp;&nbsp;Perfiles</a></li>
                        <li class="divider"></li>
                        <li><a href="/users"><i class="fa fa-user"></i>&nbsp;&nbsp;Usuarios</a></li>

                    </ul>
                </li>

            </ul>
            <!-- Almacenes -->
            <ul class="nav navbar-nav navbar-left">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Inventarios&nbsp;&nbsp;<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/stores"><i class="fa fa-server"></i>&nbsp;&nbsp;Almacenes</a></li>
                        <li><a href="/shelves"><i class="fa fa-archive"></i>&nbsp;&nbsp;Estantes</a></li>
                        <li><a href="/opens"><i class="fa fa-braille"></i>&nbsp;&nbsp;Aperturas</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/stocks"><i class="fa fa-cubes"></i>&nbsp;&nbsp;Existencias</a></li>
                        <li><a href="#"><i class="fa fa-file-movie-o"></i>&nbsp;&nbsp;Movimientos</a></li>
                        <li><a href="#"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Compras</a></li>
                        <li><a href="/labels"><i class="fa fa-barcode"></i>&nbsp;&nbsp;Etiquetas</a></li>
                    </ul>
                </li>
            </ul>
            <!-- Reportes -->
            <ul class="nav navbar-nav navbar-left">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes&nbsp;&nbsp;<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/storehouses"><i class="fa fa-server"></i>&nbsp;&nbsp;Productos x Almacen</a></li>
                        <li><a href="/shelves"><i class="fa fa-archive"></i>&nbsp;&nbsp;Lento movimiento</a></li>
                        <li><a href="/opens"><i class="fa fa-braille"></i>&nbsp;&nbsp;Ventas</a></li>
                    </ul>
                </li>
                <li ng-hide="test"><a href="/pruebas">Pruebas</a></li>
            </ul>
            <!-- Sistema -->
            <ul class="nav navbar-nav navbar-right">
                <li>  <p class="navbar-text usuario"></p></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sistema&nbsp;&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-user"></i>&nbsp;&nbsp; </a></li>
                        <li><a href="auth/logout"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Salir</a></li>
                        <li><a href="#"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Configuraciones</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="fa fa-info"></i>&nbsp;&nbsp;Sobre eaPymes</a></li>
                    </ul>
                </li>

            </ul>

        </div>

    </div>
</nav>
<input type="hidden" value="12" id="userauth">
</div>
<div class="container page_fix">