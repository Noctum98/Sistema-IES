<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
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
    ];

    public function operador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operador_id', 'id' );
    }

    public function actaVolante(): BelongsTo
    {
        return $this->belongsTo(ActaVolante::class);
    }

    public function mesaFolio(): BelongsTo
    {
        return $this->belongsTo(MesaFolio::class);
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }
}
