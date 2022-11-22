<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ModuloProfesor extends Model
{
    use HasFactory;

    protected $table = "modulo_profesor";

    protected $fillable = ["user_id", "modulo_id"];

    public $timestamps = false;

    /**
     * Los usuarios (profesores) que puede tener un cargo_materia.
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'modulo_id', 'id', 'cargo_materia');
    }

    /**
     * El cargoMateria Módulo Profesor.
     */
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'modulo_id', 'id', 'cargo_materia');
    }
}
