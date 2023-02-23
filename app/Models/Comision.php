<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comision extends Model
{
    use HasFactory;

    protected $table = 'comisiones';

    protected $fillable = [
        'carrera_id',
        'año',
        'nombre',
        'ciclo_lectivo'
    ];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class,'carrera_id');
    }

    public function profesores(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'comision_profesor','comision_id','profesor_id')->withTimestamps();
    }
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Alumno::class);
    }
    public function procesos(): BelongsToMany
    {
        return $this->belongsToMany(Proceso::class)->withTimestamps();
    }

    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class)->withTimestamps();
    }



    //Has Relations
    public function hasProfesor($profesor_id){
        if ($this->profesores->where('id', $profesor_id)->first()) {
            return true;
        }
        return false;
    }


}
