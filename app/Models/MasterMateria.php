<?php

namespace App\Models;


use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMateria extends Model
{
    use SoftDeletes, HasFactory, UuidTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'master_materias';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'name',
        'year',
        'field_stage',
        'delayed_closing',
        'resoluciones_id',
        'regimen_id',
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
    protected $casts = [];




    public function resoluciones(): BelongsTo
    {
        return $this->belongsTo(Resoluciones::class);
    }

    public function regimen(): BelongsTo
    {
        return $this->belongsTo(Regimen::class);
    }

    /**
     * @return HasMany
     */
    public function agrupadaMaterias(): HasMany
    {
        return $this->hasMany(AgrupadaMateria::class, 'master_materia_id');
    }

    /**
     * @return HasMany
     */
    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class, 'master_materia_id');
    }
}
