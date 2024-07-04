<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoUnidadCurricularIdToMasterMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_materias', function (Blueprint $table) {
            $table->foreignId('tipo_unidad_curricular_id')->nullable()->constrained('tipo_materias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_materias', function (Blueprint $table) {
            //
        });
    }
}
