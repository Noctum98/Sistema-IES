<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top p-2 mb-2">
            <div class="container">
                <a class="navbar-brand" href="{{route('home')}}">
                    <img src="{{ asset('images/logo.png') }}" style="width: 56px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item ">
                                    <a class="nav-link " href="{{ route('login') }}">Iniciar Sesión</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" v-pre>
                                    {{ Auth::user()->nombre.' '.Auth::user()->apellido }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('usuarios.editar') }}">
                                        Mi Perfil
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                              </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid pt-4 mt-3">
          <div class="row">
            @if(Auth::user())
            <nav class="col-md-2 d-none d-md-block bg-dark sidebar p-4 position-fixed">
              <div class="sidebar-sticky">
                <ul class="nav flex-column">
                  <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                      <span>Administración</span>
                      <a class="d-flex align-items-center text-muted" href="#">
                        <span data-feather="plus-circle"></span>
                      </a>
                  </h6>
                  @if(Auth::user()->rol == 'rol_admin' || Auth::user()->rol == 'rol_main')
                  <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('pre.admin') }}">
                      <span data-feather="home"></span>
                      Preinscripciones <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  @endif
                  @if(Auth::user()->rol == 'rol_admin' || Auth::user()->rol == 'rol_main_1' || Auth::user()->rol == 'rol_main_2')
                  <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('mesa.admin') }}">
                      <span data-feather="users"></span>
                      Mesas
                    </a>
                  </li>
                  @endif
                  @if(Auth::user()->rol == 'rol_admin')
                  <li class="nav-item">
                    <a class="nav-link text-light active" href="{{ route('usuarios.admin') }}">
                      <span data-feather="home"></span>
                      Usuarios <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('sedes.admin') }}">
                      <span data-feather="home"></span>
                      Sedes
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('personal.admin') }}">
                      <span data-feather="file"></span>
                      Personal
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('carrera.admin') }}">
                      <span data-feather="shopping-cart"></span>
                      Carreras
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('alumno.admin') }}">
                      <span data-feather="users"></span>
                      Alumnos
                    </a>
                  </li>
                   </li>
                    
                 <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                      <span>Institución</span>
                      <a class="d-flex align-items-center text-muted" href="#">
                        <span data-feather="plus-circle"></span>
                      </a>
                  </h6>
                  <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('asis.inicio') }}">
                      <span data-feather="layers"></span>
                      Planilla de Asistencia
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('trab.inicio') }}">
                      <span data-feather="layers"></span>
                      Planilla de Trabájos Prácticos
                    </a>
                  </li>
                   <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('parci.inicio') }}">
                      <span data-feather="layers"></span>
                      Planilla de Parciales
                    </a>
                  </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                  <span>Editando de prueba</span>
                  <a class="d-flex align-items-center text-muted" href="#">
                    <span data-feather="plus-circle"></span>
                  </a>
                </h6>
                <ul class="nav flex-column mb-2">
                  <li class="nav-item text-light">
                    <a class="nav-link" href="#">
                      <span data-feather="file-text"></span>
                      Editando prueba 2
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light" href="#">
                      <span data-feather="file-text"></span>
                      Last quarter
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light" href="#">
                      <span data-feather="file-text"></span>
                      Social engagement
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light" href="#">
                      <span data-feather="file-text"></span>
                      Year-end sale
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-light" href="#">
                      <span data-feather="file-text"></span>
                      Year-end sale
                    </a>
                  </li>
                  @endif
                </ul>
              </div>
            </nav>
            @endif
            <main role="main" class="col-md-9 mt-4 ml-sm-auto px-4 {{ Auth::user() ? 'col-lg-10' : 'col-lg-12'  }}">
              <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
              @yield('content')
          </main>
        </div>
    </div>

</body>
</html>
