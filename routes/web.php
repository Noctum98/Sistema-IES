<?php

use App\Http\Controllers\ActaVolanteController;
use App\Http\Controllers\Alumno\EncuestaSocioeconomicaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumnoProcesoController;
use App\Http\Controllers\CargoProcesoController;
use App\Http\Controllers\ComisionController;
use App\Http\Controllers\EquivalenciasController;
use App\Http\Controllers\EstadosController;
use App\Http\Controllers\ModuloProfesorController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\Parameters\CicloLectivoController;
use App\Http\Controllers\Parameters\CicloLectivoEspecialController;
use App\Http\Controllers\ProcesoModularController;
use App\Http\Controllers\RegularidadController;
use App\Http\Controllers\TipoCalificacionesController;
use App\Http\Controllers\Trianual\AcreditacionController;
use App\Http\Controllers\Trianual\DetalleTrianualController;
use App\Http\Controllers\Trianual\ObservacionesTrianualController;
use App\Http\Controllers\Trianual\TrianualController;
use App\Http\Controllers\UserCargoController;
use App\Models\Trianual\ObservacionesTrianual;
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
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\Config\AuditController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\LibrosController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MatriculacionController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\Parameters\CalendarioController;
use App\Http\Controllers\Proceso\EtapaCampoController;
use App\Http\Controllers\ProcesoCalificacionController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserCarreraController;
use App\Http\Controllers\UserMateriaController;
use App\Models\ActaVolante;
use App\Models\Alumno\EncuestaSocioeconomica;
use Illuminate\Support\Facades\Artisan;
use App\Models\Carrera;
use App\Models\Sede;
use App\Http\Controllers\CondicionCarrerasController;
use App\Http\Controllers\CondicionMateriasController;
use App\Http\Controllers\CondicionMateriaApiDocsApiDocsController;
use App\Http\Controllers\MateriasCorrelativasCursadosController;

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
Route::get('/register-alumno/{carrera_id}',[RegisterController::class,'showRegistrationAlumnosForm'])->name('register.alumnos');
Route::post('register-alumno',[RegisterController::class,'registerAlumno'])->name('register.alumno.store');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/ayuda/cargos', [App\Http\Controllers\HomeController::class, 'ayudaCargos'])->name(
    'home.ayuda.cargos'
);
Route::get('/home/ayuda/visual', [App\Http\Controllers\HomeController::class, 'ayudaVisual'])->name(
    'home.ayuda.visual'
);

Route::get('/', function () {
    if (Auth::user()) {
        return view('home');
    } else {
        return view('auth.login');
    }
});

// Rutas acreditaciones
Route::prefix('acreditacion')->group(function () {
    Route::post('/', [AcreditacionController::class, 'store']);
});

// Rutas Actas volantes
Route::resource('actas_volantes', ActaVolanteController::class);

// Rutas Admin
Route::prefix('admin')->group(function () {
    Route::get('/calificaciones/{orden?}', [AdminController::class, 'vista_calificaciones'])->name('admin.calificaciones');
    Route::get('/calificaciones/{carrera_id}/carrera', [AdminController::class, 'vista_calificaciones_materias'])->name('admin.calificaciones.materias');
    Route::get('/calificaciones/{materia_id}/cargo', [AdminController::class, 'vista_calificaciones_cargos'])->name('admin.calificaciones.cargos');
});

// Rutas de Alumnos
Route::prefix('alumnos')->group(function () {
    // Vistas
    Route::get('/{busqueda?}', [AlumnoController::class, 'vista_admin'])->name('alumno.admin');
    Route::post('/{ciclo_lectivo?}', [AlumnoController::class, 'vista_admin'])->name('alumno.adminp');
    Route::get('agregar/{id}', [AlumnoController::class, 'vista_crear'])->name('alumno.crear');
    Route::get('carrera/elegir', [AlumnoController::class, 'vista_elegir'])->name('alumno.elegir');
    Route::get('editar/{id}', [AlumnoController::class, 'vista_editar'])->name('alumno.editar');
    Route::get('equivalencias/alumno/{busqueda?}', [AlumnoController::class, 'vista_equivalencias'])->name('alumno.equivalencias');
    Route::get('carrera/{carrera_id}/{ciclo_lectivo?}', [AlumnoController::class, 'vista_alumnos'])->name(
        'alumno.carrera'
    );
    Route::get('alumno/{id}/{ciclo_lectivo?}', [AlumnoController::class, 'vista_detalle'])->name('alumno.detalle');

    // Acciones
    Route::post('crear-alumno/{carrera_id}', [AlumnoController::class, 'crear'])->name('crear_alumno');
    Route::post('editar-alumno/{id}', [AlumnoController::class, 'editar'])->name('editar_alumno');
    Route::post('buscarAlumno/{id}', [AlumnoController::class, 'buscar']);
    Route::get('alumnosMateria/{id}', [AlumnoController::class, 'alumnosMateria']);

    Route::get('ver-imagen/{foto}', [AlumnoController::class, 'ver_foto'])->name('ver_imagen');
    Route::get('descargar/{nombre}/{dni?}/{id}', [AlumnoController::class, 'descargar_archivo'])->name('descargar_archivo');
    Route::get('descargar-ficha/{id}', [AlumnoController::class, 'descargar_ficha'])->name('descargar_ficha');
});

Route::prefix('encuesta_socioeconomica')->group(function () {
    Route::get('personal/{alumno_id}/{carrera_id}', [EncuestaSocioeconomicaController::class, 'showForm'])->name('encuesta_socioeconomica.showForm');
    Route::get('motivacional/{encuesta_id}/{carrera_id}',[EncuestaSocioeconomicaController::class,'showForm2'])->name('encuesta_socioeconomica.showForm2');
    Route::post('/store',[EncuestaSocioeconomicaController::class,'store'])->name('encuesta_socioeconomica.store');
    Route::post('/store2',[EncuestaSocioeconomicaController::class,'store2'])->name('encuesta_socioeconomica.store2');

});

Route::prefix('alumno/carrera')->group(function () {
    Route::post('/changeYear/{alumno_id}/{carrera_id}', [AlumnoCarreraController::class, 'changeAño'])->name(
        'alumnoCarrera.year'
    );
});

// Rutas Cargo
Route::prefix('cargo')->group(function () {
    Route::get('/', [CargoController::class, 'index'])->name('cargo.admin');
    Route::post('cargo', [CargoController::class, 'store'])->name('cargo.store');
    Route::get('cargo/{id}', [CargoController::class, 'show'])->name('cargo.show');
    Route::get('editar/{id}', [CargoController::class, 'vista_editar'])->name('cargo.edit');
    Route::post('editar-cargo/{cargo}', [CargoController::class, 'editar'])->name('editar_cargo');
    Route::delete('delete/{cargo}', [CargoController::class, 'destroy'])->name('cargo.delete');
    Route::post('agregar_tipo/{cargo}', [CargoController::class, 'agregarTipoCargo'])->name('cargo.agrega_tipo_Cargo');
});

Route::prefix('cargo_proceso')->group(function () {
    Route::get('/{proceso_id}/{cargo_id}', [CargoProcesoController::class, 'store'])->name('cargo_proceso.store');
    Route::get('/{cargo_proceso}/actualizar/planilla-modular',
        [CargoProcesoController::class, 'update'])
        ->name('cargo_proceso.actualizar');
    Route::get('/{cargo_id}/{materia_id}/{ciclo_lectivo}/cargar/procesos/{comision_id?}',
        [CargoProcesoController::class, 'all_store'])
        ->name('cargo_proceso.all_store');
});

// Rutas de Carreras
Route::prefix('carreras')->group(function () {
    // Vistas
    Route::get('/', [CarreraController::class, 'vista_admin'])->name('carrera.admin');
    Route::get('crear', [CarreraController::class, 'vista_crear'])->name('carrera.crear');
    Route::get('personal/{id}', [CarreraController::class, 'vista_agregarPersonal'])->name('carrera.personal');
    Route::get('editar/{id}', [CarreraController::class, 'vista_editar'])->name('carrera.editar');
    Route::post('/sedes', [CarreraController::class, 'carrerasPorSedes']);

    // Acciones
    Route::post('crear-carrera', [CarreraController::class, 'crear'])->name('crear_carrera');
    Route::post('agregar-personal/{id}', [CarreraController::class, 'agregar_personal'])
        ->name('agregar_personal');
    Route::post('editar-carrera/{id}', [CarreraController::class, 'editar'])->name('editar_carrera');
    Route::get('vista-carreras/{instancia}', [CarreraController::class, 'vistaCarrera'])->name('carrera.vista_carrera');
    Route::get('verProfesores/{carrera_id}', [CarreraController::class, 'verProfesores'])->name(
        'carrera.ver_profesores'
    );
});

Route::resource('calendario',CalendarioController::class);

//Ruta de Ciclo lectivo
Route::prefix('ciclo-lectivo')->middleware('auth')->group(function () {

    // Común
    Route::get('/', [CicloLectivoController::class, 'index'])->name('ciclo_lectivo.index');
    Route::post('/', [CicloLectivoController::class, 'store'])->name('ciclo_lectivo.store');
    Route::get('{ciclo_lectivo}', [CicloLectivoController::class, 'show'])->name('ciclo_lectivo.show');
    Route::get('create', [CicloLectivoController::class, 'create'])->name('ciclo_lectivo.create');
    Route::delete('{ciclo_lectivo}', [CicloLectivoController::class, 'destroy'])->name('ciclo_lectivo.destroy');
    Route::put('{ciclo_lectivo}', [CicloLectivoController::class, 'update'])->name('ciclo_lectivo.update');
    Route::get('{ciclo_lectivo}/edit', [CicloLectivoController::class, 'edit'])->name('ciclo_lectivo.edit');
    Route::get('{ciclo_lectivo}/especial', [CicloLectivoController::class, 'especial'])->name('ciclo_lectivo.especial');

    // Especial
    Route::post('/especial', [CicloLectivoEspecialController::class, 'store'])->name('ciclo_lectivo_especial.store');
    Route::get('/especial/listado', [CicloLectivoEspecialController::class, 'index'])->name('ciclo_lectivo_especial.index');
    Route::post('/especial/{materia}/guarda', [CicloLectivoEspecialController::class, 'store_materia'])->name('ciclo_lectivo_especial.store_materia');
    Route::get('/especial/{ciclo_lectivo_especial}/ver', [CicloLectivoEspecialController::class, 'show'])->name('ciclo_lectivo_especial.show');
    Route::get('/especial/{materia}/crear', [CicloLectivoEspecialController::class, 'create'])->name('ciclo_lectivo_especial.create');
    Route::delete('/especial/{ciclo_lectivo_especial}/borrar', [CicloLectivoEspecialController::class, 'destroy'])->name('ciclo_lectivo_especial.destroy');
    Route::put('/especial/{ciclo_lectivo_especial}/actualizar', [CicloLectivoEspecialController::class, 'update'])->name('ciclo_lectivo_especial.update');
    Route::get('/especial/{ciclo_lectivo_especial}/edit', [CicloLectivoEspecialController::class, 'edit'])->name('ciclo_lectivo_especial.edit');
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

//Rutas detalleTrianual
Route::prefix('detalleTrianual')->group(function () {
    Route::get('/', [DetalleTrianualController::class, 'index'])->name('detalleTrianual.listar');
    Route::post('/', [DetalleTrianualController::class, 'store'])->name('detalleTrianual.guardar');
    Route::get('/crear/{trianual}', [DetalleTrianualController::class, 'create'])->name('detalleTrianual.crear');
    Route::get('/ver/{detalleTrianual}', [DetalleTrianualController::class, 'show'])->name('detalleTrianual.ver');
});

// Rutas de estados

Route::resource('estados', EstadosController::class);


/**
 * Rutas Equivalencias
 */

Route::prefix('equivalencias')->group(function () {

    Route::get('create/{id}', [EquivalenciasController::class, 'create'])->name('equivalencias.create');
    Route::post('/', [EquivalenciasController::class, 'store'])->name('equivalencias_store');
    Route::post('/update/{equivalencia}', [EquivalenciasController::class, 'update'])->name('equivalencias.update');
    Route::get('borrar/{equivalencia}', [EquivalenciasController::class, 'destroy'])->name('equivalencias.borrar');
});

/**
 * Rutas Materias
 */
Route::prefix('materia')->group(function () {
    Route::get('/listado', [MateriaController::class, 'vista_listado'])->name('materia.listado');
    Route::get('/cierre/{materia_id}/{ciclo_lectivo}/{comision_id?}', [MateriaController::class, 'cierre_tradicional'])->name(
        'materia.cierre'
    );
    Route::get('/vista-materia/{instancia}', [MateriaController::class, 'vistaMateria'])->name('materia.vista_materia');
});

// Rutas de Módulos
Route::prefix('modulos')->group(function () {
    Route::get('/ver/{materia}', [ModulosController::class, 'ver_modulo'])->name('modulos.ver');
    Route::post('/agregarCargo', [ModulosController::class, 'agregarCargo'])->name('modulos.agregarCargo');
});


/**
 * Rutas ModuloProfesor
 */
Route::prefix('moduloProfesor')->group(function () {
    Route::post('/agregarCargoModulo', [ModuloProfesorController::class, 'agregarCargoModulo'])->name(
        'modulo_profesor.vincular_cargo_modulo'
    );
    Route::get('formAgregarCargoModulo/{cargo}/{usuario}', [ModuloProfesorController::class, 'formAgregarCargoModulo']
    )->name('modulo_profesor.form_agregar_cargo_modulo');
    Route::delete('delete/{materia}/{cargo}/{user}', [ModuloProfesorController::class, 'destroy'])->name(
        'modulo_profesor.destroy'
    );
});

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
});

/**
 * Rutas ProcesoModular
 */

Route::prefix('proceso-modular')->group(function () {
    Route::get('/listado/{materia}/{ciclo_lectivo?}/{cargo_id?}',
        [ProcesoModularController::class, 'listado'])->name(
        'proceso_modular.list'
    );
    Route::get('/tabs_cargo/{cargo_id}/{materia_id}/{ciclo_lectivo}',
        [ProcesoModularController::class, 'cargaTabsCargo']
    )->name('proceso_modular.carga_tabs_cargo');

    Route::get('/procesaPonderacionModular/{materia}',
        [ProcesoModularController::class, 'procesaPonderacionModular']
    )->name('proceso_modular.procesa_ponderacion_modular');
    Route::get('/procesaEstados/{materia}/{ciclo_lectivo}/{cargo_id?}',
        [ProcesoModularController::class, 'procesaEstadosModular']
    )->name('proceso_modular.procesa_estados_modular');
    Route::get('/procesaNotaModular/{materia}/{proceso_id}/{cargo_id?}',
        [ProcesoModularController::class, 'procesaNotaModular']
    )->name('proceso_modular.procesa_notas_modular');
    Route::get('/procesaNotaModularProcesp/{materia}/{proceso_id}/proceso/{cargo_id?}',
        [ProcesoModularController::class, 'procesaNotaModularProceso']
    )->name('proceso_modular.procesa_notas_modular_proceso');
});

/**
 * Rutas Regularidad
 */

Route::prefix('regularidad')->group(function () {
    Route::get('/', [RegularidadController::class, 'index'])->name('regularidad.index');
    Route::get('/anteriores', [RegularidadController::class, 'anteriores'])->name('regularidad.anteriores');
    Route::post('/', [RegularidadController::class, 'store'])->name('regularidad.store');
    Route::get('create/{id}/{ciclo_lectivo}', [RegularidadController::class, 'create'])->name('regularidad.create');
    Route::get('edit/{regularidad}', [RegularidadController::class, 'edit'])->name('regularidad.edit');
    Route::post('update/{regularidad}', [RegularidadController::class, 'update'])->name('regularidad.update');
    Route::get('borrar/{regularidad}', [RegularidadController::class, 'destroy'])->name('regularidad.borrar');
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
    Route::get('/selectCarreraSede/{id}', [SedeController::class, 'selectCarreraSede'])->name('select_carrera_sede');
});

Route::prefix('usuario_cargo')->group(function () {
    Route::delete('delete/{user_id}/{cargo_id}', [UserCargoController::class, 'delete'])->name('delete_cargo_carreras');
});

/**
 * Usuario carrera
 */
Route::prefix('usuario_carrera')->group(function () {
    Route::delete('delete/{user_id}', [UserCarreraController::class, 'delete'])->name('delete_user_carrera');
});
Route::prefix('usuario_carrera')->group(function () {
    Route::delete('delete/{user_id}', [UserCarreraController::class, 'delete'])->name('delete_user_carrera');
});

Route::prefix('usuario_materia')->group(function () {
    Route::delete('delete/{user_id}/{materia_id}', [UserMateriaController::class, 'delete'])->name(
        'delete_materias_carreras'
    );
});


//Ruta de Roles
Route::resource('roles', RolController::class);

// Rutas de carreras/materia
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

Route::get('/selectMateriasCarrera/{id}', [MateriaController::class, 'selectMaterias']);
Route::get('/selectMateriasCarreraInscripto/{idCarrera}/{idAlumno}/{ciclo_lectivo}', [MateriaController::class, 'selectMateriasInscripto']);
Route::get('/selectCargosCarrera/{id}', [CargoController::class, 'selectCargos']);
Route::get('/buscaUsuarioByUsername/{busqueda}', [UserController::class, 'getUsuarioByUsernameOrNull']);


// Rutas de preinscripciones
Route::prefix('preinscripcion')->group(function () {
    Route::get('/carreras/{busqueda?}', [PreinscripcionController::class, 'vista_admin'])->name('pre.admin');
    Route::get('/admin/carrera/{id}', [PreinscripcionController::class, 'vista_all'])->name('pre.all');
    Route::get('/{id}/{timecheck?}', [PreinscripcionController::class, 'vista_preinscripcion'])->name('alumno.pre');
    Route::get('/form/terminado/{carrera_id}', [PreinscripcionController::class, 'vista_inscripto'])->name(
        'pre.inscripto'
    );

    Route::get('/form/editada/{timecheck}/{id}', [PreinscripcionController::class, 'vista_editado'])->name('pre.editado');
    Route::get('eliminada', [PreinscripcionController::class, 'vista_eliminado'])->name('pre.eliminado');
    Route::get('/admin/datos/{id}', [PreinscripcionController::class, 'vista_detalle'])->name('pre.detalle');
    Route::get('/admin/verificadas/{id}', [PreinscripcionController::class, 'vista_verificadas'])->name(
        'pre.verificadas'
    );

    Route::get('/admin/preinscripcion/eliminadas', [PreinscripcionController::class, 'vista_eliminadas'])->name(
        'pre.eliminadas'
    );
    Route::get('/admin/erroneas/{id}', [PreinscripcionController::class, 'vista_sincorregir'])->name('pre.sincorregir');
    Route::get('/editar/{timecheck}/{id}', [PreinscripcionController::class, 'vista_editar'])->name('pre.editar');
    Route::get('/admin/articulo/septimo', [PreinscripcionController::class, 'vista_articulo'])->name('pre.articulo');
    Route::get('/mail/check/{timecheck}/{carrera_id}', [PreinscripcionController::class, 'email_check'])->name(
        'pre.email'
    );


    // Acciones
    Route::post('inscribir/{carrera_id}', [PreinscripcionController::class, 'crear'])->name('crear_preins');
    Route::post('editar/{id}', [PreinscripcionController::class, 'editar'])->name('editar_preins');
    Route::get('eliminar/{timecheck}/{id}', [PreinscripcionController::class, 'borrar'])->name('pre.eliminar');
    Route::get('/admin/descargar-excel/{carrera_id}', [PreinscripcionController::class, 'descargar_excel'])->name(
        'pre.excel'
    );
    Route::get('/admin/excel/verificados', [PreinscripcionController::class, 'descargar_verificados'])->name(
        'pre.excelv'
    );
    Route::get('/admin/estado/{id}', [PreinscripcionController::class, 'cambiar_estado'])->name('pre_estado');
    Route::post('/error/{id}', [PreinscripcionController::class, 'email_archivo_error'])->name('pre.error');
});

// Rutas de Proceso
Route::prefix('proceso')->group(function () {
    // Vistas
    Route::get('/admin/{alumno_id}/{carrera_id}/{ciclo_lectivo}',[ProcesoController::class,'vista_admin'])->name('proceso.admin');
    Route::get('inscribir/{id}', [ProcesoController::class, 'vista_inscribir'])->name('proceso.inscribir');

    Route::get('detalle/{id}', [ProcesoController::class, 'vista_detalle'])->name('proceso.detalle');

    // Vista Alumno
    Route::get('/mis_procesos/{id}/{carrera}/{year}', [AlumnoProcesoController::class, 'vista_procesos'])->name('proceso.alumno');
    Route::get('/mis_procesos_carrera/{idAlumno}/{idCarrera}', [AlumnoProcesoController::class, 'vistaProcesosPorCarrera'])->name('proceso.alumnoCarrera');

    // Acciones
    Route::get('inscribir_proceso/{alumno_id}/{materia_id}', [ProcesoController::class, 'inscribir'])->name(
        'inscribir_proceso'
    );
    Route::get('inscribir/{alumno_id}/{materia_id}/{ciclo_lectivo}', [ProcesoController::class, 'inscribir'])->name('proceso.inscribirAlumno');
    Route::get('delete/{proceso_id}',[ProcesoController::class,'eliminar']);
    Route::get('eliminar/{id}/{alumno_id}', [ProcesoController::class, 'delete']);
    Route::get('listado/{materia_id}/{ciclo_lectivo}/{comision_id?}', [ProcesoController::class, 'vista_listado'])->name(
        'proceso.listado'
    );
    Route::get('/{id}',[ProcesoController::class,'getProceso']);

    Route::get('listado-cargo/{materia_id}/{cargo_id}/{ciclo_lectivo?}/{comision_id?}',
        [ProcesoController::class, 'vista_listadoCargo']
    )->name(
        'proceso.listadoCargo'
    );

    Route::get('listado-modular/{materia_id}/{comision_id?}', [ProcesoController::class, 'vista_listadoModular'])->name(
        'proceso.listadoModular'
    );

    Route::get(
        'listado-cargos-modulo/{materia_id}/{cargo_id}/{alumno_id}/{comision_id?}',
        [ProcesoController::class, 'vista_listadoCargosModulo']
    )->name(
        'proceso.listadoCargosModulo'
    );
    Route::post('cambia/estado', [ProcesoController::class, 'cambiaEstado'])->name('proceso.cambiaEstado');
    Route::post('cambia/cierre', [ProcesoController::class, 'cambiaCierre'])->name('proceso.cambiaCierre');
    Route::get(
        'cambia/cierre-general/{materia_id}/{cargo_id?}/{comision_id?}/{cierre_coordinador?}',
        [ProcesoController::class, 'cambiaCierreGeneral']
    )->name(
        'proceso.cambiaCierreGeneral'
    );
    Route::post('cambia/nota_final', [ProcesoController::class, 'cambia_nota_final'])->name('proceso.nota_final');
    Route::post('cambia/nota_global', [ProcesoController::class, 'cambia_nota_global'])->name('proceso.nota_global');
    Route::post('calcularPorcentaje', [ProcesoCalificacionController::class, 'calcularPorcentaje']);
    Route::get('procesosCalificaciones/{proceso_id}', [ProcesoCalificacionController::class, 'show']);

});

// Rutas de Asistencia
Route::prefix('asistencias')->group(function () {
    // Vistas
    Route::get('carreras/{ciclo_lectivo?}', [AsistenciaController::class, 'vista_carreras'])->name('asis.inicio');
    Route::get('materia/{id}/{ciclo_lectivo?}/{cargo_id?}', [AsistenciaController::class, 'vista_admin'])->name(
        'asis.admin'
    );
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
    Route::get('/administrar/{todos?}', [InstanciaController::class, 'vista_admin'])->name('mesa.admin');
    Route::get('/carreras/{sede_id}/{instancia_id}', [InstanciaController::class, 'vista_carreras'])->name(
        'mesa.carreras'
    );
    Route::get('/carrera/admin/{id}/{instancia_id}', [InstanciaController::class, 'vista_mesas'])->name('mesa.mesas');
    Route::get('/cronograma/{instancia_id}', [MesaController::class, 'vistaCronograma'])->name('mesa.cronograma');
    Route::get('/materias/{instancia_id?}', [AlumnoMesaController::class, 'vista_materias'])->name('mesa.mate');
    Route::get('/inscriptos/{instancia_id}/{materia_id}/{comision_id?}', [MesaController::class, 'vista_inscripciones']
    )->name(
        'mesa.inscriptos'
    );
    Route::get('/inscriptos_especial/{id}/{instancia_id}/{comision_id?}', [AlumnoMesaController::class, 'vista_inscriptos'])->name(
        'mesa.especial.inscriptos'
    );
    Route::post('/asignar_mesa', [AlumnoMesaController::class, 'asignar_mesa'])->name('mesas.asignar');

    Route::post('/seleccionar/{id}', [InstanciaController::class, 'seleccionar_sede'])->name('sele.sede');
    Route::post('/crear/{materia_id}/{instancia_id}', [MesaController::class, 'crear'])->name('crear_mesa');
    Route::post('/editar/{materia_id}/{instancia_id}', [MesaController::class, 'editar'])->name('editar_mesa');
    Route::get('/borrar/{id}/{solo?}', [InstanciaController::class, 'borrar'])->name('borrar_datos');
    Route::post('/crear_instancia', [InstanciaController::class, 'crear'])->name('crear_instancia');
    Route::post('/editar_instancia/{id}', [InstanciaController::class, 'editar'])->name('editar_instancia');
    Route::get('/estado/{estado}/{id}', [InstanciaController::class, 'cambiar_estado']);
    Route::get('/cierre/{cierre}/{id}', [InstanciaController::class, 'cambiar_cierre']);
    Route::post('/alumno/crear', [AlumnoMesaController::class, 'materias'])->name('mesas.materias');
    Route::post('/mesa_inscripcion/{instancia_id?}', [AlumnoMesaController::class, 'inscripcion'])->name('insc_mesa');
    Route::get('/bajar_mesa/{id}/{instancia_id?}', [AlumnoMesaController::class, 'bajar_mesa'])->name('mesa.baja');
    Route::get('/alta_mesa/{id}', [AlumnoMesaController::class, 'alta_mesa'])->name('alta.mesa');
    Route::post('/borrar_inscripcion/{id}/{instancia_id?}', [AlumnoMesaController::class, 'borrar_inscripcion'])->name(
        'mesa.borrar'
    );
    Route::post('/moverComision/{inscripcion_id}', [AlumnoMesaController::class, 'moverComision'])->name(
        'mesa.moverComision'
    );


    Route::get('/editar_mesa/{dni}/{id}/{sede_id}', [AlumnoMesaController::class, 'email_session'])->name('edit.mesa');
    Route::get('/descargar_excel/{id}/{instancia_id}/{llamado?}', [InstanciaController::class, 'descargar_excel']
    )->name('mesa.descargar');
    Route::get('/descargar_tribunal/{id}/{instancia_id}', [InstanciaController::class, 'descargar_tribunal'])->name(
        'mesa.tribunal'
    );
    Route::get('/descargar_total/{id}', [InstanciaController::class, 'descargar_total'])->name('mesa.total.descargar');
    Route::post('/inscribir_alumno', [AlumnoMesaController::class, 'inscribir_alumno'])->name('mesa.inscribir_alumno');
    Route::post('/confirmar/{mesa_alumno_id}', [AlumnoMesaController::class, 'confirmar'])->name('mesa.confirmar');
    Route::get(
        'generar-pdf-mesa/{instancia}/{carrera}/{llamado?}/{comision?}',
        [MesaController::class, 'generar_pdf_mesa']
    )->name(
        'generar_pdf_mesa'
    );

    Route::get(
        'generar-pdf-acta-volante/{instancia}/{carrera}/{materia}/{llamado}/{orden}/{comision?}',
        [MesaController::class, 'generar_pdf_acta_volante']
    )->name(
        'generar_pdf_acta_volante'
    );
    Route::get('/resumen/{instancia_id}', [ActaVolanteController::class, 'resumenInstancia'])->name('mesas.resumen');

    Route::post('/updateLibroFolio/{id}', [MesaController::class, 'updateLibroFolio'])->name('mesa.librofolio');
    Route::get('/mesaByComision/{materia_id}/{instancia_id}/{comision_id?}', [MesaController::class, 'mesaByComision']);
    Route::put('/cerrarActaVolante/{mesa_id}', [MesaController::class, 'cierreProfesor'])->name('mesa.cerrar_acta');
    Route::put('/abrirActaVolante/{mesa_id}', [MesaController::class, 'abrirProfesor'])->name('mesa.abrir_acta');
    Route::delete('borrar_mesa/{mesa_id}', [MesaController::class, 'delete'])->name('mesa.delete');
});

Route::resource('actasVolantes', ActaVolanteController::class);
Route::prefix('actasVolantes')->group(function () {
    Route::get('/anteriores/{materia_id}/{alumno_id}/', [ActaVolanteController::class, 'notasAnteriores'])->name(
        'acta-volante.anteriores-notas'
    );
});


Route::prefix('matriculacion')->group(function () {
    Route::get('/carrera/{id}/{year}/{timecheck?}', [MatriculacionController::class, 'create'])->name(
        'matriculacion.create'
    );
    Route::get('/editar/{alumno_id}/{carrera_id}/{year?}', [MatriculacionController::class, 'edit'])->name(
        'matriculacion.edit'
    );
    Route::get('/delete/{id}', [MatriculacionController::class, 'delete'])->name(
        'alumno.delete'
    );

    Route::delete('/deleteAlumno/{id}/{carrera_id}', [MatriculacionController::class, 'deleteInscripcion'])->name('matriculacion.delete');

    Route::get('/', [MatriculacionController::class, 'index'])->name('matriculacion.index');
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
Route::post('asignaRelacionCargoModulo', [ModulosController::class, 'asignaRelacionCargoModulo'])->name(
    'modulos.asignaRelacionCargoModulo'
);
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
    Route::get('home/{ciclo_lectivo?}', [CalificacionController::class, 'home'])->name('calificacion.home');
    Route::get('admin/{materia_id}/{ciclo_lectivo?}/{cargo_id?}', [CalificacionController::class, 'admin'])->name(
        'calificacion.admin'
    );
    Route::get('create/{id}', [CalificacionController::class, 'create'])->name('calificacion.create');

    Route::post('/', [CalificacionController::class, 'store'])->name('calificacion.store');
    Route::post('update/{calificacion}', [CalificacionController::class, 'update'])->name('calificacion.update');
    Route::get('edit/{calificacion}', [CalificacionController::class, 'edit'])->name('calificacion.edit');
    Route::delete('/{id}', [CalificacionController::class, 'delete'])->name('calificacion.delete');
});


Route::prefix('procesoCalificacion')->group(function () {
    Route::post('/', [ProcesoCalificacionController::class, 'store']);
    Route::post('/recuperatorio', [ProcesoCalificacionController::class, 'crearRecuperatorio']);
    Route::post('/delete', [ProcesoCalificacionController::class, 'delete']);
});


Route::prefix('estadistica')->group(function () {
    Route::get('datos', [AlumnoController::class, 'vista_datos']);
    Route::get('obtenerGraficos/{sede_id?}/{carrera_id?}/{year?}', [AlumnoController::class, 'obtenerGraficos']);
});

Route::resource('etapa_campo', EtapaCampoController::class);

Route::prefix('etapa_campo')->group(function () {
    Route::get('/habilitacion/proceso/{proceso_id}/{habilitacion}', [EtapaCampoController::class, 'habilitar']);
});

Route::prefix('excel')->group(function () {
    Route::get('alumnos/{carrera_id}/{year}/{ciclo_lectivo}/{comision_id?}', [ExcelController::class, 'alumnos_year'])->name('excel.alumnosAño');
    Route::get('alumnos/all', [ExcelController::class, 'all_alumnos'])->name('excel.all_alumnos');
    Route::get('procesos/{materia_id}/{ciclo_lectivo}/{comision_id?}', [ExcelController::class, 'planilla_notas_tradicional'])->name(
        'excel.procesos'
    );
    Route::get('procesosModular/{materia_id}/{ciclo_lectivo}/{comision_id?}', [ExcelController::class, 'planilla_notas_modular'])->name(
        'excel.procesosModular'
    );
    Route::get('alumnosDatos/{carrera_id}/{ciclo_lectivo?}', [ExcelController::class, 'alumnos_datos'])->name('excel.alumnosDatos');
    Route::get('/descargarFiltro', [ExcelController::class, 'filtro_alumnos']);
});

Route::resource('libros', LibrosController::class);

Route::prefix('mail')->group(function () {
    Route::post('/mail/pre/send/{carrera_id}', [MailController::class, 'emailPreinscripciones'])->name('pre.sendEmail');
});

Route::prefix('observaciones_trianual')->group(function () {
    Route::get('/', [ObservacionesTrianualController::class, 'index'])->name('observaciones_trianual.listar');
    Route::post('/', [ObservacionesTrianualController::class, 'store'])->name('observaciones_trianual.guardar');
    Route::get('/crear/{alumno}', [ObservacionesTrianualController::class, 'create'])->name('observaciones_trianual.crear');
    Route::get('/ver/{trianual}', [ObservacionesTrianualController::class, 'show'])->name('observaciones_trianual.ver');
});

Route::resource('registros', AuditController::class);

Route::prefix('trianual')->group(function () {
    Route::get('/', [TrianualController::class, 'index'])->name('trianual.listar');
    Route::post('/', [TrianualController::class, 'store'])->name('trianual.guardar');
    Route::get('/crear/{alumno}', [TrianualController::class, 'create'])->name('trianual.crear');
    Route::get('/ver/{trianual}', [TrianualController::class, 'show'])->name('trianual.ver');
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
    Route::get('reestablecer_password/{id}', [UserController::class, 'regenerar_contra']);
    Route::get('activarDesactivar/{id}', [UserController::class, 'activarDesactivar']);
});

Route::get('/ruta_funcionalidades/{sede_id}/{}', function ($instancia_id) {


})->middleware('app.roles:admin');

Route::group([
    'prefix' => 'condicion_carreras',
], function () {
    Route::get('/', [CondicionCarrerasController::class, 'index'])
         ->name('condicion_carreras.condicion_carrera.index');
    Route::get('/create', [CondicionCarrerasController::class, 'create'])
         ->name('condicion_carreras.condicion_carrera.create');
    Route::get('/show/{condicionCarrera}',[CondicionCarrerasController::class, 'show'])
         ->name('condicion_carreras.condicion_carrera.show')->where('id', '[0-9]+');
    Route::get('/{condicionCarrera}/edit',[CondicionCarrerasController::class, 'edit'])
         ->name('condicion_carreras.condicion_carrera.edit')->where('id', '[0-9]+');
    Route::post('/', [CondicionCarrerasController::class, 'store'])
         ->name('condicion_carreras.condicion_carrera.store');
    Route::put('condicion_carrera/{condicionCarrera}', [CondicionCarrerasController::class, 'update'])
         ->name('condicion_carreras.condicion_carrera.update')->where('id', '[0-9]+');
    Route::delete('/condicion_carrera/{condicionCarrera}',[CondicionCarrerasController::class, 'destroy'])
         ->name('condicion_carreras.condicion_carrera.destroy')->where('id', '[0-9]+');
});

Route::group([
    'prefix' => 'condicion_materias',
], function () {
    Route::get('/', [CondicionMateriasController::class, 'index'])
         ->name('condicion_materias.condicion_materia.index');
    Route::get('/create', [CondicionMateriasController::class, 'create'])
         ->name('condicion_materias.condicion_materia.create');
    Route::get('/show/{condicionMateria}',[CondicionMateriasController::class, 'show'])
         ->name('condicion_materias.condicion_materia.show');
    Route::get('/{condicionMateria}/edit',[CondicionMateriasController::class, 'edit'])
         ->name('condicion_materias.condicion_materia.edit');
    Route::post('/', [CondicionMateriasController::class, 'store'])
         ->name('condicion_materias.condicion_materia.store');
    Route::put('condicion_materia/{condicionMateria}', [CondicionMateriasController::class, 'update'])
         ->name('condicion_materias.condicion_materia.update');
    Route::delete('/condicion_materia/{condicionMateria}',[CondicionMateriasController::class, 'destroy'])
         ->name('condicion_materias.condicion_materia.destroy');
});
Route::get('api-docs/condicion_materias', [CondicionMateriaApiDocsApiDocsController::class, 'index'])
     ->name('api-docs.condicion_materias.condicion_materia.index');

Route::group([
    'prefix' => 'materias_correlativas_cursados',
], function () {
    Route::get('/', [MateriasCorrelativasCursadosController::class, 'index'])
         ->name('materias_correlativas_cursados.materias_correlativas_cursado.index');
    Route::get('/create', [MateriasCorrelativasCursadosController::class, 'create'])
         ->name('materias_correlativas_cursados.materias_correlativas_cursado.create');
    Route::get('/show/{materiasCorrelativasCursado}',[MateriasCorrelativasCursadosController::class, 'show'])
         ->name('materias_correlativas_cursados.materias_correlativas_cursado.show');
    Route::get('/{materiasCorrelativasCursado}/edit',[MateriasCorrelativasCursadosController::class, 'edit'])
         ->name('materias_correlativas_cursados.materias_correlativas_cursado.edit');
    Route::post('/', [MateriasCorrelativasCursadosController::class, 'store'])
         ->name('materias_correlativas_cursados.materias_correlativas_cursado.store');
    Route::put('materias_correlativas_cursado/{materiasCorrelativasCursado}', [MateriasCorrelativasCursadosController::class, 'update'])
         ->name('materias_correlativas_cursados.materias_correlativas_cursado.update');
    Route::delete('/materias_correlativas_cursado/{materiasCorrelativasCursado}',[MateriasCorrelativasCursadosController::class, 'destroy'])
         ->name('materias_correlativas_cursados.materias_correlativas_cursado.destroy');
});
