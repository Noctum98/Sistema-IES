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
            $table->string('identidad_genero_otra')->nullable();
            $table->string('edad_encuesta')->nullable();
            $table->string('empresa_telefono')->nullable();
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
            $table->string('comprobanete_progresar')->nullable();
            $table->string('distancia_ies')->nullable();
            $table->string('transporte_utilizado')->nullable();
            $table->string('cantidad_convivientes')->nullable();
            $table->string('cantidad_lugares_dormir')->nullable();
            $table->string('ingresos_mensuales')->nullable();
            $table->string('condicion_laboral_jefe_hogar')->nullable();
            $table->string('maximo_nivel_educativo_padre')->nullable();
            $table->string('maximo_nivel_educativo_madre')->nullable();
            $table->string('familia_enfermedad')->nullable();
            $table->string('familia_discapacidad')->nullable();
            $table->string('familia_obra_social')->nullable();
            $table->string('desalojo_vivienda')->nullable();
            $table->string('violencia_intrafamiliar')->nullable();
            $table->string('violencia_genero')->nullable();
            $table->string('fallecimiento_conviviente')->nullable();
            $table->string('situaciones_consumo')->nullable();
            $table->string('accidentes_graves')->nullable();
            $table->string('condenas_extramuros')->nullable();
            $table->string('embargo_judicial')->nullable();
            $table->string('problemas_judiciales')->nullable();
            $table->string('agua_potable')->nullable();
            $table->string('luz_electrica')->nullable();
            $table->string('gas_envasado')->nullable();
            $table->string('gas_natural')->nullable();
            $table->string('tenencia_vivienda')->nullable();
            $table->string('baño_dentro')->nullable();
            $table->string('baño_con_descarga')->nullable();
            $table->string('piso_vivienda')->nullable();
            $table->string('construccion_vivienda')->nullable();
            $table->string('condicion_vivienda')->nullable();
            $table->string('motivo_para_estudiar')->nullable();
            $table->string('conocimiento_instituto')->nullable();
            $table->string('seguridad_carrera')->nullable();
            $table->string('fundamento_seguridad')->nullable();
            $table->string('como_ingresa')->nullable();
            $table->string('tipo_nivel_medio')->nullable();
            $table->string('materia_menos_costosa')->nullable();
            $table->string('materia_mas_costosa')->nullable();
            $table->string('ayuda_para_estudiar')->nullable();
            $table->string('horas_estudio')->nullable();
            $table->string('dificultad_estudio')->nullable();
            $table->string('herramientas_estudio')->nullable();
            $table->string('lugar_trabajo')->nullable();
            $table->string('temas_capacitacion')->nullable();
            $table->string('actividades_extras')->nullable();
            $table->string('desc_actividades_extras')->nullable();
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
