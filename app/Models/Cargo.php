<?php

namespace App\Models;

use App\Services\CargoService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargos';
    protected $fillable = ['nombre','carrera_id', 'tipo_materia_id'];
    /**
     * @var CargoService
     */
    private $cargoService;



    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class)->withTimestamps();
    }

    public function carrera()
    {
        return $this->belongsTo('App\Models\Carrera','carrera_id');
    }

    public function tipoMateria(): BelongsTo
    {
        return $this->belongsTo(TipoMateria::class,'tipo_materia_id');
    }

    public function ponderacion($materia_id)
    {
        $ponderacion = new CargoService();

        return $ponderacion->getPonderacion($this->id, $materia_id);
    }

    public function calificacionesCargo(): HasMany
    {
        return $this->hasMany(Calificacion::class);

    }

    /**
     *
     * @param $materia_id
     * @return Collection
     */
    public function calificacionesTPByCargoByMateria($materia_id): Collection
    {
        return $this->hasMany(Calificacion::class)
            ->select('calificaciones.*')
            ->join('tipo_calificaciones', 'calificaciones.tipo_id','tipo_calificaciones.id')
            ->where('calificaciones.materia_id',$materia_id)
            ->where('tipo_calificaciones.descripcion','=', 2)
            ->get();
    }

    public function calificacionesParcialByCargoByMateria($materia_id): Collection
    {
        return $this->hasMany(Calificacion::class)
            ->select('calificaciones.*')
            ->join('tipo_calificaciones', 'calificaciones.tipo_id','tipo_calificaciones.id')
            ->where('calificaciones.materia_id',$materia_id)
            ->where('tipo_calificaciones.descripcion','=', 1)
            ->get()
            ;
    }

    public function calificacionesIFByCargoByMateria($materia_id): Collection
    {
        return $this->hasMany(Calificacion::class)
            ->select('calificaciones.*')
            ->join('tipo_calificaciones', 'calificaciones.tipo_id','tipo_calificaciones.id')
            ->where('calificaciones.materia_id',$materia_id)
            ->where('tipo_calificaciones.descripcion','=', 3)
            ->get();
    }

    public function tipoCargo(): BelongsTo
    {
        return $this->belongsTo(TipoMateria::class,'tipo_materia_id');
    }
}
