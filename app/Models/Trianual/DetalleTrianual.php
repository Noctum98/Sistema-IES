<?php

namespace App\Models\Trianual;

use App\Models\Equivalencias;
use App\Models\Estados;
use App\Models\Materia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /**
     * @return Model|BelongsTo|object|null
     */
    public function getMateria():Materia
    {
        return $this->belongsTo(Materia::class, 'materia_id')->first();
    }

    /**
     * @return BelongsTo|Model|object|null
     */
    public function getCondicion():Estados
    {
        return $this->belongsTo(Estados::class, 'condicion_id')->first();
    }

    /**
     * @return BelongsTo|Model|object|null
     */
    public function getEquivalencia():?Equivalencias
    {
        return $this->belongsTo(Equivalencias::class, 'equivalencia_id')->first();
    }

}
