<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargos';
    protected $fillable = ['nombre','carrera_id'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class)->withTimestamps();
    }

    public function carrera()
    {
        return $this->belongsTo('App\Models\Carrera','carrera_id');
    }
}
