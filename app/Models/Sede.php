<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sede extends Model
{
    use HasFactory;

    protected $fillable = [
      'nombre', 'ubicacion'
    ];

    public function carreras(): HasMany
    {
        return $this->hasMany(Carrera::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function getMesas($instancia_id = null)
    {
        $mesas = Mesa::whereHas('materia',function($query) use ($instancia_id){
            if($instancia_id)
            {
                $query->where('instancia_id',$instancia_id);
            }
            $query->whereHas('carrera',function($query){
                $query->where('sede_id',$this->id);
            });
        })->get();

        return $mesas;
    }


}
