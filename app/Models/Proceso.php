<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proceso extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'materia_id',
        'estado'
    ];

    public function materia(): BelongsTo
    {
        return $this->belongsTo('App\Models\Materia','materia_id');
    }
    public function alumno(): BelongsTo
    {
        return $this->belongsTo('App\Models\Alumno','alumno_id');
    }
    public function asistencia($id)
    {
        return Asistencia::where('proceso_id',$id)->first();
    }
}
