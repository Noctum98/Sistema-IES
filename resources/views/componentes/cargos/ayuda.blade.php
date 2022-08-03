@extends('layouts.app-prueba')
@section('content')
    <style>
        .col-xl-3:hover img {
            -webkit-transform: scale(4) translateX(-40%);
            transform: scale(4) translate(-40%, -30%);
            transition: all .9s ease-in-out;
            z-index: 100 !important;
            position: relative;
        }

        img.img-fluid {
            z-index: 100 !important;
            background-color: #1a202c;
            position: relative;
        }

        .accordion-header, .accordion-button, .accordion-item {
            z-index: 1 !important;
            position: relative;

        }

        .col-xl-3 {
            overflow: visible;
        }
    </style>
    <section class="py-2">
        <div class="container px-5 my-2">
            <div class="text-center mb-5">
                <h1 class="fw-bolder">Preguntas frecuentes</h1>
                <p class="lead fw-normal text-muted mb-0">Y usos comunes de <b>Data</b> <i>IESVU</i></p>
            </div>
            <div class="row gx-5">
                <div class="col-xl-10">
                    <!-- FAQ Accordion 1-->
                    <h4 class="fw-bolder mb-3">Cargos</h4>
                    <h5 class="fw-bolder mb-3">Configuraciones</h5>
                    <div class="mb-5" id="accordionConfig">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingHome">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseHome" aria-expanded="true"
                                        aria-controls="collapseHome">
                                    Acceso a los cargos
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse show" id="collapseHome"
                                 aria-labelledby="headingHome"
                                 data-bs-parent="#accordionConfig">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="col-xl-9">
                                                <strong>Para ingresar a la configuración de los cargos se debe ir al
                                                    menú lateral derecho.</strong>
                                                Y hacer clic en <code>Cargos</code>
                                            </div>
                                            <div class="col-xl-3">

                                                <img class="me-3 img-fluid"
                                                     src="{{asset('images/ayuda/cargos/home.png')}}"
                                                     alt="home"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingCargos">
                                <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseCargos" aria-expanded="true"
                                        aria-controls="collapseCargos">
                                    Vista Cargos
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse show" id="collapseCargos"
                                 aria-labelledby="headingCargos"
                                 data-bs-parent="#accordionConfig">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="col-xl-9">
                                                La vista de los cargos tienen distintas <strong>acciones
                                                    identificadas</strong> por botones y nombres descriptivos<br/>
                                                <ul>
                                                    <li><code>Botón de lupa</code> para buscar cargos en caso de que el
                                                        listado sea muy extenso
                                                    </li>
                                                    <li><code>Crear cargo</code> da acceso al formulario para crear
                                                        cargos
                                                    </li>
                                                    <li><code>Filtros</code> permite hacer una busqueda más específica
                                                        de cargos
                                                    </li>
                                                    <li><code><a href="#headingConfigurarCargos">Configurar</a></code>
                                                        da acceso a la configuración general del
                                                        cargo
                                                    </li>
                                                    <li><code>Editar</code> abre un formulario que permite editar los
                                                        datos básicos de un cargo
                                                    </li>
                                                </ul>
                                                En el listado central podemos ver el identificador, nombre, módulos a
                                                los que está enlazado y su ponderación en relación con el mismo y la
                                                carrera a la que pertenece

                                            </div>
                                            <div class="col-xl-3">
                                                <img class="me-3 img-fluid"
                                                     src="{{asset('images/ayuda/cargos/cargos.png')}}"
                                                     alt="home"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingConfigurarCargos">
                                <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseConfigurarCargos" aria-expanded="true"
                                        aria-controls="collapseConfigurarCargos">
                                    Vista Configurar Cargos Módulos
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse show" id="collapseConfigurarCargos"
                                 aria-labelledby="headingConfigurarCargos"
                                 data-bs-parent="#accordionConfig">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="col-xl-9">
                                                Desde la <b>configuración de Cargos</b> podemos <code>Agregar
                                                    módulo</code> que estará vinculado al cargo.<br/>
                                                En el <b> primer listado</b> tendremos la información de los módulos
                                                vinculados:
                                                <i>identificador</i>, <i>nombre</i>, <i>ponderación</i> pudiendo ser
                                                modificada
                                                (la ponderación es del cargo con respecto al módulo), <i>ponderación
                                                    total del módulo</i> y las <i>acciones disponibles</i> que en este
                                                caso es <b>Eliminar</b>.<br/>
                                            </div>
                                            <div class="col-xl-3">
                                                <img class="me-3 img-fluid"
                                                     src="{{asset('images/ayuda/cargos/configurar-cargos.png')}}"
                                                     alt="home"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingConfigurarCargosUsuarios">
                                <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseConfigurarCargosUsuarios" aria-expanded="true"
                                        aria-controls="collapseConfigurarCargosUsuarios">
                                    Vista Configurar Cargos Usuarios
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse show" id="collapseConfigurarCargosUsuarios"
                                 aria-labelledby="headingConfigurarCargosUsuarios"
                                 data-bs-parent="#accordionConfig">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="col-xl-9">
                                                Desde la <b>configuración de Cargos</b> podemos <code>Agregar
                                                    usuario</code> que será/serán quién/quienes este/estén a cargo de
                                                impartir el cargo.<br/>
                                                En el <b> segundo listado</b> tendremos la información de quién/quienes
                                                sean los responsables del cargo:
                                                <i>identificador</i>, <i>nombre</i>, <i>módulo</i> que tiene la acción
                                                de <a href="#configurar-cargo-modulo-user"> vincular</a> el par
                                                cargo-módulo con quién impartirá el mismo,
                                                <i> cargo </i> y las <i>acciones disponibles</i> que en este
                                                caso es <b>Eliminar</b>.<br/>
                                            </div>
                                            <div class="col-xl-3">
                                                <img class="me-3 img-fluid"
                                                     src="{{asset('images/ayuda/cargos/configurar-cargos-2.png')}}"
                                                     alt="home"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="accordion-item" id="configurar-cargo-modulo-user">
                            <h3 class="accordion-header" id="headingConfigurarCargosModuloUsuario">
                                <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseConfigurarCargosModuloUsuario" aria-expanded="true"
                                        aria-controls="collapseConfigurarCargosModuloUsuario">
                                    Vista Vincular Cargo - Módulo - Usuarios
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse show" id="collapseConfigurarCargosModuloUsuario"
                                 aria-labelledby="headingConfigurarCargosModuloUsuario"
                                 data-bs-parent="#accordionConfig">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="col-xl-9">
                                                Desde la <b>vinculación Cargo-Modulo-Usuario</b> asignaremos la relación
                                                del cargo con el módulo y quién impartirá ese cargo en ese módulo.<br/>
                                                El formulario mostrará todos los módulos relacionados con el cargo
                                                factibles de ser asignados.<br/>
                                                Debe tenerse en cuenta que es de selección múltiple, por lo que se
                                                pueden asignar todos los módulos deseados, si no se selecciona ninguno,
                                                no se asignará ninguno y se borrará toda asignación anterior.<br/>
                                                Si no desea realizar cambios en las asignaciones simplemente cierre el
                                                formulario desde el botón <code>cerrar</code>
                                            </div>
                                            <div class="col-xl-3">
                                                <img class="me-3 img-fluid"
                                                     src="{{asset('images/ayuda/cargos/administrar-cargo-modulo-user.png')}}"
                                                     alt="home"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <!-- FAQ Accordion 2-->
                    <h5 class="fw-bolder mb-3">Planillas</h5>
                    <div class="mb-5" id="accordionPlanilla">
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingHomePlanilla">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseHomePlanilla" aria-expanded="true"
                                        aria-controls="collapseHome">
                                    Acceso a las planillas cargos
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse show" id="collapseHomePlanilla"
                                 aria-labelledby="headingHomePlanilla"
                                 data-bs-parent="#accordionPlanilla">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="col-xl-9">
                                                Para ingresar a la planilla de los cargos se debe ir al <strong>menú
                                                    lateral derecho.</strong> y hacer clic en <code>Planillas ->
                                                    Planilla de Calificaciones</code>
                                            </div>
                                            <div class="col-xl-3">

                                                <img class="me-3 img-fluid"
                                                     src="{{asset('images/ayuda/cargos/home.png')}}"
                                                     alt="home"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingCalificaciones">
                                <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseCalificaciones" aria-expanded="true"
                                        aria-controls="collapseCCalificaciones">
                                    Vista Calificaciones
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse show" id="collapseCalificaciones"
                                 aria-labelledby="headingCalificaciones"
                                 data-bs-parent="#accordionPlanilla">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="col-xl-9">
                                                La vista de calificaciones tiene 2 secciones:
                                                <ul>
                                                    <li>Materias</li>
                                                    <li>Cargos</li>
                                                </ul>
                                                desde donde se puede acceder a la administración de sus respectivas
                                                calificaciones.
                                            </div>
                                            <div class="col-xl-3">
                                                <img class="me-3 img-fluid"
                                                     src="{{asset('images/ayuda/cargos/calificaciones.png')}}"
                                                     alt="calificaciones"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingAdminCalificaciones">
                                <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseAdminCalificaciones" aria-expanded="true"
                                        aria-controls="collapseAdminCalificaciones">
                                    Vista Administración de Calificaciones
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse show" id="collapseAdminCalificaciones"
                                 aria-labelledby="headingAdminCalificaciones"
                                 data-bs-parent="#accordionPlanilla">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="col-xl-9">
                                                Desde la <b>administración de Calificaciones</b> podemos
                                                <ul>
                                                    <li><code>Crear</code> nuevas calificaciones.</li>
                                                    <li><code>Ver y anotar </code> calificaciones.</li>
                                                    <li><code>Ver </code> calificaciones modulares (en caso de
                                                        corresponder).
                                                    </li>
                                                </ul>
                                                El listado nos muestra
                                                <ul>
                                                    <li><b>Tipo</b> de calificación.</li>
                                                    <li><b>Nombre</b> de la calificación que la diferencia de las otras
                                                        calificaciones.
                                                    </li>
                                                    <li>Quién <b>creo</b> la calificación.</li>
                                                    <li><b>Fecha</b> en la que se creó la calificación.</li>
                                                    <li><b>Cargo</b> a la que pertenece la calificación (si
                                                        corresponde).
                                                    </li>
                                                    <li><b>Comisión</b> a la que pertenece la calificación (si
                                                        corresponde).
                                                    </li>
                                                    <li><b>Acciones</b> posibles:
                                                        <ul>
                                                            <li><code>Notas</code> desde donde se califica al alumno
                                                            </li>
                                                            <li><code>Edición <i class="fas fa-edit text-warning"></i>
                                                                </code> desde
                                                                donde se puede modificar
                                                                datos de la calificación en sí.
                                                            </li>
                                                            <li><code>Eliminar</code> desde donde elimina una
                                                                calificación.
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-xl-3">
                                                <img class="me-3 img-fluid"
                                                     src="{{asset('images/ayuda/cargos/admin-calificaciones.png')}}"
                                                     alt="home"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingVistaCalificaciones">
                                <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseVistaCalificaciones" aria-expanded="true"
                                        aria-controls="collapseVistaCalificaciones">
                                    Vista Calificaciones
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse show" id="collapseVistaCalificaciones"
                                 aria-labelledby="headingVistaCalificaciones"
                                 data-bs-parent="#accordionPlanilla">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="col-xl-9">
                                                En la <b>vista de calificaciones (notas de)</b> podemos <code>
                                                    Descargar </code> las notas en formato de planilla de cálculo y
                                                <code>ver la calificación modular</code> respectiva.
                                                En el listado veremos
                                                <ul>
                                                    <li>El <b> nombre</b> del alumno/a al que se le asigna la nota.</li>
                                                    <li>Las <b> calificaciones</b> en donde se colocarán las notas.</li>
                                                    <li>El <b> estado</b> del alumno/a en el cargo.</li>
                                                    <li>La <b> nota final</b> del cargo.</li>
                                                    <li><b> Cierre</b> de notas.</li>
                                                </ul>
                                            </div>
                                            <div class="col-xl-3">
                                                <img class="me-3 img-fluid"
                                                     src="{{asset('images/ayuda/cargos/vista-calificaciones.png')}}"
                                                     alt="vista-calificaciones"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="accordion-item" id="vista-modular">
                            <h3 class="accordion-header" id="headingVistaModular">
                                <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseVistaModular" aria-expanded="true"
                                        aria-controls="collapseVistaModular">
                                    Vista Calificaciones modulares
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse show" id="collapseVistaModular"
                                 aria-labelledby="headingVistaModular"
                                 data-bs-parent="#accordionConfig">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="col-xl-9">
                                                En la <b>vista de calificaciones modulares</b> podemos acceder a las
                                                <code> Calificaciones (notas) </code> de los cargos que componen el
                                                módulo, además de observar:
                                                <ul>
                                                    <li>Las <b>notas de proceso</b> discriminada por alumno/a
                                                        <ul>
                                                            <li> Discriminación <b>por cargo</b> con sus respectivas
                                                                calificaciones
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                                Esta vista procesa las ponderaciones entre cargos para dar la nota del
                                                módulo.
                                            </div>
                                            <div class="col-xl-3">
                                                <img class="me-3 img-fluid"
                                                     src="{{asset('images/ayuda/cargos/vista-modular.png')}}"
                                                     alt="home"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
