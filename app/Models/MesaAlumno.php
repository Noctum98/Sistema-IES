<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MesaAlumno extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'mesa_alumno';
    protected $fillable = [
        'mesa_id', 'alumno_id', 'materia_id', 'instancia_id', 'segundo_llamado',
        'nombres', 'apellidos', 'dni', 'correo', 'telefono', 'estado_baja', 'user_id',
        'motivo_baja'
    ];

    public function materia()
    {
        return $this->belongsTo('App\Models\Materia', 'materia_id');
    }

    public function mesa()
    {
        return $this->belongsTo('App\Models\Mesa', 'mesa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');

    }

    public function instancia()
    {
        return $this->belongsTo(Instancia::class, 'instancia_id');
    }

    public function acta_volante(): HasOne
    {
        return $this->hasOne(ActaVolante::class);
    }

    // Funciones adicionales

    public function alumnoByDni($dni)
    {
        return Alumno::where('dni', $dni)->first();
    }

    /**
     * @return string <i>Fecha de la mesa de la nota promedio tomada</i>
     * @throws Exception
     */
    public function fechaMesa(): string
    {
        /** @var Mesa $mesa */
        $mesa = $this->mesa()->first();
        if($mesa) {
            $fecha = $mesa->fecha;
            if ($this->segundo_llamado) {
                $fecha = $mesa->fecha_segundo;
            }
            $fecha = new \Datetime($fecha);

            return $fecha->format('d-m-Y');
        }

        return 'Sin mesa';

    }
}
