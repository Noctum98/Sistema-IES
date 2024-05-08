<?php

namespace App\Models\Parameters;

use App\Models\Materia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CicloLectivoEspecial extends Model
{
    use HasFactory;
    protected $table = 'ciclo_lectivo_especiales';
    protected $fillable = [
        'ciclo_lectivo_id',
        'cierre_ciclo',
        'materia_id',
        'sede_id',
        'regimen'
    ];

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id', 'id');
    }




}
