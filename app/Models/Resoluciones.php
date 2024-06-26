<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resoluciones extends Model
{
    use SoftDeletes, HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string)Uuid::uuid4();
        });
    }

    protected $fillable = [
        'name',
        'title',
        'duration',
        'resolution',
        'tipo_carrera_id',
        'vaccines',
        'estado_resoluciones_id',
        'modality'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function estadoResoluciones(): BelongsTo
    {
        return $this->belongsTo(EstadoResoluciones::class);
    }

    public function tipoCarrera(): BelongsTo
    {
        return $this->belongsTo(TipoCarrera::class);
    }

    /**
     * @return HasMany
     */
    public function carreras(): HasMany
    {
        return $this->hasMany(Carrera::class, 'resolucion_id');
    }

    /**
     * @return HasMany
     */
    public function masterMaterias(): HasMany
    {
        return $this->hasMany(MasterMateria::class, 'resoluciones_id');
    }
}
