<?php

namespace App\Models\Trianual;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetalleTrianual extends Model
{
    use HasFactory;

    protected $fillable = [
        'trianual_id',
        'materia_id',
        'condicion_id',
        'equivalencia_id',
        'proceso_id',
        'operador_id',
        'recursado',
    ];

    public function getAcreditacion(): HasMany
    {
        return $this->hasMany(Acreditacion::class, 'detalle_trianual_id');
    }

}
