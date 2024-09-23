<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MesaFolio extends Model
{
    use SoftDeletes, HasFactory, UuidTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mesa_folios';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'aprobados',
        'ausentes',
        'coordinador_id',
        'desaprobados',
        'fecha',
        'libro_digital_id',
        'master_materia_id',
        'mesa_id',
        'folio',
        'llamado',
        'operador_id',
        'presidente_id',
        'turno',
        'vocal_1_id',
        'vocal_2_id',
        'year_nota'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fecha' => 'date',
    ];


    /**
     * Get the User for this model.
     *
     * @return BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vocal_2_id', 'id');
    }


    /**
     * @return BelongsTo
     */
    public function LibroDigital(): BelongsTo
    {
        return $this->belongsTo(LibroDigital::class, 'libro_digital_id', 'id');
    }

    /**
     * Get the MasterMateria for this model.
     *
     * @return BelongsTo
     */
    public function masterMateria(): BelongsTo
    {
        return $this->belongsTo(MasterMateria::class, 'master_materia_id', 'id');
    }

    /**
     * Get the Mesa for this model.
     *
     * @return BelongsTo
     */
    public function mesa(): BelongsTo
    {
        return $this->belongsTo(Mesa::class, 'mesa_id', 'id');
    }

    /**
     * Set the fecha.
     *
     * @param string $value
     * @return void
     */
    public function setFechaAttribute(string $value)
    {
        $this->attributes['fecha'] = !empty($value) ? DateTime::createFromFormat('Y-m-d', $value) : null;
    }

    /**
     * Get fecha in array format
     *
     * @param string $value
     * @return string
     */
    public function getFechaAttribute(string $value): string
    {

        return $value;

//        return DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y');
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

    public function presidente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'presidente_id');
    }

    public function vocal1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vocal_1_id');
    }

    public function vocal2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vocal_2_id');
    }

    public function coordinador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinador_id');
    }

    public function libroRomanos(): string
    {
        return $this->LibroDigital()->first()->romanos;
    }

    public function libroNumber(): string
    {
        return $this->LibroDigital()->first()->number;
    }


    public function folioNotas(): HasMany
    {
        return $this->hasMany(FolioNota::class, 'mesa_folio_id')->orderBy('orden');
    }

    /**
     * @return int|mixed|string
     */
    public function getYearNota()
    {
        $yearNota = $this->year_nota;
        if ($yearNota) {
            return $yearNota;
        }
        $yearNota = $this->mesa->instancia->year_nota ?? null;

        if (!$yearNota && $this->fecha >= '2024-05-01') {
            $yearNota = '2024';
        }
        $this->year_nota = $yearNota??2021;
        $this->save();


        return $this->year_nota;


    }

}
