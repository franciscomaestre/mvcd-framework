<header><!--header-->
    <!-- Static navbar -->
    {$siteUrl='http://www.grupeo-tool.net'}
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Grupeo Tool</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{$siteUrl}/">Inicio</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Productos <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{$siteUrl}/listaProductos/busqueda/1/0">Buscar</a></li>
                            <li class="divider"></li>
                            <li><a href="{$siteUrl}/listaProductos/novedades/1/0">Novedades</a></li>
                            <li><a href="{$siteUrl}/listaProductos/destacados/1/0">Destacados</a></li>
                            <li><a href="{$siteUrl}/listaProductos/premium/1/0">Mas vendidos</a></li>
                            <li><a href="{$siteUrl}/listaProductos/promo/1/0">Promo</a></li>
                            <li><a href="{$siteUrl}/listaProductos/publicados/1/0">Publicados</a></li>
                            <li class="divider"></li>
                            <li><a href="{$siteUrl}/producto/insertar">Nuevo Producto</a></li>
                            <li><a href="{$siteUrl}/productoCSV/importarProductos">Importar Productos CSV</a></li>
                            <li class="divider"></li>
                            <li><a href="{$siteUrl}/listaMarcas">Marcas</a></li>
                        </ul>
                    </li>
                    <li><a href="{$siteUrl}/listaProductosTemporales">Dropshippings</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pedidos <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{$siteUrl}/listaPedidos/buscador">Buscar</a></li>
                            <li class="divider"></li>
                            <li><a href="{$siteUrl}/listaPedidos/pendientes">Pendientes</a></li>
                            <li><a href="{$siteUrl}/listaPedidos/atendidos/0">Atendidos</a></li>
                            <li><a href="{$siteUrl}/listaPedidos/atendidosContrareembolso/0">Atendidos contrareembolso</a></li>
                            <li><a href="{$siteUrl}/listaPedidos/anulados">Anulados</a></li>
                            <li><a href="{$siteUrl}/listaPedidos/incidencias">Incidencias</a></li>
                            <li><a href="{$siteUrl}/listaPedidos/devoluciones">Devoluciones</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tienda <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{$siteUrl}/listaCategorias/ver/1">Categorias</a></li>
                            <li><a href="{$siteUrl}/categoria/conceptos">Conceptos</a></li>
                            <li><a href="{$siteUrl}/listaSecciones/ver/1">Secciones</a></li>
                            <li><a href="{$siteUrl}/listaLandings/1">Landings</a></li>
                            <li><a href="{$siteUrl}/listaSubdominios/ver/1">Subdominios</a></li>
                            <li><a href="{$siteUrl}/listaDescuentos/ver/1">Descuentos</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Estadísticas <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{$siteUrl}/reportes/productos">Reporte Productos</a></li>
                            <li><a href="{$siteUrl}/reportes/pedidos">Reporte Pedidos</a></li>
                            <li><a href="{$siteUrl}/reportes/cartilla">Reporte Cartilla</a></li>
                            <li class="divider"></li>
                            <li><a href="{$siteUrl}/reportes/informe">Informe</a></li>
                            <li><a href="/summary/kpis">Resumen</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Merchants <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{$siteUrl}/listaMerchants/ver">Buscar</a></li>
                            <li class="divider"></li>
                            <li><a href="{$siteUrl}/listaMerchants/pedidos">Ver pedidos</a></li>
                            <li><a href="{$siteUrl}/pedidos/realizarPedidos">Enviar pedido</a></li>
                            <li><a href="{$siteUrl}/pedidosBigbuy/tramitarPedidos">Enviar pedido BigBuy</a></li>
                        </ul>
                    </li>
                    <li><a href="{$siteUrl}/memcached/render">Caché</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/logout">Cerrar sesión</a></li>
                </ul>
                {if $allowedShops|default:false}
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <strong>
                                    {$adminShop->getText()->getName()}
                                </strong>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                {foreach from=$allowedShops item=allowedShop}
                                    <li>
                                        <a href="#" onclick="changeShop({$allowedShop->getId()})">
                                            {$allowedShop->getText()->getName()}
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        </li>
                    </ul>
                {/if}
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</header>