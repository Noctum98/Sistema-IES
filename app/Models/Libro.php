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
            if(!$acta->alumno){
                dd($acta);
            }
            return $acta->alumno->apellidos . ' ' . $acta->alumno->nombre;
        });

    }

    public function obtenerActasVolantes()
    {
        $actasVolantes = $this->actasVolantes;
        if($actasVolantes->isEmpty()){
            $mesa = $this->mesa;
            $actasVolantes = $mesa->actasVolantes;
            foreach ($actasVolantes as $acta) {
                $acta->libro_id = $this->id;
                $acta->save();
            }
        }

        return $actasVolantes;
    }

    public function obtenerActasVolantesByMesaAlumno()
    {
        $actasVolantes = $this->actasVolantes;
        if($actasVolantes->isEmpty()){
            $llamado = $this->llamado;

            $segundoLlamado = false;
            if($llamado === "2"){
                $segundoLlamado = true;
            }

            $mesaAlumno = MesaAlumno::where([
                'mesa_id' => $this->mesa->id,
                'segundo_llamado' => $segundoLlamado
            ])->pluck('id');

            $actasVolantes = ActaVolante::whereIn('mesa_alumno_id', $mesaAlumno)->get()
                ->sortBy(function ($acta, $key) {
                    return $acta->alumno->apellidos . ' ' . $acta->alumno->nombre;
                })
            ;

            foreach ($actasVolantes as $acta) {
                $acta->libro_id = $this->id;
                $acta->save();
            }
        }

        return $actasVolantes;
    }


    /**
     * Devuelve un array con los resultados de las actas volantes.
     * Array asociativo con claves 'aprobados', 'desaprobados', 'ausentes'
     * @param bool $inscripciones
     * @return array
     */
    public function getResultadosActasVolantes(bool $inscripciones = false): array
    {
        return (new LibroService())->getDesgloseAprobados($this, $inscripciones);
    }

}
