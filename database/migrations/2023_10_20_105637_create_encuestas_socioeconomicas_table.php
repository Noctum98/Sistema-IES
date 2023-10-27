<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncuestasSocioeconomicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuestas_socioeconomicas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('alumno_id');
            $table->string('nombre_preferido');
            $table->string('identidad_genero');
            $table->string('identidad_genero_otra');
            $table->string('edad_encuesta');
            $table->string('empresa_telefono');
            $table->string('acceso_internet');
            $table->string('herramientas_tecnologicas');
            $table->string('vinculacion_ciclo');
            $table->string('condicion_laboral');
            $table->string('lugar_y_horario_trabajo');
            $table->string('trabajo_relacionado');
            $table->string('jefe_hogar');
            $table->string('hijos_a_cargo');
            $table->string('cantidad_hijos');
            $table->string('edad_hijos');
            $table->string('obra_social');
            $table->string('subsidios');
            $table->string('comprobanete_progresar');
            $table->string('distancia_ies');
            $table->string('transporte_utilizado');
            $table->string('cantidad_convivientes');
            $table->string('cantidad_lugares_dormir');
            $table->string('ingresos_mensuales');
            $table->string('condicion_laboral_jefe_hogar');
            $table->string('maximo_nivel_educativo_padre');
            $table->string('maximo_nivel_educativo_madre');
            $table->string('familia_enfermedad');
            $table->string('familia_discapacidad');
            $table->string('familia_obra_social');
            $table->string('desalojo_vivienda');
            $table->string('violencia_intrafamiliar');
            $table->string('violencia_genero');
            $table->string('fallecimiento_conviviente');
            $table->string('situaciones_consumo');
            $table->string('accidentes_graves');
            $table->string('condenas_extramuros');
            $table->string('embargo_judicial');
            $table->string('problemas_judiciales');
            $table->string('agua_potable');
            $table->string('luz_electrica');
            $table->string('gas_envasado');
            $table->string('gas_natural');
            $table->string('tenencia_vivienda');
            $table->string('baño_dentro');
            $table->string('baño_con_descarga');
            $table->string('piso_vivienda');
            $table->string('construccion_vivienda');
            $table->string('condicion_vivienda');
            $table->string('motivo_para_estudiar');
            $table->string('conocimiento_instituto');
            $table->string('seguridad_carrera');
            $table->string('fundamento_seguridad');
            $table->string('como_ingresa');
            $table->string('tipo_nivel_medio');
            $table->string('materia_menos_costosa');
            $table->string('materia_mas_costosa');
            $table->string('ayuda_para_estudiar');
            $table->string('horas_estudio');
            $table->string('dificultad_estudio');
            $table->string('herramientas_estudio');
            $table->string('lugar_trabajo');
            $table->string('temas_capacitacion');
            $table->string('actividades_extras');
            $table->string('desc_actividades_extras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encuestas_socioeconomicas');
    }
}
