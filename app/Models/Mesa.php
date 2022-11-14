<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mesa extends Model
{
    use HasFactory;
    protected $fillable = [
        'instancia_id',
        'materia_id',
        'comision_id',
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
        'presidente_id',
        'primer_vocal_id',
        'segundo_vocal_id',
        'presidente_segundo_id',
        'primer_vocal_segundo_id',
        'segundo_vocal_segundo_id',
        'libro',
        'folio'
    ];

    public function materia(){
        return $this->belongsTo('App\Models\Materia','materia_id');
    }

    public function mesa_inscriptos(){
        return $this->hasMany('App\Models\MesaAlumno');
    }

    public function mesa_inscriptos_primero(){
        return $this->hasMany('App\Models\MesaAlumno')->where('segundo_llamado',false); 
    }

    public function mesa_inscriptos_segundo(){
        return $this->hasMany('App\Models\MesaAlumno')->where('segundo_llamado',true);
    }

    public function mesa_inscriptos_props(int $prop = null): HasMany
    {
        if($prop == 1){
            return $this->mesa_inscriptos_primero();
        }
        if($prop == 2){
            return $this->mesa_inscriptos_segundo();
        }
        return $this->mesa_inscriptos();
    }

    public function bajas_primero(){
        return $this->hasMany('App\Models\MesaAlumno')->where(['estado_baja'=>true,'segundo_llamado'=>false]);
    }

    public function bajas_segundo(){
        return $this->hasMany('App\Models\MesaAlumno')->where(['estado_baja'=>true,'segundo_llamado'=>true]);
    }

    public function instancia(){
        return $this->belongsTo(Instancia::class,'instancia_id');
    }

    public function comision(): BelongsTo
    {
        return $this->belongsTo(Comision::class,'comision_id');
    }

    public function presidente(): BelongsTo
    {
        return $this->belongsTo(User::class,'presidente_id');
    }

    public function primer_vocal(): BelongsTo
    {
        return $this->belongsTo(User::class,'primer_vocal_id');
    }

    public function segundo_vocal(): BelongsTo
    {
        return $this->belongsTo(User::class,'segundo_vocal_id');
    }

    public function presidente_segundo(): BelongsTo
    {
        return $this->belongsTo(User::class,'presidente_segundo_id');
    }

    public function primer_vocal_segundo(): BelongsTo
    {
        return $this->belongsTo(User::class,'primer_vocal_segundo_id');
    }

    public function segundo_vocal_segundo(): BelongsTo
    {
        return $this->belongsTo(User::class,'segundo_vocal_segundo_id');
    }
}
