<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\AlumnoCarrera
 *
 * @property int $id
 * @property int $alumno_id
 * @property int $carrera_id
 * @property int $año
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $ciclo_lectivo
 * @method static Builder|AlumnoCarrera newModelQuery()
 * @method static Builder|AlumnoCarrera newQuery()
 * @method static Builder|AlumnoCarrera query()
 * @method static Builder|AlumnoCarrera whereAlumnoId($value)
 * @method static Builder|AlumnoCarrera whereAño($value)
 * @method static Builder|AlumnoCarrera whereCarreraId($value)
 * @method static Builder|AlumnoCarrera whereCicloLectivo($value)
 * @method static Builder|AlumnoCarrera whereCreatedAt($value)
 * @method static Builder|AlumnoCarrera whereId($value)
 * @method static Builder|AlumnoCarrera whereUpdatedAt($value)
 * @mixin Eloquent
 */
class AlumnoCarrera extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'alumno_carrera';
    protected $fillable = [
        'alumno_id',
        'carrera_id',
        'año',
        'ciclo_lectivo',
        'fecha_primera_acreditacion',
        'fecha_ultima_acreditacion',
        'cohorte',
        'legajo_completo',
        'aprobado',
        'regularidad'
    ];

    public function getCarrera($alumno_id, $carrera_id)
    {
        $alumno_carrera = self::where([
            'alumno_id' => $alumno_id,
            'carrera_id' => $carrera_id
        ])->first();

        if ($alumno_carrera) {
            return $alumno_carrera;
        }
        return false;

    }

    public function carrera()
    {
        return Carrera::find($this->carrera_id);
    }

    /**
     * @return BelongsTo
     */
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id')->orderBy('apellidos', 'Asc');
    }
}
