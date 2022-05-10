<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>DATA IESVU</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/scripts.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
                            Mis datos
                        </a>
                    </li>
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
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    @if(!Auth::user())
    <script>
        if($( window ).width() > 1000){
            $('#layoutSidenav_content').css('padding-left',0);
        };
    </script>
    @endif
</body>

</html>