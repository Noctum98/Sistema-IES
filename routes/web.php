<?php

use App\Http\Controllers\AlumnoProcesoController;
use App\Http\Controllers\ComisionController;
use App\Http\Controllers\EstadosController;
use App\Http\Controllers\ModuloProfesorController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\ProcesoModularController;
use App\Http\Controllers\TipoCalificacionesController;
use App\Http\Controllers\UserCargoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ParcialController;
use App\Http\Controllers\AlumnoAsistenciaController;
use App\Http\Controllers\AlumnoCarreraController;
use App\Http\Controllers\PreinscripcionController;
use App\Http\Controllers\InstanciaController;
use App\Http\Controllers\AlumnoMesaController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\MatriculacionController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\ProcesoCalificacionController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserCarreraController;
use App\Http\Controllers\UserMateriaController;
use Illuminate\Support\Facades\Artisan;
use App\Models\Calificacion;
use App\Models\Comision;
use App\Models\Materia;
use App\Models\Proceso;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/ayuda/cargos', [App\Http\Controllers\HomeController::class, 'ayudaCargos'])->name('home.ayuda.cargos');

Route::get('/', function () {
    if (Auth::user()) {
        return view('home');
    } else {
        return view('auth.login');
    }
});


// Rutas de comisiones

Route::resource('comisiones', ComisionController::class);
Route::get('comision/edit/{comision_id}', [ComisionController::class, 'edit'])->name('comision.edit');
Route::get('verComisiones/{carrera_id}', [ComisionController::class, 'index'])->name('comisiones.ver');
Route::post('comision/alumno/agregar', [ComisionController::class, 'agregar_alumno'])->name('comision.alumno');
Route::post('comision/profesor/{comision_id}', [ComisionController::class, 'agregar_profesor'])->name(
    'comision.profesor'
);
Route::post('comision/update/{comision_id}', [ComisionController::class, 'update'])->name('comision.update');
Route::post('crearComisiones/{carrera_id}', [ComisionController::class, 'store'])->name('comisiones.crear');
Route::delete('comisiones/profesor/{comision_id}', [ComisionController::class, 'delete_profesor'])->name(
    'comision.delprofesor'
);

// Rutas de estados

Route::resource('estados', EstadosController::class);

/**
 * Rutas Materias
 */
Route::prefix('materia')->group(function () {
    Route::get('/listado', [MateriaController::class, 'vista_listado'])->name('materia.listado');
});

//Rutas de sedes
Route::prefix('sedes')->group(function () {
    // Vistas
    Route::get('/', [SedeController::class, 'vista_sedes'])->name('sedes.admin');
    Route::get('crear', [SedeController::class, 'vista_crear'])->name('sedes.crear');
    Route::get('editar/{id}', [SedeController::class, 'vista_editar'])->name('sedes.editar');

    //  Acciones
    Route::post('crear-sede', [SedeController::class, 'crear'])->name('crear_sede');
    Route::post('editar-sede/{id}', [SedeController::class, 'editar'])->name('editar_sede');
    Route::get('eliminar-sede/{id}', [SedeController::class, 'eliminar'])->name('eliminar_sede');
});

//Ruta de usuario administrador
Route::prefix('usuarios')->group(function () {
    Route::get('administrar', [UserController::class, 'vista_admin'])->name('usuarios.admin');
    Route::get('editar', [UserController::class, 'vista_editar'])->name('usuarios.editar');
    Route::get('detalle/{id}', [UserController::class, 'vista_detalle'])->name('usuarios.detalle');
    Route::get('mis_datos', [UserController::class, 'vista_mis_datos'])->name('usuarios.mis_datos');
    Route::get('listado/{listado}/{busqueda?}', [UserController::class, 'vista_listado'])->name('usuarios.listado');


    // Funcionalidades
    Route::post('editar_usaurio', [UserController::class, 'editar'])->name('editar_usuario');
    Route::delete('/{id}', [UserController::class, 'delete'])->name('usuario.eliminar');
    Route::post('cambiar_contra', [UserController::class, 'cambiar_contra'])->name('cambiar_contra');
    Route::post('set_rol/{id}', [UserController::class, 'set_roles'])->name('set_roles');
    Route::post('cambiar_sedes/{id}', [UserController::class, 'cambiar_sedes'])->name('sede_usuario');
    Route::post('set_Carrera/{id}', [UserCarreraController::class, 'store'])->name('set_carrera');
    Route::post('set_CarreraMaterias/{id}', [UserMateriaController::class, 'store'])->name('set_materias_carreras');
    Route::post('set_CarreraCargo/{id}', [UserCargoController::class, 'store'])->name('set_cargos_carreras');
    Route::get('crear_alumno_usuario/{id}', [UserController::class, 'crear_usuario_alumno'])->name(
        'crear_usuario_alumno'
    );
});

Route::prefix('usuario_materia')->group(function () {
    Route::delete('delete/{user_id}/{materia_id}', [UserMateriaController::class, 'delete'])->name(
        'delete_materias_carreras'
    );
});

Route::prefix('usuario_carrera')->group(function () {
    Route::delete('delete/{user_id}', [UserCarreraController::class, 'delete'])->name('delete_user_carrera');
});

Route::prefix('usuario_cargo')->group(function () {
    Route::delete('delete/{user_id}/{cargo_id}', [UserCargoController::class, 'delete'])->name('delete_cargo_carreras');
});

Route::prefix('usuario_carrera')->group(function () {
    Route::delete('delete/{user_id}', [UserCarreraController::class, 'delete'])->name('delete_user_carrera');
});

//Ruta de Roles
Route::resource('roles', RolController::class);

// Rutas de Personal
Route::prefix('personal')->group(function () {
    // Vistas
    Route::get('/', [PersonalController::class, 'vista_admin'])->name('personal.admin');
    Route::get('crear', [PersonalController::class, 'vista_crear'])->name('personal.crear');
    Route::get('ficha/{id}', [PersonalController::class, 'vista_detalle'])->name('personal.ficha');
    Route::get('editar/{id}', [PersonalController::class, 'vista_editar'])->name('personal.editar');

    // Acciones
    Route::post('crear-personal', [PersonalController::class, 'crear_personal'])->name('crear_personal');
    Route::post('edita-personal/{id}', [PersonalController::class, 'editar_personal'])->name('editar_personal');
    Route::get('descargar-ficha/{id}', [PersonalController::class, 'descargar_ficha'])->name('descargar_ficha');
});

// Rutas Cargo

Route::prefix('cargo')->group(function () {
    Route::get('/', [CargoController::class, 'index'])->name('cargo.admin');
    Route::get('crear', [CargoController::class, ''])->name('carrera.crear');
    Route::post('cargo', [CargoController::class, 'store'])->name('cargo.store');
    Route::get('cargo/{id}', [CargoController::class, 'show'])->name('cargo.show');
    Route::get('editar/{id}', [CargoController::class, 'vista_editar'])->name('cargo.edit');
    Route::post('editar-cargo/{cargo}', [CargoController::class, 'editar'])->name('editar_cargo');
    Route::delete('delete/{cargo}', [CargoController::class, 'destroy'])->name('cargo.delete');
});

// Rutas de Carreras
Route::prefix('carreras')->group(function () {
    // Vistas
    Route::get('/', [CarreraController::class, 'vista_admin'])->name('carrera.admin');
    Route::get('crear', [CarreraController::class, 'vista_crear'])->name('carrera.crear');
    Route::get('personal/{id}', [CarreraController::class, 'vista_agregarPersonal'])->name('carrera.personal');
    Route::get('editar/{id}', [CarreraController::class, 'vista_editar'])->name('carrera.editar');

    // Acciones
    Route::post('crear-carrera', [CarreraController::class, 'crear'])->name('crear_carrera');
    Route::post('agregar-personal/{id}', [CarreraController::class, 'agregar_personal'])
        ->name('agregar_personal');
    Route::post('editar-carrera/{id}', [CarreraController::class, 'editar'])->name('editar_carrera');
});

// Rutas de Materias
Route::prefix('carreras/materias')->group(function () {
    // Vistas
    Route::get('/{carrera_id}', [MateriaController::class, 'vista_admin'])->name('materia.admin');
    Route::get('crear/{carrera_id}', [MateriaController::class, 'vista_crear'])->name('materia.crear');
    Route::get('editar/{id}', [MateriaController::class, 'vista_editar'])->name('materia.editar');

    // Acciones
    Route::post('crear-materia/{carrera_id}', [MateriaController::class, 'crear'])->name('crear_materia');
    Route::post('editar-materia/{id}', [MateriaController::class, 'editar'])->name('editar_materia');
    Route::get('descargar_excel_alumnos/{id}', [MateriaController::class, 'descargar_planilla'])->name(
        'descargar_planilla'
    );
});

// Rutas de Módulos
Route::prefix('modulos')->group(function () {
    Route::get('/ver/{materia}', [ModulosController::class, 'ver_modulo'])->name('modulos.ver');
});

Route::get('/selectMateriasCarrera/{id}', [MateriaController::class, 'selectMaterias']);
Route::get('/selectCargosCarrera/{id}', [CargoController::class, 'selectCargos']);
Route::get('/buscaUsuarioByUsername/{busqueda}', [UserController::class, 'getUsuarioByUsernameOrNull']);

// Rutas de Alumnos
Route::prefix('alumnos')->group(function () {
    // Vistas
    Route::get('/{busqueda?}', [AlumnoController::class, 'vista_admin'])->name('alumno.admin');
    Route::get('agregar/{id}', [AlumnoController::class, 'vista_crear'])->name('alumno.crear');
    Route::get('carrera/elegir', [AlumnoController::class, 'vista_elegir'])->name('alumno.elegir');
    Route::get('editar/{id}', [AlumnoController::class, 'vista_editar'])->name('alumno.editar');
    Route::get('carrera/{carrera_id}', [AlumnoController::class, 'vista_alumnos'])->name('alumno.carrera');
    Route::get('alumno/{id}', [AlumnoController::class, 'vista_detalle'])->name('alumno.detalle');

    // Acciones
    Route::post('crear-alumno/{carrera_id}', [AlumnoController::class, 'crear'])->name('crear_alumno');
    Route::post('editar-alumno/{id}', [AlumnoController::class, 'editar'])->name('editar_alumno');
    Route::post('buscarAlumno/{id}',[AlumnoController::class,'buscar']);
    Route::get('alumnosMateria/{id}',[AlumnoController::class,'alumnosMateria']);

    Route::get('ver-imagen/{foto}', [AlumnoController::class, 'ver_foto'])->name('ver_imagen');
    Route::get('descargar/{nombre}/{disco}', [AlumnoController::class, 'descargar_archivo'])->name('descargar_archivo');
    Route::get('descargar-ficha/{id}', [AlumnoController::class, 'descargar_ficha'])->name('descargar_ficha');
});

Route::prefix('alumno/carrera')->group(function () {
    Route::post('/changeYear/{alumno_id}/{carrera_id}', [AlumnoCarreraController::class, 'changeAño'])->name(
        'alumnoCarrera.year'
    );
});

// Rutas de preinscripciones
Route::prefix('preinscripcion')->group(function () {
    Route::get('/carreras/{busqueda?}', [PreinscripcionController::class, 'vista_admin'])->name('pre.admin');
    Route::get('/{id}', [PreinscripcionController::class, 'vista_preinscripcion'])->name('alumno.pre');
    Route::get('terminada/{timecheck}/{id}', [PreinscripcionController::class, 'vista_inscripto'])->name(
        'pre.inscripto'
    );
    Route::get('editada/{timecheck}/{id}', [PreinscripcionController::class, 'vista_editado'])->name('pre.editado');
    Route::get('eliminada', [PreinscripcionController::class, 'vista_eliminado'])->name('pre.eliminado');
    Route::get('/carrera/{id}', [PreinscripcionController::class, 'vista_all'])->name('pre.all');
    Route::get('/datos/{id}', [PreinscripcionController::class, 'vista_detalle'])->name('pre.detalle');
    Route::get('/verificadas/{id}', [PreinscripcionController::class, 'vista_verificadas'])->name('pre.verificadas');
    Route::get('/erroneas/{id}', [PreinscripcionController::class, 'vista_sincorregir'])->name('pre.sincorregir');
    Route::get('/editar/{timecheck}/{id}', [PreinscripcionController::class, 'vista_editar'])->name('pre.editar');
    Route::get('/articulo/septimo', [PreinscripcionController::class, 'vista_articulo'])->name('pre.articulo');


    // Acciones
    Route::post('inscribir/{carrera_id}', [PreinscripcionController::class, 'crear'])->name('crear_preins');
    Route::post('editar/{id}', [PreinscripcionController::class, 'editar'])->name('editar_preins');
    Route::get('eliminar/{timecheck}/{id}', [PreinscripcionController::class, 'borrar'])->name('pre.eliminar');
    Route::get('descargar-excel/{carrera_id}', [PreinscripcionController::class, 'descargar_excel'])->name('pre.excel');
    Route::get('/excel/verificados', [PreinscripcionController::class, 'descargar_verificados'])->name('pre.excelv');
    Route::get('estado/{id}', [PreinscripcionController::class, 'cambiar_estado'])->name('pre_estado');
    Route::post('/error/{id}', [PreinscripcionController::class, 'email_archivo_error'])->name('pre.error');
});

// Rutas de Proceso
Route::prefix('proceso')->group(function () {
    // Vistas
    Route::get('inscribir/{id}', [ProcesoController::class, 'vista_inscribir'])->name('proceso.inscribir');
    Route::get('detalle/{id}', [ProcesoController::class, 'vista_detalle'])->name('proceso.detalle');
    // Vista Alumno
    Route::get('/mis_procesos/{id}', [AlumnoProcesoController::class, 'vista_procesos'])->name('proceso.alumno');

    // Acciones
    Route::get('inscribir_proceso/{alumno_id}/{materia_id}', [ProcesoController::class, 'inscribir'])->name(
        'inscribir_proceso'
    );
    Route::post('administrar/{alumno_id}', [ProcesoController::class, 'administrar'])->name('proceso.administrar');
    Route::get('listado/{materia_id}/{comision_id?}', [ProcesoController::class, 'vista_listado'])->name('proceso.listado');

    Route::get('listado-cargo/{materia_id}/{cargo_id}/{comision_id?}', [ProcesoController::class, 'vista_listadoCargo'])->name(
        'proceso.listadoCargo'
    );

    Route::get('listado-modular/{materia_id}/{comision_id?}', [ProcesoController::class, 'vista_listadoModular'])->name(
        'proceso.listadoModular'
    );

    Route::get('listado-cargos-modulo/{materia_id}/{cargo_id}/{alumno_id}/{comision_id?}', [ProcesoController::class, 'vista_listadoCargosModulo'])->name(
        'proceso.listadoCargosModulo'
    );
    Route::post('cambia/estado', [ProcesoController::class, 'cambiaEstado'])->name('proceso.cambiaEstado');
    Route::post('cambia/cierre', [ProcesoController::class, 'cambiaCierre'])->name('proceso.cambiaCierre');
    Route::post('cambia/nota_final', [ProcesoController::class, 'cambia_nota_final'])->name('proceso.nota_final');
    Route::post('cambia/nota_global', [ProcesoController::class, 'cambia_nota_global'])->name('proceso.nota_global');
    Route::post('calcularPorcentaje',[ProcesoCalificacionController::class,'calcularPorcentaje']);
    Route::get('procesosCalificaciones/{proceso_id}',[ProcesoCalificacionController::class,'show']);

});

// Rutas de Asistencia
Route::prefix('asistencias')->group(function () {
    // Vistas
    Route::get('carreras', [AsistenciaController::class, 'vista_carreras'])->name('asis.inicio');
    Route::get('materia/{id}/{cargo_id?}', [AsistenciaController::class, 'vista_admin'])->name('asis.admin');
    Route::get('tomar/{id}', [AsistenciaController::class, 'vista_crear'])->name('asis.crear');
    Route::get('fecha/{id}', [AsistenciaController::class, 'vista_fecha'])->name('asis.fecha');
    Route::get('cerrada/{id}', [AsistenciaController::class, 'vista_cerrar'])->name('asis.cerrar');


    // Acciones
    Route::post('/crear_asistencia', [AsistenciaController::class, 'crear'])->name('crear_asis');
    Route::post('/crearAsistenciaSetentaTreinta', [AsistenciaController::class, 'crear_7030']);
    Route::post('/crearAsistenciaModular', [AsistenciaController::class, 'crear_modular']);
    Route::post('/crearAsistenciaModularSetentaTreinta', [AsistenciaController::class, 'crear_modular_7030']);

    Route::get('cerrar/{id}', [AsistenciaController::class, 'cerrar_planilla'])->name('cerrar_asis');
});

// Rutas de Alumno_Asistencia
Route::prefix('alumno/asis')->group(function () {
    Route::get('{alumno_id}/{asistencia_id}/{estado}', [AlumnoAsistenciaController::class, 'crear']);
});

// Rutas de Parciales
Route::prefix('parciales')->group(function () {
    // Vistas
    Route::get('carreras', [ParcialController::class, 'vista_carreras'])->name('parci.inicio');
    Route::get('materia/{id}', [ParcialController::class, 'vista_admin'])->name('parci.admin');
    Route::get('crear/{id}', [ParcialController::class, 'vista_crear'])->name('parci.crear');
    Route::get('notas/{id}', [ParcialController::class, 'vista_notas'])->name('parci.notas');
    Route::get('editar/{id}', [ParcialController::class, 'vista_editar'])->name('parci.editar');
    Route::get('recuperatorio/{id}', [ParcialController::class, 'vista_recuperatorio'])->name('parci.recu');

    // Acciones
    Route::post('crear_parcial/{id}', [ParcialController::class, 'crear'])->name('crear_parci');
});

// Ruta AlumnoParcial
Route::prefix('alumno/parci')->group(function () {
});

//Rutas de Mesas
Route::prefix('mesas')->group(function () {
    Route::get('/inscripcion/{id}', [AlumnoMesaController::class, 'vista_home'])->name('mesa.welcome');
    Route::get('/instancias', [AlumnoMesaController::class, 'vista_instancias'])->name('mesa.instancias');
    Route::get('/administrar', [InstanciaController::class, 'vista_admin'])->name('mesa.admin');
    Route::get('/carreras/{sede_id}/{instancia_id}', [InstanciaController::class, 'vista_carreras'])->name(
        'mesa.carreras'
    );
    Route::get('/materias/{instancia_id?}', [AlumnoMesaController::class, 'vista_materias'])->name('mesa.mate');
    Route::get('/inscriptos/{instancia_id}/{materia_id}', [MesaController::class, 'vista_inscripciones'])->name(
        'mesa.inscriptos'
    );
    Route::get('/especial/inscriptos/{id}/{instancia_id?}', [AlumnoMesaController::class, 'vista_inscriptos'])->name(
        'mesa.especial.inscriptos'
    );

    Route::post('/seleccionar/{id}', [InstanciaController::class, 'seleccionar_sede'])->name('sele.sede');
    Route::post('/crear/{materia_id}/{instancia_id}', [MesaController::class, 'crear'])->name('crear_mesa');
    Route::post('/editar/{materia_id}/{instancia_id}', [MesaController::class, 'editar'])->name('editar_mesa');
    Route::get('/borrar/{id}/{solo?}', [InstanciaController::class, 'borrar'])->name('borrar_datos');
    Route::post('/crear_instancia', [InstanciaController::class, 'crear'])->name('crear_instancia');
    Route::post('/editar_instancia/{id}', [InstanciaController::class, 'editar'])->name('editar_instancia');
    Route::get('/estado/{estado}/{id}', [InstanciaController::class, 'cambiar_estado']);
    Route::post('/alumno/crear', [AlumnoMesaController::class, 'materias'])->name('mesas.materias');
    Route::post('/mesa_inscripcion/{instancia_id?}', [AlumnoMesaController::class, 'inscripcion'])->name('insc_mesa');
    Route::get('/bajar_mesa/{id}/{instancia_id?}', [AlumnoMesaController::class, 'bajar_mesa'])->name('mesa.baja');
    Route::post('/borrar_mesa/{id}/{instancia_id?}', [AlumnoMesaController::class, 'borrar_inscripcion'])->name(
        'mesa.borrar'
    );
    Route::get('/editar_mesa/{dni}/{id}/{sede_id}', [AlumnoMesaController::class, 'email_session'])->name('edit.mesa');
    Route::get('/descargar_excel/{id}/{instancia_id}/{llamado?}', [InstanciaController::class, 'descargar_excel']
    )->name('mesa.descargar');
    Route::get('/descargar_tribunal/{id}/{instancia_id}', [InstanciaController::class, 'descargar_tribunal'])->name(
        'mesa.tribunal'
    );
    Route::get('/descargar_total/{id}', [InstanciaController::class, 'descargar_total'])->name('mesa.total.descargar');
    Route::post('/inscribir_alumno',[AlumnoMesaController::class,'inscribir_alumno'])->name('mesa.inscribir_alumno');
});

Route::prefix('matriculacion')->group(function () {
    Route::get('/carrera/{id}/{year}/{timecheck?}', [MatriculacionController::class, 'create'])->name(
        'matriculacion.create'
    );
    Route::get('/editar/{alumno_id}/{carrera_id}/{year?}', [MatriculacionController::class, 'edit'])->name(
        'matriculacion.edit'
    );
    Route::delete('/delete/{id}/{carrera_id}/{year?}', [MatriculacionController::class, 'delete'])->name(
        'matriculacion.delete'
    );
    Route::get('/email_check/{timecheck}/{carrera_id}/{year}', [MatriculacionController::class, 'email_check'])->name(
        'matriculacion.checked'
    );
    Route::get('finalizada', function () {
        return view('matriculacion.card_email_check');
    });
    Route::post('/carrera/{id}/{year}', [MatriculacionController::class, 'store'])->name('matriculacion.store');
    Route::put('/carrera/{id}/{carrera_id?}/{year?}', [MatriculacionController::class, 'update'])->name(
        'matriculacion.update'
    );
    Route::post('/verificar/{carrera_id}/{year}', [MatriculacionController::class, 'send_email'])->name(
        'matriculacion.verificar'
    );
});

//Route::resource('cargo',CargoController::class);
Route::post('agregarModulo', [CargoController::class, 'agregarModulo'])->name('cargo.agregarModulo');
Route::post('agregarUser', [CargoController::class, 'agregarUser'])->name('cargo.agregarUser');
Route::post('ponderarCargo', [CargoController::class, 'ponderarCargo'])->name('cargo.ponderar');
Route::get('getTotalModulo/{materia}', [CargoController::class, 'getTotalModulo'])->name('cargo.getTotalModulo');
Route::get('getPonderarCargo/{cargo_id}/{materia_id}', [CargoController::class, 'getPonderarCargo'])->name(
    'cargo.get_ponderar'
);
Route::delete('deleteUser/{cargo_id}', [CargoController::class, 'deleteUser'])->name('cargo.delUser');
Route::delete('deleteMateria/{cargo_id}', [CargoController::class, 'deleteModulo'])->name('cargo.delMateria');
Route::post('agregarModulo', [CargoController::class, 'agregarModulo'])->name('cargo.agregarModulo');
Route::post('agregarUser', [CargoController::class, 'agregarUser'])->name('cargo.agregarUser');
Route::delete('deleteUser/{cargo_id}', [CargoController::class, 'deleteUser'])->name('cargo.delUser');
Route::delete('deleteMateria/{cargo_id}', [CargoController::class, 'deleteModulo'])->name('cargo.delMateria');


/**
 * Ruta para TipoCalificaciones
 */
Route::resource('tipoCalificaciones', TipoCalificacionesController::class);

Route::prefix('calificacion')->group(function () {
    Route::get('home', [CalificacionController::class, 'home'])->name('calificacion.home');
    Route::get('admin/{materia_id}/{cargo_id?}', [CalificacionController::class, 'admin'])->name('calificacion.admin');
    Route::get('create/{id}', [CalificacionController::class, 'create'])->name('calificacion.create');

    Route::post('/', [CalificacionController::class, 'store'])->name('calificacion.store');
    Route::post('update/{calificacion}', [CalificacionController::class, 'update'])->name('calificacion.update');
    Route::get('edit/{calificacion}', [CalificacionController::class, 'edit'])->name('calificacion.edit');
    Route::delete('/{id}', [CalificacionController::class, 'delete'])->name('calificacion.delete');
});
Route::prefix('moduloProfesor')->group(function () {
    Route::post('/agregarCargoModulo', [ModuloProfesorController::class, 'agregarCargoModulo'])->name('modulo_profesor.vincular_cargo_modulo');
    Route::get('formAgregarCargoModulo/{cargo}/{usuario}', [ModuloProfesorController::class, 'formAgregarCargoModulo'])->name('modulo_profesor.form_agregar_cargo_modulo');
});

Route::prefix('procesoCalificacion')->group(function () {
    Route::post('/', [ProcesoCalificacionController::class, 'store']);
    Route::post('/recuperatorio', [ProcesoCalificacionController::class, 'crearRecuperatorio']);
    Route::post('/delete',[ProcesoCalificacionController::class,'delete']);
});

// Rutas de Parciales
Route::prefix('proceso-modular')->group(function () {
   Route::get('/listado/{materia}/{cargo_id}', [ProcesoModularController::class, 'list'])->name('proceso_modular.list');
   Route::get('/procesaPonderacionModular/{materia}', [ProcesoModularController::class, 'procesaPonderacionModular'])->name('proceso_modular.procesa_ponderacion_modular');
});

Route::prefix('excel')->group(function () {
    Route::get('alumnos/{carrera_id}/{year}', [ExcelController::class, 'alumnos_year'])->name('excel.alumnosAño');
    Route::get('alumnos/all', [ExcelController::class, 'all_alumnos']);
    Route::get('alumnos/sedes/sede/{sede_id}', [ExcelController::class, 'all_alumnos']);
    Route::get('procesos/{materia_id}/{comision_id?}', [ExcelController::class, 'planilla_notas_tradicional'])->name(
        'excel.procesos'
    );
});

Route::get('/clear-cache', function () {
    echo Artisan::call('config:clear');
    echo Artisan::call('config:cache');
    echo Artisan::call('view:clear');
    echo Artisan::call('cache:clear');
    echo Artisan::call('route:clear');
});


Route::get('/prueba/{id}/{comision_id?}', function ($materia_id, $comision_id = null) {

    $procesos = Proceso::select('procesos.*')
        ->join('alumnos', 'alumnos.id', 'procesos.alumno_id')
        ->where('procesos.materia_id', $materia_id);

    if ($comision_id) {
        $procesos = $procesos->whereHas('alumno', function ($query) use ($comision_id) {
            $query->whereHas('comisiones', function ($query) use ($comision_id) {
                $query->where('comisiones.id', $comision_id);
            });
        });
    }
    $materia = Materia::find($materia_id);
    $comision = null;

    if ($comision_id) {
        $comision = Comision::find($comision_id);
    }

    $procesos->orderBy('alumnos.apellidos', 'asc');
    $procesos = $procesos->get();
    $calificacion = Calificacion::where([
        'materia_id' => $materia_id,
    ]);

    if ($comision_id) {
        $calificacion->where([
            'comision_id' => $comision_id,
        ]);
    }

    $calificaciones = $calificacion->orderBy('tipo_id', 'DESC')->get();

    return view('excel.planilla_notas_tradicional', [
        'procesos' => $procesos,
        'calificaciones' => $calificaciones,
    ]);
});
