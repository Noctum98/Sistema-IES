<?php

namespace App\Models;

use Faker\Provider\Uuid;
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
        'estados_id',
    ];

    public function estados(): BelongsTo
    {
        return $this->belongsTo(Estados::class);
    }

    public function tipoCarrera(): BelongsTo
    {
        return $this->belongsTo(TipoCarrera::class);
    }
}
