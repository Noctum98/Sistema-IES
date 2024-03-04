<?php

namespace App\Models\Trianual;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Trianual\Trianual
 *
 * @property int $id
 * @property int $sede_id
 * @property int $carrera_id
 * @property int|null $cohorte
 * @property string|null $resolucion
 * @property int $alumno_id
 * @property string|null $matricula
 * @property string|null $libro
 * @property string|null $folio
 * @property int $operador_id
 * @property float|null $promedio
 * @property string|null $fecha_egreso
 * @property int|null $preceptor_id
 * @property int|null $coordinator_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Alumno $alumno
 * @property-read DetalleTrianual|null $detalleTrianual
 * @property-read Collection<int, ObservacionesTrianual> $observacionesTrianuales
 * @property-read int|null $observaciones_trianuales_count
 * @method static Builder|Trianual newModelQuery()
 * @method static Builder|Trianual newQuery()
 * @method static Builder|Trianual query()
 * @method static Builder|Trianual whereAlumnoId($value)
 * @method static Builder|Trianual whereCarreraId($value)
 * @method static Builder|Trianual whereCohorte($value)
 * @method static Builder|Trianual whereCoordinatorId($value)
 * @method static Builder|Trianual whereCreatedAt($value)
 * @method static Builder|Trianual whereFechaEgreso($value)
 * @method static Builder|Trianual whereFolio($value)
 * @method static Builder|Trianual whereId($value)
 * @method static Builder|Trianual whereLibro($value)
 * @method static Builder|Trianual whereMatricula($value)
 * @method static Builder|Trianual whereOperadorId($value)
 * @method static Builder|Trianual wherePreceptorId($value)
 * @method static Builder|Trianual wherePromedio($value)
 * @method static Builder|Trianual whereResolucion($value)
 * @method static Builder|Trianual whereSedeId($value)
 * @method static Builder|Trianual whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Trianual extends Model
{
    use HasFactory;

    /**
     * @var array Listado de atributos que se pueden asignar en masa
     */
    protected $fillable = [
        'sede_id',
        'carrera_id',
        'cohorte',
        'resolucion',
        'alumno_id',
        'matricula',
        'libro',
        'folio',
        'operador_id',
        'promedio',
        'fecha_egreso',
        'preceptor',
        'coordinator'
    ];


    /**
     * Obtiene las observaciones relacionadas con esta instancia
     *
     * @return HasMany
     */
    public function getObservaciones(): HasMany
    {
        return $this->hasMany(ObservacionesTrianual::class, 'trianual_id');
    }

    /**
     * Obtiene los detalles relacionados con esta instancia
     *
     * @return HasMany
     */
    public function getDetalle(): HasMany
    {
        return $this->hasMany(DetalleTrianual::class, 'trianual_id');
    }


    /**
     * Obtiene el alumno relacionado con esta instancia
     *
     * @return Model|BelongsTo|object|null
     */
    public function getAlumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id')->first();
    }

    /**
     * Obtiene la carrera relacionada con esta instancia
     *
     * @return Model|BelongsTo|object|null
     */
    public function getCarrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id', 'id')->first();
    }

    /**
     * Obtiene el operador basado en el `Id` provisto
     *
     * @param int $id
     * @return User|null
     */
    public function getOperador(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Obtiene las ObservacionesTrianuales relacionadas con esta instancia
     *
     * @return HasMany
     */
    public function observacionesTrianuales(): HasMany
    {
        return $this->hasMany(ObservacionesTrianual::class);
    }

    /**
     * Obtiene el objeto Alumno relacionado con esta instancia
     *
     * @return BelongsTo
     */
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }


    /**
     * Obtiene el objeto DetalleTrianual relacionado con esta instancia
     *
     * @return HasOne
     */
    public function detalleTrianual(): HasOne
    {
        return $this->hasOne(DetalleTrianual::class);
    }

    /**
     * Obtiene el `id` de esta instancia
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtiene las observaciones por año
     *
     * @param int $year
     * @return string
     */
    public function getObservacionesByYear(int $year): string
    {
        $observaciones = ObservacionesTrianual::where([
            'trianual_id' => $this->id,
            'year' => $year
        ])->first();

        if ($observaciones) {
            return $observaciones->observaciones;
        }
        return 'Sin Observaciones';


    }
}
