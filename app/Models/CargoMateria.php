<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CargoMateria extends Model
{
    use HasFactory;
    protected $table = 'cargo_materia';
    protected $fillable = ['ponderacion', 'carga_tfi'];

    /**
     * Los usuarios (profesores) que puede tener un cargo_materia.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'modulo_profesor', 'modulo_id');
    }

    /**
     * La materia de un cargo materia.
     */
    public function materia()
    {
        return $this->hasOne(Materia::class, 'id', 'materia_id');
    }

    /**
     * La materia de un cargo materia.
     */
    public function cargo()
    {
        return $this->hasOne(Cargo::class, 'id', 'cargo_id');
    }





}
