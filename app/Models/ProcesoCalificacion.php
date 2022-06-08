<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoCalificacion extends Model
{
    use HasFactory;

    protected $table = "proceso_calificacion";
    protected $fillable = ['proceso_id','calificacion_id','nota','porcentaje'];

}
