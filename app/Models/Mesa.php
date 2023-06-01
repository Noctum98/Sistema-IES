<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mesa extends Model
{
    use HasFactory;

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

    public function materia()
    {
        return $this->belongsTo('App\Models\Materia', 'materia_id');
    }

    public function mesa_inscriptos_total()
    {
        return $this->hasMany('App\Models\MesaAlumno');
    }

    public function mesa_inscriptos()
    {
        return $this->hasMany('App\Models\MesaAlumno')->where('estado_baja', false);
    }


    public function mesa_inscriptos_primero($orden = 1)
    {
        $take = 25;
        $skip = $take * ($orden - 1);

        return $this->hasMany('App\Models\MesaAlumno')
            ->where(['estado_baja' => false, 'segundo_llamado' => false])
            ->skip($skip)
            ->take($take);
    }

    public function mesa_inscriptos_segundo($orden = 1)
    {
        $take = 25;
        $skip = $take * ($orden - 1);

        return $this->hasMany('App\Models\MesaAlumno')
            ->where(['estado_baja' => false, 'segundo_llamado' => true])
            ->skip($skip)
            ->take($take);
    }
    public function bajas_primero()
    {
        return $this->hasMany('App\Models\MesaAlumno')->where(['estado_baja' => true, 'segundo_llamado' => false]);
    }

    public function bajas_segundo()
    {
        return $this->hasMany('App\Models\MesaAlumno')->where(['estado_baja' => true, 'segundo_llamado' => true]);
    }

    public function instancia()
    {
        return $this->belongsTo(Instancia::class, 'instancia_id');
    }

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

    public function libro($llamado, $orden = 1)
    {
        return Libro::where(['llamado' => $llamado, 'orden' => $orden, 'mesa_id' => $this->id])->first();
    }

    public function folios()
    {
        $folios = 1;
        if ($this->mesa_inscriptos->count() > 25) {
            $division_primero = $this->mesa_inscriptos->count() / 25;
            $folios = ceil($division_primero);
        }

        return $folios;
    }

    public function mesa_inscriptos_props(int $prop = null, $orden = 1)
    {
        if ($this->instancia->tipo == 0) {
            if ($prop == 1) {
                return $this->mesa_inscriptos_primero($orden);
            }
            if ($prop == 2) {
                return $this->mesa_inscriptos_segundo($orden);
            }
            return $this->mesa_inscriptos();
        } else {
            $inscriptos = $this->mesa_inscriptos()->where('confirmado',true);

            $take = 25;
            $skip = $take * ($orden - 1);

            if ($prop == 1) {
                return $inscriptos->skip($skip)->take($take)->orderBy('apellidos','ASC')->get();
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
            ->orderBy('sedes.nombre', 'asc')
            //            ->orderBy('materias.nombre','asc')
            //            ->getQuery()->dd();
            ->get();
    }
}
