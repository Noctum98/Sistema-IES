<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class CorrelatividadAgrupada extends Model
{
    use SoftDeletes, HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'identifier',
        'resoluciones_id',
        'user_id',
        'disabled',
        'cantidad_min'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }

    public function resoluciones(): BelongsTo
    {
        return $this->belongsTo(Resoluciones::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agrupadaMaterias(): HasMany
    {
        return $this->hasMany(AgrupadaMateria::class, 'correlatividad_agrupada_id');
    }
}
