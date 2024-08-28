<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibroPapel extends Model
{
    use SoftDeletes, HasFactory, UuidTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'libros_papeles';

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
        'number',
        'acta_inicio',
        'operador_inicio',
        'fecha_inicio',
        'sede_id',
        'user_id',
        'roman',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
    ];

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
