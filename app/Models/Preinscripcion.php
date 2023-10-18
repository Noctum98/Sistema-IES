<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preinscripcion extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table ='preinscripciones';
    protected $fillable = [
       'nombres',
       'carrera_id',
       'apellidos',
       'dni',
       'cuil',
       'fecha',
       'email',
       'edad',
       'nacionalidad',
       'domicilio',
       'residencia',
       'telefono',
       'escolaridad',        
       'condicion_s',
       'escuela_s',
       'materias_s',
       'conexion',
       'trabajo',
       'estado',
       'timecheck',
       'dni_archivo',
       'dni_archivo_2',
       'comprobante',
       'certificado_archivo',
       'certificado_archivo_2',
       'primario',
       'curriculum',
       'ctrabajo',
       'nota',
       'articulo_septimo',
       'gdrive_storage'
    ];

    public function carrera(){
        return $this->belongsTo('App\Models\Carrera','carrera_id');
    }
}
