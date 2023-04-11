<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCerradoTableProcesosCalificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proceso_calificacion', function (Blueprint $table) {
            $table->timestamp('close_profesor')->nullable();
            $table->timestamp('close_coordinador')->nullable();
            $table->timestamp('open_profesor')->nullable();
            $table->timestamp('open_coordinador')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proceso_calificacion', function (Blueprint $table) {
            $table->dropColumn('close_profesor');
            $table->dropColumn('close_coordinador');
            $table->dropColumn('open_profesor');
            $table->dropColumn('open_coordinador');
        });
    }
}
