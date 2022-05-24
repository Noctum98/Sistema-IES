<?php

use App\Http\Controllers\AlumnoProcesoController;
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
use App\Http\Controllers\AlumnoCarreraController;
use App\Http\Controllers\AlumnoTrabajoController;
use App\Http\Controllers\AlumnoParcialController;
use App\Http\Controllers\PreinscripcionController;
use App\Http\Controllers\InstanciaController;
use App\Http\Controllers\AlumnoMesaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\MatriculacionController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserCarreraController;
use App\Http\Controllers\UserMateriaController;
use Illuminate\Support\Facades\Artisan;
use App\Models\Alumno;
use App\Models\Cargo;
use App\Models\Carrera;
use App\Models\Instancia;
use App\Models\MesaAlumno;

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
Route::get('/', function () {
    if (Auth::user()) {
        return view('home');
    } else {
        return view('auth.login');
    }
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
    Route::get('detalle/{id}',[UserController::class,'vista_detalle'])->name('usuarios.detalle');
    Route::get('listado/{listado}/{busqueda?}',[UserController::class,'vista_listado'])->name('usuarios.listado');


    // Funcionalidades
    Route::post('editar_usaurio', [UserController::class, 'editar'])->name('editar_usuario');
    Route::delete('/{id}',[UserController::class,'delete'])->name('usuario.eliminar');
    Route::post('cambiar_contra', [UserController::class, 'cambiar_contra'])->name('cambiar_contra');
    Route::post('set_rol/{id}', [UserController::class, 'set_roles'])->name('set_roles');
    Route::post('cambiar_sedes/{id}', [UserController::class, 'cambiar_sedes'])->name('sede_usuario');
    Route::post('set_Carrera/{id}',[UserCarreraController::class,'store'])->name('set_carrera');
    Route::post('set_CarreraMaterias/{id}',[UserMateriaController::class,'store'])->name('set_materias_carreras');
    Route::get('crear_alumno_usuario/{id}',[UserController::class,'crear_usuario_alumno'])->name('crear_usuario_alumno');
});

Route::prefix('usuario_materia')->group(function () {
    Route::delete('delete/{user_id}/{materia_id}',[UserMateriaController::class,'delete'])->name('delete_materias_carreras');

});

//Ruta de Roles
Route::resource('roles',RolController::class);

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
    Route::post('cargo',[CargoController::class,'store'])->name('cargo.store');
    Route::get('cargo/{id}', [CargoController::class, 'show'])->name('cargo.show');
    Route::get('editar/{id}', [CargoController::class, 'vista_editar'])->name('cargo.edit');
    Route::post('editar-cargo/{cargo}', [CargoController::class, 'editar'])->name('editar_cargo');

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
    Route::get('descargar_excel_alumnos/{id}',[MateriaController::class,'descargar_planilla'])->name('descargar_planilla');
});
Route::get('/selectMateriasCarrera/{id}',[MateriaController::class,'selectMaterias']);
Route::get('/selectCargosCarrera/{id}',[CargoController::class,'selectCargos']);
Route::get('/buscaUsuarioByUsername/{busqueda}',[UserController::class,'getUsuarioByUsernameOrNull']);

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
    Route::get('ver-imagen/{foto}', [AlumnoController::class, 'ver_foto'])->name('ver_imagen');
    Route::get('descargar/{nombre}/{disco}', [AlumnoController::class, 'descargar_archivo'])->name('descargar_archivo');
    Route::get('descargar-ficha/{id}', [AlumnoController::class, 'descargar_ficha'])->name('descargar_ficha');
});

Route::prefix('alumno/carrera')->group(function(){
    Route::post('/changeYear/{alumno_id}/{carrera_id}',[AlumnoCarreraController::class,'changeAño'])->name('alumnoCarrera.year');
});

// Rutas de preinscripciones
Route::prefix('preinscripcion')->group(function () {
    Route::get('/carreras/{busqueda?}', [PreinscripcionController::class, 'vista_admin'])->name('pre.admin');
    Route::get('/{id}', [PreinscripcionController::class, 'vista_preinscripcion'])->name('alumno.pre');
    Route::get('terminada/{timecheck}/{id}', [PreinscripcionController::class, 'vista_inscripto'])->name('pre.inscripto');
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
    Route::get('/mis_procesos/{id}',[AlumnoProcesoController::class,'vista_procesos'])->name('proceso.alumno');

    // Acciones
    Route::get('inscribir_proceso/{alumno_id}/{materia_id}', [ProcesoController::class, 'inscribir'])->name('inscribir_proceso');
    Route::post('administrar/{alumno_id}',[ProcesoController::class,'administrar'])->name('proceso.administrar');
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

    Route::get('cerrar/{id}', [AsistenciaController::class, 'cerrar_planilla'])->name('cerrar_asis');
});

// Rutas de Alumno_Asistencia
Route::prefix('alumno/asis')->group(function () {
    Route::get('{alumno_id}/{asistencia_id}/{estado}', [AlumnoAsistenciaController::class, 'crear']);
});

// Rutas de Trabajos
Route::prefix('trabajos')->group(function () {
    // Vistas
    Route::get('carreras', [TrabajoController::class, 'vista_carreras'])->name('trab.inicio');
    Route::get('materia/{id}', [TrabajoController::class, 'vista_admin'])->name('trab.admin');
    Route::get('crear/{id}', [TrabajoController::class, 'vista_crear'])->name('trab.crear');
    Route::get('editar/{id}', [TrabajoController::class, 'vista_editar'])->name('trab.editar');
    Route::get('notas/{id}', [TrabajoController::class, 'vista_notas'])->name('trab.notas');

    // Acciones
    Route::post('crear_trabajo/{id}', [TrabajoController::class, 'crear'])->name('crear_trab');
});

// Ruta AlumnoTrabajo
Route::prefix('nota')->group(function () {
    Route::get('trabajo/{alumno_id}/{trabajo_id}/{porcentaje}/{nota}', [AlumnoTrabajoController::class, 'crear']);
    Route::get('parcial/{alumno_id}/{parcial_id}/{porcentaje}/{nota}', [AlumnoParcialController::class, 'crear']);
    Route::get('recu/{alumno_id}/{parcial_id}/{porcentaje}/{nota}', [AlumnoParcialController::class, 'recuperatorio']);
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
    Route::get('/instancias',[AlumnoMesaController::class,'vista_instancias'])->name('mesa.instancias');
    Route::get('/administrar', [InstanciaController::class, 'vista_admin'])->name('mesa.admin');
    Route::get('/carreras/{sede_id}/{instancia_id}', [InstanciaController::class, 'vista_carreras'])->name('mesa.carreras');
    Route::get('/materias/{instancia_id?}', [AlumnoMesaController::class, 'vista_materias'])->name('mesa.mate');
    Route::get('/inscriptos/{id}', [MesaController::class, 'vista_inscripciones'])->name('mesa.inscriptos');
    Route::get('/especial/inscriptos/{id}/{instancia_id?}',[AlumnoMesaController::class,'vista_inscriptos'])->name('mesa.especial.inscriptos');

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
    Route::post('/borrar_mesa/{id}/{instancia_id?}', [AlumnoMesaController::class, 'borrar_inscripcion'])->name('mesa.borrar');
    Route::get('/editar_mesa/{dni}/{id}/{sede_id}', [AlumnoMesaController::class, 'email_session'])->name('edit.mesa');
    Route::get('/descargar_excel/{id}/{instancia_id}/{llamado?}', [InstanciaController::class, 'descargar_excel'])->name('mesa.descargar');
    Route::get('/descargar_tribunal/{id}', [InstanciaController::class, 'descargar_tribunal'])->name('mesa.tribunal');
    Route::get('/descargar_total/{id}', [InstanciaController::class, 'descargar_total'])->name('mesa.total.descargar');
});

Route::prefix('matriculacion')->group(function(){
    Route::get('/carrera/{id}/{year}/{timecheck?}', [MatriculacionController::class,'create'])->name('matriculacion.create');
    Route::get('/editar/{alumno_id}/{carrera_id}/{year?}',[MatriculacionController::class,'edit'])->name('matriculacion.edit');
    Route::delete('/delete/{id}/{carrera_id}/{year?}',[MatriculacionController::class,'delete'])->name('matriculacion.delete');
    Route::get('/email_check/{timecheck}/{carrera_id}/{year}',[MatriculacionController::class,'email_check'])->name('matriculacion.checked');
    Route::get('finalizada',function(){
        return view('matriculacion.card_email_check');
    });
    Route::post('/carrera/{id}/{year}',[MatriculacionController::class,'store'])->name('matriculacion.store');
    Route::put('/carrera/{id}/{carrera_id?}/{year?}',[MatriculacionController::class,'update'])->name('matriculacion.update');
    Route::post('/verificar/{carrera_id}/{year}',[MatriculacionController::class,'send_email'])->name('matriculacion.verificar');
});

//Route::resource('cargo',CargoController::class);
Route::post('agregarModulo',[CargoController::class,'agregarModulo'])->name('cargo.agregarModulo');
Route::post('agregarUser',[CargoController::class,'agregarUser'])->name('cargo.agregarUser');

Route::prefix('excel')->group(function(){
    Route::get('alumnos/{carrera_id}/{year}',[ExcelController::class,'alumnos_year'])->name('excel.alumnosAño');
});

Route::get('/clear-cache', function () {
    echo Artisan::call('config:clear');
    echo Artisan::call('config:cache');
    echo Artisan::call('view:clear');
    echo Artisan::call('cache:clear');
    echo Artisan::call('route:clear');
 });


Route::get('/prueba', function () {
    return view('mail.baja_mesa_motivos',[
        'instancia' => Instancia::find(9),
        'inscripcion' => MesaAlumno::find(1)
    ]);
});
