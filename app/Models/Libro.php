<?php

namespace App\Models;

use App\Services\LibroService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Libro extends Model
{
    use HasFactory;
    protected $table = 'libros';
    protected $fillable = ['mesa_id','llamado','numero','folio','orden'];

    public function mesa(): BelongsTo
    {
        return $this->belongsTo(Mesa::class,'mesa_id');
    }
    public function actasVolantes(): HasMany
    {
        return $this->hasMany(ActaVolante::class,'libro_id');
    }

    public function getActasVolantes(): Collection
    {
        return $this->actasVolantes()->get()->sortBy(function ($acta, $key) {
            return $acta->alumno->apellidos . ' ' . $acta->alumno->nombre;
        });

    }


    /**
     * Devuelve un array con los resultados de las actas volantes.
     * Array asociativo con claves 'aprobados', 'desaprobados', 'ausentes'
     * @return array
     */
    public function getResultadosActasVolantes(): array
    {
        return (new LibroService())->getDesgloseAprobados($this);
    }

}
