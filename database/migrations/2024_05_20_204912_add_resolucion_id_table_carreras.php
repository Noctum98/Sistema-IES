<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResolucionIdTableCarreras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->foreignUuid('resolucion_id')->nullable();
            $table->foreign('resolucion_id')
                ->references('id')->
                on('resoluciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->dropForeign('carreras_resolucion_id_foreign');
            $table->dropColumn('resolucion_id');
        });
    }
}
