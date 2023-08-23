<?php

namespace App\Models;

use App\Services\CargoService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use phpDocumentor\Reflection\Types\Null_;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargos';
    protected $fillable = ['nombre','carrera_id', 'tipo_materia_id'];

    const IDENTIFICADOR_TIPO_PRACTICA_PROFESIONAL = 1;
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

    /**
     * @param $materia_id
     * @return int|mixed
     */
    public function ponderacion($materia_id)
    {
        $ponderacion = new CargoService();

        return $ponderacion->getPonderacion($this->id, $materia_id);
    }

    public function responsableTFI($materia_id)
    {
        $responsable_tfi = new CargoService();

        return $responsable_tfi->getResponsableTFI($this->id, $materia_id);
    }

    public function relacionCargoModulo($materia_id)
    {
        $relation = new CargoService();

        return $relation->getRelacionCargoModulo($this->id, $materia_id);
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
    public function calificacionesTPByCargoByMateria($materia_id, $ciclo_lectivo = null): Collection
    {
        if(!$ciclo_lectivo){
            $ciclo_lectivo = date('Y');
        }
        return $this->hasMany(Calificacion::class)
            ->select('calificaciones.*')
            ->join('tipo_calificaciones', 'calificaciones.tipo_id','tipo_calificaciones.id')
            ->where('calificaciones.materia_id',$materia_id)
            ->where('calificaciones.ciclo_lectivo',$ciclo_lectivo)
            ->where('tipo_calificaciones.descripcion','=', 2)
            ->get();
    }

    public function calificacionesParcialByCargoByMateria($materia_id, $ciclo_lectivo = null): Collection
    {
        if(!$ciclo_lectivo){
            $ciclo_lectivo = date('Y');
        }
        return $this->hasMany(Calificacion::class)
            ->select('calificaciones.*')
            ->join('tipo_calificaciones', 'calificaciones.tipo_id','tipo_calificaciones.id')
            ->where('calificaciones.materia_id',$materia_id)
            ->where('calificaciones.cargo_id',$this->id)
            ->where('calificaciones.ciclo_lectivo',$ciclo_lectivo)
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

    public function isPracticaProfesional(): bool
    {
        if(!$this->tipoCargo()->first()){
            return false;
        }
       return ( self::IDENTIFICADOR_TIPO_PRACTICA_PROFESIONAL == $this->tipoCargo()->first()->identificador);
    }

    public function obtenerProcesoCargo(int $proceso)
    {
        return ProcesosCargos::where([
            'cargo_id' => $this->id,
            'proceso_id' => $proceso
        ])->first();
    }

    public function profesores()
    {
        $users = $this->users()->get();

        $profesores = '';

        if($users){
            foreach ($users as $user){
                $profesores .= $user->apellido . ', '. $user->nombre . ' - ' ;
            }
        }
        return $profesores;
    }

    public function getCargoProceso($proceso_id)
    {
        return CargoProceso::where([
            'cargo_id' => $this->id,
            'proceso_id' => $proceso_id
        ])->first();
    }
}
