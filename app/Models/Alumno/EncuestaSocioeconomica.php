<?php

namespace App\Models\Alumno;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EncuestaSocioeconomica extends Model
{
    use HasFactory;
    protected $table = 'encuestas_socioeconomicas';
    protected $fillable = [
        'alumno_id',
        'nombre_preferido',
        'identidad_genero',
        'identidad_genero_otra',
        'edad_encuesta',
        'empresa_telefono',
        'acceso_internet',
        'herramientas_tecnologicas',
        'vinculacion_ciclo',
        'condicion_laboral',
        'lugar_y_horario_trabajo',
        'trabajo_relacionado',
        'jefe_hogar',
        'hijos_a_cargo',
        'cantidad_hijos',
        'edad_hijos',
        'obra_social',
        'subsidios',
        'comprobanete_progresar',
        'distancia_ies',
        'transporte_utilizado',
        'cantidad_convivientes',
        'cantidad_lugares_dormir',
        'ingresos_mensuales',
        'condicion_laboral_jefe_hogar',
        'maximo_nivel_educativo_padre',
        'maximo_nivel_educativo_madre',
        'familia_enfermedad',
        'familia_discapacidad',
        'familia_obra_social',
        'desalojo_vivienda',
        'violencia_intrafamiliar',
        'violencia_genero',
        'fallecimiento_conviviente',
        'situaciones_consumo',
        'accidentes_graves',
        'condenas_extramuros',
        'embargo_judicial',
        'problemas_judiciales',
        'agua_potable',
        'luz_electrica',
        'gas_envasado',
        'gas_natural',
        'tenencia_vivienda',
        'baño_dentro',
        'baño_con_descarga',
        'piso_vivienda',
        'construccion_vivienda',
        'condicion_vivienda',
        'motivo_para_estudiar',
        'conocimiento_instituto',
        'seguridad_carrera',
        'fundamento_seguridad',
        'como_ingresa',
        'tipo_nivel_medio',
        'materia_menos_costosa',
        'materia_mas_costosa',
        'ayuda_para_estudiar',
        'horas_estudio',
        'dificultad_estudio',
        'herramientas_estudio',
        'lugar_trabajo',
        'temas_capacitacion',
        'actividades_extras',
        'desc_actividades_extras',
        'situacion_salud',
        'cud',
        'problemas_salud_mental',
        'dia_actividades',
        'horario_actividades',
        'otro_comentario'
    ];

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class,'alumno_id');
    }
}
