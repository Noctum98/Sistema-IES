<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;
    protected $fillable = [
        'instancia_id',
        'materia_id',
        'fecha',
        'cierre',
        'fecha_segundo',
        'cierre_segundo',
        'presidente',
        'primer_vocal',
        'segundo_vocal',
        'presidente_segundo',
        'primer_vocal_segundo',
        'segundo_vocal_segundo',
        'libro',
        'folio'
    ];

    public function materia(){
        return $this->belongsTo('App\Models\Materia','materia_id');
    }

    public function mesa_inscriptos(){
        return $this->hasMany('App\Models\MesaAlumno');
    }

    public function instancia(){
        return $this->belongsTo(Instancia::class,'instancia_id');
    }
}
