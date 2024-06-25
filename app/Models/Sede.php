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


}
