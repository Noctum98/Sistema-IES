<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>DATA IESVU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="{{asset('css/simple-datatables_style.css')}}" rel="stylesheet" />
    <link href="{{asset('css/font-awesome/6.5.2/css/all.css')}}" rel="stylesheet" />
    <link href="{{asset('css/font-awesome/6.5.2/css/v5-font-face.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/font-awesome/6.5.2/css/v4-shims.min.css')}}" rel="stylesheet" />


    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/scripts.js') }}" defer></script>
    <script src="{{asset('js/jquery_1.11.3.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}" ></script>
    <script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendors/select2/js/i18n/es.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>


    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">


    @yield('scripts')


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/select2/css/select2.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/styless.css') }}" />

</head>

<body class="sb-nav-fixed" id="body">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{route('home')}}">
            <img src="{{ asset('images/logo.png') }}" height="60px" alt="">
        </a>
        <!-- Sidebar Toggle-->
        @if(Auth::user())
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        @endif
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        </div>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            @guest
            @if (Route::has('login'))
            <li class="nav-item ">
                <a class="nav-link " href="{{ route('login') }}">Iniciar Sesión</a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->nombre.' '.Auth::user()->apellido }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('usuarios.editar') }}">
                            Mi Perfil
                        </a>
                    </li>
                    @if(Session::has('admin') || Session::has('avisos'))
                    <li>
                        <a class="dropdown-item" href="{{ route('tickets.ticket.index') }}">
                            Tickets
                        </a>
                    </li>
                    @endif
                    <hr class="dropdown-divider" />
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Cerrar Sesión') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
        </li>
        @endguest
        </ul>
    </nav>
    <div id="layoutSidenav">
        @if(Auth::user())
        @include('layouts.sidebar')
        @endif
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 p-3">
                    @include('layouts.alerts')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script src="{{asset('vendors/font-awesome/5.15.3/js/all.js')}}" ></script>
    @if(!Auth::user())
    <script>
        if($( window ).width() > 1000){
            $('#layoutSidenav_content').css('padding-left',0);
        }
    </script>
    @endif

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>

</body>

</html>
