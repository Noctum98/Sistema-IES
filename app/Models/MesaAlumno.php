<?php

namespace App\Models;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\MesaAlumno
 *
 * @property int $id
 * @property int|null $mesa_id
 * @property int|null $alumno_id
 * @property int|null $materia_id
 * @property int|null $segundo_llamado
 * @property int|null $instancia_id
 * @property string $nombres
 * @property string $apellidos
 * @property string $dni
 * @property string $correo
 * @property string $telefono
 * @property int $estado_baja
 * @property int|null $confirmado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $user_id
 * @property string|null $motivo_baja
 * @property Carbon|null $deleted_at
 * @property-read ActaVolante|null $acta_volante
 * @property-read Alumno|null $alumno
 * @property-read Instancia|null $instancia
 * @property-read Materia|null $materia
 * @property-read Mesa|null $mesa
 * @property-read User|null $user
 * @method static Builder|MesaAlumno newModelQuery()
 * @method static Builder|MesaAlumno newQuery()
 * @method static Builder|MesaAlumno onlyTrashed()
 * @method static Builder|MesaAlumno query()
 * @method static Builder|MesaAlumno whereAlumnoId($value)
 * @method static Builder|MesaAlumno whereApellidos($value)
 * @method static Builder|MesaAlumno whereConfirmado($value)
 * @method static Builder|MesaAlumno whereCorreo($value)
 * @method static Builder|MesaAlumno whereCreatedAt($value)
 * @method static Builder|MesaAlumno whereDeletedAt($value)
 * @method static Builder|MesaAlumno whereDni($value)
 * @method static Builder|MesaAlumno whereEstadoBaja($value)
 * @method static Builder|MesaAlumno whereId($value)
 * @method static Builder|MesaAlumno whereInstanciaId($value)
 * @method static Builder|MesaAlumno whereMateriaId($value)
 * @method static Builder|MesaAlumno whereMesaId($value)
 * @method static Builder|MesaAlumno whereMotivoBaja($value)
 * @method static Builder|MesaAlumno whereNombres($value)
 * @method static Builder|MesaAlumno whereSegundoLlamado($value)
 * @method static Builder|MesaAlumno whereTelefono($value)
 * @method static Builder|MesaAlumno whereUpdatedAt($value)
 * @method static Builder|MesaAlumno whereUserId($value)
 * @method static Builder|MesaAlumno withTrashed()
 * @method static Builder|MesaAlumno withoutTrashed()
 * @mixin Eloquent
 */
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
