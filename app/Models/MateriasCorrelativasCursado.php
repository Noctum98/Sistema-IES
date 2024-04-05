<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MateriasCorrelativasCursado extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'materia_id',
        'previa_id',
        'operador_id',
    ];
    protected function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
    protected function materias(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    protected function previa(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'previa_id');
    }

    protected function operador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operador_id');
    }
}
