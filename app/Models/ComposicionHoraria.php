<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ComposicionHoraria extends Model
{
    use HasFactory;

    protected $table = 'hourlies_compositions';

    protected $fillable = [
        'carga_principal_id',
        'cantidad_horas',
        'is_principal',
        'usuario_id',
        'compositable_type',
        'compositable_id'
    ];

    public function compositable(): MorphTo
    {
        return $this->morphTo();
    }

}
