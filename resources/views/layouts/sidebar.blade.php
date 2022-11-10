<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                @if(!Session::has('alumno'))
                <div class="sb-sidenav-menu-heading">Administración</div>
                <a class="nav-link" href="{{ route('usuarios.mis_datos')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                    Mis datos
                </a>
                @endif
                @if(Session::has('admin'))
                <a class="nav-link" href="{{ route('usuarios.admin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Usuarios
                </a>
                @endif
                @if(Session::has('listas'))
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseListado" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                    Lista de Personal
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseListado" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('usuarios.listado','profesor') }}">Lista de
                            Profesores</a>
                        @if(Session::has('admin') || Session::has('regente'))
                        <a class="nav-link" href="{{ route('usuarios.listado','coordinador') }}">Lista de
                            Coordinadores</a>
                        @endif
                    </nav>
                    @if(Session::has('admin') || Session::has('regente'))
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('usuarios.listado','coordinador') }}">Lista de
                            Coordinadores</a>
                    </nav>
                    @endif
                </div>
                @endif
                @if(Session::has('cargos'))
                <a class="nav-link" href="{{ route('cargo.admin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-contract"></i></div>
                    Cargos
                </a>
                @endif
                @if(Session::has('preinscripciones'))
                <a class="nav-link" href="{{ route('pre.admin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fas fa-poll-h"></i></div>
                    Preinscripciones
                </a>
                @endif
                @if(Session::has('sedes'))
                <a class="nav-link" href="{{ route('sedes.admin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-city"></i></div>
                    Sedes
                </a>
                @endif
                @if(Session::has('carreras'))
                <a class="nav-link" href="{{ route('carrera.admin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                    Carreras
                </a>
                @endif
                @if(Session::has('mesas'))
                <a class="nav-link" href="{{ route('mesa.admin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
                    Mesas
                </a>
                @endif
                @if(Session::has('admin_alumnos'))
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Alumnos
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('alumno.admin') }}">Administrar</a>
                    </nav>
                </div>
                @endif
                @if(Session::has('planillas'))
                <div class="sb-sidenav-menu-heading">Profesor</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePlanillas" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Planillas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePlanillas" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('calificacion.home') }}">Planilla de Calificaciones</a>
                        <a class="nav-link" href="{{ route('asis.inicio') }}">Planilla de Asistencia</a>

                        @if(Session::has('planillas') && Session::has('admin') )
                        <a class="nav-link" href="{{ route('tipoCalificaciones.index') }}">Tipo Calificaciones</a>
                        <a class="nav-link" href="{{ route('estados.index') }}">Estados <small>(Alumno Materia)</small></a>
                        @endif
                    </nav>
                </div>
                @endif


                @if(Session::has('alumno'))
                <div class="sb-sidenav-menu-heading">Alumno</div>
                <a class="nav-link" href="{{ route('alumno.detalle',Auth::user()->alumno()) }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                    Mi matrícula
                </a>
                <a class="nav-link" href="{{ route('mesa.instancias') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-reader"></i></div>
                    Mesas
                </a>
                <!-----
                    <a class="nav-link" href="{{ route('proceso.alumno',Auth::user()->alumno()) }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                        Mis procesos
                    </a>
                     ----->
                @endif
                <a class="nav-link" href="https://drive.google.com/drive/folders/1crwsQzH8bVTu2c6oWFN5Qf4-ra7lVSzG" target="__blank">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Biblioteca
                </a>
                @if(Session::has('admin'))
                <a class="nav-link" href="{{ route('actasVolantes.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Mesas Profesor
                </a>
                @endif
            </div>
        </div>
    </nav>
</div>