<?php

namespace App\Models;

use App\Services\CargoService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargos';
    protected $fillable = ['nombre','carrera_id'];
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

    public function ponderacion($cargo_id,$materia_id)
    {
        $ponderacion = new CargoService();

        return $ponderacion->getPonderacion($cargo_id, $materia_id);
    }

    public function calificacionesCargo()
    {
        return $this->hasMany(Calificacion::class);
//        return $this->belongsToMany(User::class,'comision_profesor','comision_id','profesor_id')->withTimestamps();
    }
}
