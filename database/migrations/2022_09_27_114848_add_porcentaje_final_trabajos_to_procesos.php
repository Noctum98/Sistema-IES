<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPorcentajeFinalTrabajosToProcesos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->double('porcentaje_final_trabajos')->after('final_trabajos')->nullable();
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
            $table->dropColumn('porcentaje_final_trabajos');
        });
    }
}
