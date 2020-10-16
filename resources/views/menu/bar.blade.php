<ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="files" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            ARCHIVOS
        </a>
        <ul class="dropdown-menu" aria-labelledby="files">
            {{-- <li><a href="{{route('users.index')}}" class="dropdown-item undecorated">USUARIOS</a>
    </li> --}}
    <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">GEOGRAFIA</a>
        <ul class="dropdown-menu">
            <li><a href="{{route('countries.index')}}" class="dropdown-item undecorated">PAISES</a></li>
            <li><a href="{{route('provinces.index')}}" class="dropdown-item undecorated">PROVINCIAS</a></li>
            <li><a href="{{route('districts.index')}}" class="dropdown-item undecorated">DEPARTAMENTOS</a></li>
            <li><a href="{{route('towns.index')}}" class="dropdown-item undecorated">LOCALIDADES</a></li>
            <li><a href="{{route('neighborhoods.index')}}" class="dropdown-item undecorated">BARRIOS</a></li>
        </ul>
    </li>
    <li><a href="{{route('visitDays.index')}}" class="dropdown-item undecorated">DIAS VISITA</a></li>
    <li><a href="{{route('commerces.index')}}" class="dropdown-item undecorated">COMERCIOS</a></li>
    <li><a href="{{route('companies.index')}}" class="dropdown-item undecorated">EMPRESAS</a></li>
    <li><a href="{{route('stores.index')}}" class="dropdown-item undecorated">DEPOSITOS</a></li>
</ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="staff" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        PERSONAL
    </a>
    <ul class="dropdown-menu" aria-labelledby="staff">
        <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">VENDEDORES</a>
            <ul class="dropdown-menu">
                <li><a href="{{route('sellers.index')}}" class="dropdown-item undecorated">VENDEDORES</a></li>
                <li><a href="{{route('expenses')}}" class="dropdown-item undecorated">GASTOS</a></li>
            </ul>
        </li>
        <li><a href="{{route('deliveries.index')}}" class="dropdown-item undecorated">ENTREGAS</a></li>
        <li><a href="{{route('routes.index')}}" class="dropdown-item undecorated">RECORRIDOS</a></li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="clients" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        CLIENTES
    </a>
    <ul class="dropdown-menu" aria-labelledby="clients">
        <li><a href="{{route('kinships.index')}}" class="dropdown-item undecorated">PARENTESCO</a></li>
        <li><a href="{{route('customers.index')}}" class="dropdown-item undecorated">CLIENTES</a></li>
        <li><a href="{{route('customers.sequence')}}" class="dropdown-item undecorated">SECUENCIA</a></li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="suppliers" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        PROVEEDORES
    </a>
    <ul class="dropdown-menu" aria-labelledby="suppliers">
        <li><a href="{{route('travelers.index')}}" class="dropdown-item undecorated">VIAJANTES</a></li>
        <li><a href="{{route('suppliers.index')}}" class="dropdown-item undecorated">PROVEEDORES</a></li>
        <li><a href="{{route('buys.create')}}" class="dropdown-item undecorated">COMPRAS</a></li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="articles" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        ARTICULOS
    </a>
    <ul class="dropdown-menu" aria-labelledby="articles">
        <li><a href="{{route('articleCategories.index')}}" class="dropdown-item undecorated">CATEGORIAS</a></li>
        <li><a href="{{route('attributes.index')}}" class="dropdown-item undecorated">ATRIBUTOS</a></li>
        <li><a href="{{route('articles.index')}}" class="dropdown-item undecorated">ARTICULOS</a></li>
        {{--<li><a href="{{route('stocks.transfer')}}" class="dropdown-item undecorated">TRANSFERENCIAS</a>
</li>--}}
<li><a href="{{route('articles.prices.index')}}" class="dropdown-item undecorated">PRECIOS</a></li>
<li><a href="{{route('inventory')}}" class="dropdown-item undecorated">INVENTARIO</a></li>
</ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="suppliers" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        CAJA
    </a>
    <ul class="dropdown-menu" aria-labelledby="suppliers">
        <li><a href="{{route('movreasons.index')}}" class="dropdown-item undecorated">MOTIVOS</a></li>
        <li><a href="{{route('cash.actual')}}" class="dropdown-item undecorated">CAJA ACTUAL</a></li>
        <li><a href="{{route('cashes.index')}}" class="dropdown-item undecorated">CAJA HISTORICA</a></li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="articles" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        CREDITOS
    </a>
    <ul class="dropdown-menu" aria-labelledby="articles">
        <li><a href="{{route('credits.index')}}" class="dropdown-item undecorated">LISTADO</a></li>
        <li><a href="{{route('credits.create')}}" class="dropdown-item undecorated">CREDITO</a></li>
        <li><a href="{{route('credits.collection')}}" class="dropdown-item undecorated">COBRANZA</a></li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="reports" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        INFORMES
    </a>
    <ul class="dropdown-menu" aria-labelledby="files">
        <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">ARTICULOS</a>
            <ul class="dropdown-menu">
                <li><a href="{{route('price.list')}}" class="dropdown-item undecorated">PRECIOS</a></li>
                <li><a href="{{route('stock.list')}}" class="dropdown-item undecorated">STOCK</a></li>
            </ul>
        </li>
        <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">CREDITOS</a>
            <ul class="dropdown-menu">
                <li><a href="{{route('credits.total')}}" class="dropdown-item undecorated">TOTAL GENERAL</a></li>
                <li><a href="{{route('sales.general')}}" class="dropdown-item undecorated">VENTAS GENERAL</a></li>
            </ul>
        </li>
        <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">LIQUIDACIONES</a>
            <ul class="dropdown-menu">
                <li><a href="{{route('payments.sellers')}}" class="dropdown-item undecorated">VENDEDOR</a></li>
            </ul>
        </li>
        <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">CAJA</a>
            <ul class="dropdown-menu">
                <li><a href="{{route('cash.list')}}" class="dropdown-item undecorated">LISTADO</a></li>
            </ul>
        </li>
        <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">RECLAMOS</a>
            <ul class="dropdown-menu">
                <li><a href="{{route('claims.list')}}" class="dropdown-item undecorated">LISTADO</a></li>
            </ul>
        </li>
        <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">COMPRAS</a>
            <ul class="dropdown-menu">
                <li><a href="{{route('buys.report-form')}}" class="dropdown-item undecorated">LISTADO</a></li>
            </ul>
        </li>
    </ul>
</li>
</ul>
