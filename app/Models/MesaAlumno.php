<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MesaAlumno extends Model
{
    use HasFactory;
    protected $table = 'mesa_alumno';
    protected $fillable = [
        'mesa_id','alumno_id','materia_id','instancia_id','segundo_llamado',
        'nombres','apellidos','dni','correo','telefono','estado_baja','user_id',
        'motivo_baja'
    ];

    public function materia(){
        return $this->belongsTo('App\Models\Materia','materia_id');
    }
    public function mesa(){
        return $this->belongsTo('App\Models\Mesa','mesa_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');

    }

    public function alumno(){
        return $this->belongsTo(Alumno::class,'alumno_id');

    }

    public function instancia()
    {
        return $this->belongsTo(Instancia::class,'instancia_id');
    }

    public function acta_volante(): HasOne
    {
        return $this->hasOne(ActaVolante::class);
    }

    // Funciones adicionales

    public function alumnoByDni($dni)
    {
        $alumno = Alumno::where('dni',$dni)->first();

        return $alumno;
    }
}
