<?php

namespace App\Models;

use App\Services\MesaService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mesa extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'instancia_id',
        'materia_id',
        'comision_id',
        'fecha',
        'cierre',
        'fecha_segundo',
        'cierre_segundo',
        'presidente',
        'primer_vocal',
        'segundo_vocal',
        'presidente_segundo',
        'primer_vocal_segundo',
        'segundo_vocal_segundo',
        'presidente_id',
        'primer_vocal_id',
        'segundo_vocal_id',
        'presidente_segundo_id',
        'primer_vocal_segundo_id',
        'segundo_vocal_segundo_id',
        'libro',
        'folio',
        'libro_segundo',
        'folio_segundo'
    ];

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    /**
     * @return HasMany
     */
    public function mesa_inscriptos_total(): HasMany
    {
        return $this->hasMany(MesaAlumno::class);
    }

    /**
     * @return HasMany
     */
    public function mesa_inscriptos(): HasMany
    {
        return $this->hasMany(MesaAlumno::class)
            ->where('estado_baja', false)
            ->orderBy('apellidos', 'ASC');
    }


    /**
     * @param int $orden
     * @param bool $all
     * @return Collection
     */
    public function mesa_inscriptos_primero(int $orden = 1, bool $all = false): Collection
    {
        $take = 26;
        $skip = $take * ($orden - 1);
        $inscriptos = $this->hasMany('App\Models\MesaAlumno')
            ->where(['estado_baja' => false, 'segundo_llamado' => false]);

        if (!$all) {
            $inscriptos = $inscriptos->skip($skip)
                ->take($take);
        }

        return $inscriptos->orderBy('apellidos', 'ASC')->get();
    }


    public function mesa_inscriptos_by_llamado(int $orden, bool $segundo): Collection
    {
        $take = 26;
        $skip = $take * ($orden - 1);
        $inscriptos = $this->hasMany(MesaAlumno::class)
            ->where(['estado_baja' => false, 'segundo_llamado' => $segundo]);

        $inscriptos = $inscriptos->skip($skip)
            ->take($take);

        return $inscriptos->orderBy('apellidos', 'ASC')->get();
    }

    /**
     * @param int $orden
     * @param bool $all
     * @return Collection
     */
    public function mesa_inscriptos_segundo(int $orden = 1, bool $all = false): Collection
    {
        $take = 26;
        $skip = $take * ($orden - 1);

        $inscriptos = $this->hasMany('App\Models\MesaAlumno')
            ->where(['estado_baja' => false, 'segundo_llamado' => true]);
        if (!$all) {
            $inscriptos = $inscriptos->skip($skip)
                ->take($take);
        }

        return $inscriptos->orderBy('apellidos', 'ASC')->get();
    }

    /**
     * @return HasMany
     */
    public function bajas_primero(): HasMany
    {
        return $this->hasMany(MesaAlumno::class)->where(['estado_baja' => true, 'segundo_llamado' => false]);
    }

    /**
     * @return HasMany
     */
    public function bajas_segundo(): HasMany
    {
        return $this->hasMany(MesaAlumno::class)->where(['estado_baja' => true, 'segundo_llamado' => true]);
    }

    /**
     * @return BelongsTo
     */
    public function instancia(): BelongsTo
    {
        return $this->belongsTo(Instancia::class, 'instancia_id');
    }

    /**
     * @return BelongsTo
     */
    public function comision(): BelongsTo
    {
        return $this->belongsTo(Comision::class, 'comision_id');
    }

    public function presidente_mesa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'presidente_id');
    }

    public function primer_vocal_mesa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'primer_vocal_id');
    }

    public function segundo_vocal_mesa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'segundo_vocal_id');
    }

    public function presidente_segundo_mesa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'presidente_segundo_id');
    }

    public function primer_vocal_segundo_mesa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'primer_vocal_segundo_id');
    }

    public function segundo_vocal_segundo_mesa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'segundo_vocal_segundo_id');
    }

    public function libros(): HasMany
    {
        return $this->hasMany(Libro::class, 'mesa_id');
    }

    /**
     * @param $llamado
     * @param int $orden
     * @return Libro|null
     */
    public function libro($llamado, int $orden = 1): ?Libro
    {
        return Libro::where(['llamado' => $llamado, 'orden' => $orden, 'mesa_id' => $this->id])->first();
    }

    public function getLibroPorFolio($llamado, int $folio): ?Libro
    {
        return Libro::where(['llamado' => $llamado, 'folio' => $folio, 'mesa_id' => $this->id])->first();
    }

    public function getSede()
    {
        return $this->materia->carrera->sede;
    }

    public function folios()
    {
        $folios = 1;
        if ($this->mesa_inscriptos->count() > 26) {
            $division_primero = $this->mesa_inscriptos->count() / 26;
            $folios = ceil($division_primero);
        }

        return $folios;
    }

    public function mesa_inscriptos_props(int $prop = null, $orden = 1, $all = false)
    {
        if ($this->instancia->tipo == 0) {
            if ($prop == 1) {
                return $this->mesa_inscriptos_primero($orden, $all);
            }
            if ($prop == 2) {
                return $this->mesa_inscriptos_segundo($orden, $all);
            }

            return $this->mesa_inscriptos();
        } else {
            $inscriptos = $this->mesa_inscriptos()->where('confirmado', true);

            $take = 26;
            $skip = $take * ($orden - 1);

            if ($prop == 1) {
                return $inscriptos->skip($skip)->take($take)->orderBy('apellidos', 'ASC')->get();
            }

            return $inscriptos->get();
        }
    }


    public function obtenerCarrerasByInstancia(int $instancia, $user)
    {
        return Carrera::select(
            'carreras.id as id',
            'carreras.nombre as nombre',
            'carreras.resolucion as resolucion',
            'sedes.nombre as sede'
        )
            ->join('sedes', 'carreras.sede_id', 'sedes.id')
            ->join('materias', 'carreras.id', 'materias.carrera_id')
            ->join('mesas', 'materias.id', 'mesas.materia_id')
            ->join('carrera_user', 'carreras.id', 'carrera_user.carrera_id')
            ->where('mesas.instancia_id', $instancia)
            ->where('carrera_user.user_id', $user->id)
            ->groupBy('carreras.id', 'carreras.nombre', 'carreras.resolucion', 'sedes.nombre')
            ->orderBy('sedes.nombre')
            //            ->orderBy('materias.nombre','asc')
            //            ->getQuery()->dd();
            ->get();
    }

    public function mesaFolios(): HasMany
    {
        return $this->hasMany(MesaFolio::class, 'mesa_id');
    }

    public function foliosByMesa()
    {
        return MesaFolio::where('mesa_id', $this->id)->get();
    }


    public function inscripciones(): HasMany
    {
        return $this->hasMany(MesaAlumno::class, 'mesa_id');
    }


    public function inscripcionesByMesa()
    {
        return MesaAlumno::where('mesa_id', $this->id)->get();
    }


    public function inscripcionesByMesaByAlumno($alumno_id): MesaAlumno
    {
        return MesaAlumno::where('mesa_id', $this->id)->where('alumno_id', $alumno_id)->first();
    }

    public function inscripcionesByMesaByAlumnoByCarreraByMateria($alumno_id, $carrera_id, $materia_id): MesaAlumno
    {
        return MesaAlumno::where('mesa_id', $this->id)
            ->where('alumno_id', $alumno_id)->where('carrera_id', $carrera_id)
            ->where('materia_id', $materia_id)->first();
    }

    public function inscripcionesByMesaByAlumnoByCarrera($alumno_id, $carrera_id): MesaAlumno
    {
        return MesaAlumno::where('mesa_id', $this->id)
            ->where('alumno_id', $alumno_id)->where('carrera_id', $carrera_id)->first();
    }


    public function actasVolantesByMesaByAlumno($alumno_id): Collection
    {
        return MesaAlumno::where('mesa_id', $this->id)
            ->where('alumno_id', $alumno_id)->with('actas_volantes')->first()->actasVolantes;
    }

    public function actasVolantes(): HasMany
    {
        return $this->hasMany(ActaVolante::class, 'mesa_id')
            ->select('actas_volantes.*')
            ->join('alumnos', 'actas_volantes.alumno_id', 'alumnos.id')
            ->orderBy('alumnos.apellidos', 'ASC')
            ->orderBy('alumnos.nombres', 'ASC');
    }

    /**
     * Recupera los resultados de una mesa.
     *
     *  Esta función toma una instancia de Mesa como parámetro y devuelve una matriz
     *  que contiene los resultados de la mesa.
     *
     *  Esto se hace creando una nueva instancia de la clase MesaService y llamando
     *  su método getDesgloseAprobados, pasando la instancia de Mesa como argumento.
     *  El método getDesgloseAprobados se encarga de calcular y organizar
     *  los resultados de la mesa.
     *
     * @return array Un Array qye contiene los resultados de la mesa.
     */
    public function getResultadosMesa(): array
    {
        return (new MesaService())->getDesgloseAprobados($this);
    }

}
