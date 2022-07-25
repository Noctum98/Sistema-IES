<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypesTableProcesoModular extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proceso_modular', function (Blueprint $table) {
            $table->float('promedio_final_porcentaje')->unsigned()->nullable();
            $table->float('nota_final_porcentaje')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proceso_modular', function (Blueprint $table) {
            $table->integer('promedio_final_porcentaje')->unsigned()->nullable();
            $table->integer('nota_final_porcentaje')->unsigned()->nullable();
        });
    }
}
