<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CargoMateria extends Model
{
    use HasFactory;
    protected $table = 'cargo_materia';
    protected $fillable = ['ponderacion'];

    /**
     * Los usuarios (profesores) que puede tener un cargo_materia.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'modulo_profesor', 'modulo_id');
    }


}
