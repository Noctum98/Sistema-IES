<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaModular extends Model
{
    use HasFactory;
    protected $table = 'asistencias_modulares';

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function asistencia(){
        return $this->belongsTo('App\Models\Asistencia','asstencia_id');
    }
}
