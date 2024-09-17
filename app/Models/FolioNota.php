<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FolioNota extends Model
{
    use SoftDeletes, HasFactory, UuidTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'folio_notas';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'orden',
        'permiso',
        'escrito',
        'oral',
        'definitiva',
        'operador_id',
        'acta_volante_id',
        'mesa_folio_id',
        'alumno_id',
        'cohorte'
    ];

    /**
     * @return BelongsTo
     */
    public function operador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operador_id', 'id');
    }


    /**
     * @return BelongsTo
     */
    public function actaVolante(): BelongsTo
    {
        return $this->belongsTo(ActaVolante::class);
    }

    /**
     * @return BelongsTo
     */
    public function mesaFolio(): BelongsTo
    {
        return $this->belongsTo(MesaFolio::class, 'mesa_folio_id', 'id');
    }


    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }


    /**
     * @return BelongsTo
     */
    public function actasVolante(): BelongsTo
    {
        return $this->belongsTo(ActaVolante::class, 'acta_volante_id', 'id');
    }

    /**
     * Get created_at in array format
     *
     * @param string $value
     * @return string
     */
    public function getCreatedAtAttribute(string $value): string
    {
        return DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y H:i:s');
    }

    /**
     * Get deleted_at in array format
     *
     * @param string|null $value
     * @return string|null
     */
    public function getDeletedAtAttribute(string $value = null): ?string
    {
        if (!$value) {
            return $value;
        }
        return DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y H:i:s');
    }


    /**
     * Get updated_at in array format
     *
     * @param string $value
     * @return string
     */
    public function getUpdatedAtAttribute(string $value): string
    {
        return DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y H:i:s');
    }

    public function getCohorte()
    {
        $cohorte = $this->cohorte;

        if (!$cohorte) {
            $actaVolante = ActaVolante::find($this->actasVolante());
            if ($actaVolante) {
                $cohorte = $actaVolante->inscripcionCarrera->cohorte;
            }else{
                $cohorte = $this->alumno()->first()->cohorte;
            }
            if($cohorte) {
                $this->cohorte = $cohorte;
                $this->save();
            }
        }

        return $cohorte;
    }


}

