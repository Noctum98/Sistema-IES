<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class AgrupadaMateria extends Model
{
    use SoftDeletes, HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'correlatividad_agrupada_id',
        'master_materia_id',
        'user_id',
        'disabled',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }

    public function correlatividadAgrupada(): BelongsTo
    {
        return $this->belongsTo(CorrelatividadAgrupada::class);
    }

    public function masterMateria(): BelongsTo
    {
        return $this->belongsTo(MasterMateria::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
