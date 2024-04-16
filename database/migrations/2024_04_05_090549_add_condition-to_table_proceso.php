<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConditionToTableProceso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->unsignedBigInteger('condicion_materia_id')->nullable();

            $table->foreign('condicion_materia_id')
                ->references('id')
                ->on('condicion_materias')
             ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->dropForeign('procesos_condicion_materia_id_foreign');
            $table->dropColumn('condicion_materia_id');
        });
    }
}
