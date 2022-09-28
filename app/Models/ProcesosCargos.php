<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcesosCargos extends Model
{
    use HasFactory;

    protected $table = "procesos_cargos";
    protected $fillable = [
        'proceso_id',
        'cargo_id',
        'cierre',
        'operador_id',
    ];

    protected $dates = [
        'cierre'
    ];


    public function isClose()
    {
        return (bool)optional($this->cierre)->lte(now());
    }

    public function proceso(): BelongsTo
    {
        return $this->belongsTo(Proceso::class);
    }

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }


}
