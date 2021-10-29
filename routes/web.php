<?php

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
use App\Http\Controllers\TrabajoController;
use App\Http\Controllers\ParcialController;
use App\Http\Controllers\AlumnoAsistenciaController;
use App\Http\Controllers\AlumnoTrabajoController;
use App\Http\Controllers\AlumnoParcialController;
use App\Http\Controllers\PreinscripcionController;
use App\Http\Controllers\InstanciaController;
use App\Http\Controllers\AlumnoMesaController;
use App\Http\Controllers\MesaController;


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
Route::get('/',function(){
    if(Auth::user()){
       return view('home'); 
    }else{
     return view('auth.login');   
    }
});

//Rutas de sedes
Route::prefix('sedes')->group(function(){
    // Vistas
    Route::get('/',[SedeController::class,'vista_sedes'])->name('sedes.admin');
    Route::get('crear',[SedeController::class,'vista_crear'])->name('sedes.crear');
    Route::get('editar/{id}',[SedeController::class,'vista_editar'])->name('sedes.editar');

    //  Acciones
    Route::post('crear-sede',[SedeController::class,'crear'])->name('crear_sede');
    Route::post('editar-sede/{id}',[SedeController::class,'editar'])->name('editar_sede');
    Route::get('eliminar-sede/{id}',[SedeController::class,'eliminar'])->name('eliminar_sede');
});

//Ruta de usuario administrador
Route::prefix('usuarios')->group(function(){
    Route::get('administar',[UserController::class,'vista_admin'])->name('usuarios.admin');
    Route::get('editar',[UserController::class,'vista_editar'])->name('usuarios.editar');

    // Funcionalidades
    Route::post('editar_usaurio',[UserController::class,'editar'])->name('editar_usuario');
    Route::post('cambiar_contra',[UserController::class,'cambiar_contra'])->name('cambiar_contra');
    Route::get('cambiar_rol/{id}/{rol}',[UserController::class,'cambiar_rol'])->name('rol_usuario');
    Route::post('cambiar_sede/{id}',[UserController::class,'cambiar_sede'])->name('sede_usuario');
});

// Rutas de Personal
Route::prefix('personal')->group(function(){
    // Vistas
    Route::get('/',[PersonalController::class,'vista_admin'])->name('personal.admin');
    Route::get('crear',[PersonalController::class,'vista_crear'])->name('personal.crear');
    Route::get('ficha/{id}',[PersonalController::class,'vista_detalle'])->name('personal.ficha');
    Route::get('editar/{id}',[PersonalController::class,'vista_editar'])->name('personal.editar');

    // Acciones
    Route::post('crear-personal',[PersonalController::class,'crear_personal'])->name('crear_personal');
    Route::post('edita-personal/{id}',[PersonalController::class,'editar_personal'])->name('editar_personal');
    Route::get('descargar-ficha/{id}',[PersonalController::class,'descargar_ficha'])->name('descargar_ficha');
});

// Rutas de Carreras
Route::prefix('carreras')->group(function(){
    // Vistas
    Route::get('/',[CarreraController::class,'vista_admin'])->name('carrera.admin');
    Route::get('crear',[CarreraController::class,'vista_crear'])->name('carrera.crear');
    Route::get('personal/{id}',[CarreraController::class,'vista_agregarPersonal'])->name('carrera.personal');
    Route::get('editar/{id}',[CarreraController::class,'vista_editar'])->name('carrera.editar');

    // Acciones
    Route::post('crear-carrera',[CarreraController::class,'crear'])->name('crear_carrera');
    Route::post('agregar-personal/{id}',[CarreraController::class,'agregar_personal'])
    ->name('agregar_personal');
    Route::post('editar-carrera/{id}',[CarreraController::class,'editar'])->name('editar_carrera');
});

// Rutas de Materias
Route::prefix('carreras/materias')->group(function(){
    // Vistas
    Route::get('/{carrera_id}',[MateriaController::class,'vista_admin'])->name('materia.admin');
    Route::get('crear/{carrera_id}',[MateriaController::class,'vista_crear'])->name('materia.crear');
    Route::get('editar/{id}',[MateriaController::class,'vista_editar'])->name('materia.editar');

    // Acciones
    Route::post('crear-materia/{carrera_id}',[MateriaController::class,'crear'])->name('crear_materia');
    Route::post('editar-materia/{id}',[MateriaController::class,'editar'])->name('editar_materia');
});

// Rutas de Alumnos
Route::prefix('alumnos')->group(function(){
    // Vistas
    Route::get('/{busqueda?}',[AlumnoController::class,'vista_admin'])->name('alumno.admin');
    Route::get('agregar/{id}',[AlumnoController::class,'vista_crear'])->name('alumno.crear');
    Route::get('carrera/elegir',[AlumnoController::class,'vista_elegir'])->name('alumno.elegir');
    Route::get('editar/{id}',[AlumnoController::class,'vista_editar'])->name('alumno.editar');
    Route::get('carrera/{carrera_id}',[AlumnoController::class,'vista_alumnos'])->name('alumno.carrera');
    Route::get('alumno/{id}',[AlumnoController::class,'vista_detalle'])->name('alumno.detalle');

    // Acciones
    Route::post('crear-alumno/{carrera_id}',[AlumnoController::class,'crear'])->name('crear_alumno');
    Route::post('editar-alumno/{id}',[AlumnoController::class,'editar'])->name('editar_alumno');
    Route::get('ver-imagen/{foto}',[AlumnoController::class,'ver_foto'])->name('ver_imagen');
    Route::get('descargar/{nombre}/{disco}',[AlumnoController::class,'descargar_archivo'])->name('descargar_archivo');
    Route::get('descargar-ficha/{id}',[AlumnoController::class,'descargar_ficha'])->name('descargar_ficha');
});

// Rutas de preinscripciones
Route::prefix('preinscripcion')->group(function(){
    Route::get('/carreras/{busqueda?}',[PreinscripcionController::class,'vista_admin'])->name('pre.admin');
    Route::get('/{id}',[PreinscripcionController::class,'vista_preinscripcion'])->name('alumno.pre');
    Route::get('terminada/{timecheck}/{id}',[PreinscripcionController::class,'vista_inscripto'])->name('pre.inscripto');
    Route::get('editada/{timecheck}/{id}',[PreinscripcionController::class,'vista_editado'])->name('pre.editado');
    Route::get('eliminada',[PreinscripcionController::class,'vista_eliminado'])->name('pre.eliminado');
    Route::get('/carrera/{id}',[PreinscripcionController::class,'vista_all'])->name('pre.all');
    Route::get('/datos/{id}',[PreinscripcionController::class,'vista_detalle'])->name('pre.detalle');
    Route::get('/verificadas/{id}',[PreinscripcionController::class,'vista_verificadas'])->name('pre.verificadas');
    Route::get('/erroneas/{id}',[PreinscripcionController::class,'vista_sincorregir'])->name('pre.sincorregir');
    Route::get('/editar/{timecheck}/{id}',[PreinscripcionController::class,'vista_editar'])->name('pre.editar');
    Route::get('/articulo/septimo',[PreinscripcionController::class,'vista_articulo'])->name('pre.articulo');


    // Acciones
    Route::post('inscribir/{carrera_id}',[PreinscripcionController::class,'crear'])->name('crear_preins');
    Route::post('editar/{id}',[PreinscripcionController::class,'editar'])->name('editar_preins');
    Route::get('eliminar/{timecheck}/{id}',[PreinscripcionController::class,'borrar'])->name('pre.eliminar');
    Route::get('descargar-excel/{carrera_id}',[PreinscripcionController::class,'descargar_excel'])->name('pre.excel');
    Route::get('/excel/verificados',[PreinscripcionController::class,'descargar_verificados'])->name('pre.excelv');
    Route::get('estado/{id}',[PreinscripcionController::class,'cambiar_estado'])->name('pre_estado');
    Route::post('/error/{id}',[PreinscripcionController::class,'email_archivo_error'])->name('pre.error');
});

// Rutas de Proceso
Route::prefix('proceso')->group(function(){
    // Vistas
    Route::get('inscribir/{id}',[ProcesoController::class,'vista_inscribir'])->name('proceso.inscribir');
    Route::get('detalle/{id}',[ProcesoController::class,'vista_detalle'])->name('proceso.detalle');

    // Acciones
    Route::get('inscribir_proceso/{alumno_id}/{materia_id}',[ProcesoController::class,'inscribir'])->name('inscribir_proceso');
});

// Rutas de Asistencia
Route::prefix('asistencias')->group(function(){
    // Vistas
    Route::get('carreras',[AsistenciaController::class,'vista_carreras'])->name('asis.inicio');
    Route::get('materia/{id}',[AsistenciaController::class,'vista_admin'])->name('asis.admin');
    Route::get('tomar/{id}',[AsistenciaController::class,'vista_crear'])->name('asis.crear');
    Route::get('fecha/{id}',[AsistenciaController::class,'vista_fecha'])->name('asis.fecha');
    Route::get('cerrada/{id}',[AsistenciaController::class,'vista_cerrar'])->name('asis.cerrar');


    // Acciones
    Route::post('crear_asistencia/{id}',[AsistenciaController::class,'crear'])->name('crear_asis');
    Route::get('cerrar/{id}',[AsistenciaController::class,'cerrar_planilla'])->name('cerrar_asis');
});

// Rutas de Alumno_Asistencia
Route::prefix('alumno/asis')->group(function(){
    Route::get('{alumno_id}/{asistencia_id}/{estado}',[AlumnoAsistenciaController::class,'crear']);
});

// Rutas de Trabajos
Route::prefix('trabajos')->group(function(){
    // Vistas
    Route::get('carreras',[TrabajoController::class,'vista_carreras'])->name('trab.inicio');
    Route::get('materia/{id}',[TrabajoController::class,'vista_admin'])->name('trab.admin');
    Route::get('crear/{id}',[TrabajoController::class,'vista_crear'])->name('trab.crear');
    Route::get('editar/{id}',[TrabajoController::class,'vista_editar'])->name('trab.editar');
    Route::get('notas/{id}',[TrabajoController::class,'vista_notas'])->name('trab.notas');

    // Acciones
    Route::post('crear_trabajo/{id}',[TrabajoController::class,'crear'])->name('crear_trab');
});

// Ruta AlumnoTrabajo
Route::prefix('nota')->group(function(){
    Route::get('trabajo/{alumno_id}/{trabajo_id}/{porcentaje}/{nota}',[AlumnoTrabajoController::class,'crear']);
    Route::get('parcial/{alumno_id}/{parcial_id}/{porcentaje}/{nota}',[AlumnoParcialController::class,'crear']);
    Route::get('recu/{alumno_id}/{parcial_id}/{porcentaje}/{nota}',[AlumnoParcialController::class,'recuperatorio']);
});

// Rutas de Parciales
Route::prefix('parciales')->group(function(){
    // Vistas
    Route::get('carreras',[ParcialController::class,'vista_carreras'])->name('parci.inicio');
    Route::get('materia/{id}',[ParcialController::class,'vista_admin'])->name('parci.admin');
    Route::get('crear/{id}',[ParcialController::class,'vista_crear'])->name('parci.crear');
    Route::get('notas/{id}',[ParcialController::class,'vista_notas'])->name('parci.notas');
    Route::get('editar/{id}',[ParcialController::class,'vista_editar'])->name('parci.editar');
    Route::get('recuperatorio/{id}',[ParcialController::class,'vista_recuperatorio'])->name('parci.recu');

    // Acciones
    Route::post('crear_parcial/{id}',[ParcialController::class,'crear'])->name('crear_parci');
});

// Ruta AlumnoParcial
Route::prefix('alumno/parci')->group(function(){
    
});

//Rutas de Mesas
Route::prefix('mesas')->group(function(){
    Route::get('/inscripcion/{id}',[AlumnoMesaController::class,'vista_home'])->name('mesa.welcome');
    Route::get('/administrar',[InstanciaController::class,'vista_admin'])->name('mesa.admin');
    Route::get('/carreras/{id}',[InstanciaController::class,'vista_carreras'])->name('mesa.carreras');
    Route::get('/materias',[AlumnoMesaController::class,'vista_materias'])->name('mesa.mate');

    Route::post('/seleccionar/{id}',[InstanciaController::class,'seleccionar_sede'])->name('sele.sede');
    Route::post('/crear/{id}',[MesaController::class,'crear'])->name('crear_mesa');
    Route::get('/borrar/{id}/{solo?}',[InstanciaController::class,'borrar'])->name('borrar_datos');
    Route::post('/crear_instancia',[InstanciaController::class,'crear'])->name('crear_instancia');
    Route::post('/editar_instancia/{id}',[InstanciaController::class,'editar'])->name('editar_instancia');
    Route::get('/estado/{estado}/{id}',[InstanciaController::class,'cambiar_estado']);
    Route::post('/alumno/crear',[AlumnoMesaController::class,'materias'])->name('mesas.materias');
    Route::post('/mesa_inscripcion',[AlumnoMesaController::class,'inscripcion'])->name('insc_mesa');
    Route::get('/bajar_mesa/{id}',[AlumnoMesaController::class,'bajar_mesa'])->name('mesa.baja');
    Route::get('/editar_mesa/{dni}/{id}/{sede_id}',[AlumnoMesaController::class,'email_session'])->name('edit.mesa');
    Route::get('/descargar_excel/{id}',[InstanciaController::class,'descargar_excel'])->name('mesa.descargar');
});
