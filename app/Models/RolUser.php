<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolUser extends Model
{
    use HasFactory;
    protected $table = 'rol_user';
    protected $fillable = [
        'rol_id',
        'user_id',
        'carrera_id',
        'materia_id'
    ];

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class,'rol_id');
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
