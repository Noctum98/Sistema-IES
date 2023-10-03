<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CargaHoraria extends Model
{
    use HasFactory;
    protected $fillable = [
      'profesor_id',
      'materia_id',
      'cantidad_horas',
      'usuario_id'
    ];

    protected $table = 'workloads';

    /**
     * @return BelongsTo
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }
}
