<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preinscripcion extends Model
{
    use HasFactory;
    protected $table = 'preinscripciones';

    public function carrera(){
        return $this->belongsTo('App\Models\Carrera','carrera_id');
    }
}
