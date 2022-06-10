<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comision extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrera_id',
        'año',
        'nombre',
    ];

    public function profesores(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function procesos(): BelongsToMany
    {
        return $this->belongsToMany(Proceso::class)->withTimestamps();
    }

    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class)->withTimestamps();
    }

}
