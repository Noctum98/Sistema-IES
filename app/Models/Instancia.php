<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Instancia extends Model
{
    use HasFactory;
    protected $table = 'instancias';
    protected $fillable = ['nombre', 'tipo', 'general', 'estado', 'cierre', 'limite', 'segundo_llamado','año','year_nota'];

    public function sedes(): BelongsToMany
    {
        return $this->belongsToMany(Sede::class, 'instancia_sede', 'instancia_id', 'sede_id')->withTimestamps();
    }

    public function carreras(): BelongsToMany
    {
        return $this->belongsToMany(Carrera::class, 'instancia_carrera', 'instancia_id', 'carrera_id')->withTimestamps();
    }


    // Functions has

    public function hasSede($sede_id)
    {
        if ($this->sedes->where('id', $sede_id)->first()) {
            return true;
        }

        return false;
    }

    public function hasCarrera($carrera_id)
    {
        if ($this->carreras->where('id', $carrera_id)->first()) {
            return true;
        }

        return false;
    }

    public function hasAnySede($sedes)
    {
        $coincidencias = $sedes->intersect($this->sedes);

        // Si hay coincidencias, devuelve true; de lo contrario, devuelve false
        return $coincidencias->isNotEmpty();
    }
}
