<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnoParcial extends Model
{
    use HasFactory;
    protected $table = 'alumno_parcial';

    public function alumno(){
        return $this->belongsTo('App\Models\Alumno','alumno_id');
    }
}
