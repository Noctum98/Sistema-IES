<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'materia_id',
        'proceso_id',
        'porcentaje_final'
    ];

    public function materia(){
        return $this->belongsTo('App\Models\Materia','materia_id');
    }

    public function proceso(){
        return $this->belongsTo('App\Models\Proceso','proceso_id');
    }
 
}
