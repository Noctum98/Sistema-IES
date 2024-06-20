<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class LibroDigital extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'libros_digitales';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} =  Uuid::uuid4()->toString();
        });
    }


    protected $fillable = [
        'acta_inicio',
        'number',
        'resoluciones_id',
        'fecha_inicio',
        'sede_id',
        'resolucion_original',
        'operador_id',
        'observaciones',
        'user_id',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
    ];

    public function resoluciones(): BelongsTo
    {
        return $this->belongsTo(Resoluciones::class);
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function operador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operador_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
