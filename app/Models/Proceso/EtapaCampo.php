<?php

namespace App\Models\Proceso;

use App\Models\Proceso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtapaCampo extends Model
{
    use HasFactory;
    protected $table = 'etapa_campo';
    protected $fillable = ['proceso_id','primera_evaluacion','segunda_evaluacion','tercera_evaluacion','asistencia','porcentaje_final'];

    public function proceso(): BelongsTo
    {
        return $this->belongsTo(Proceso::class,'proceso_id');
    }
}
