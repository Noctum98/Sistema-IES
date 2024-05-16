<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoResolucionTableResoluciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resoluciones', function (Blueprint $table) {
            $table->dropColumn('estados_id');
            $table->foreignUuid('estado_resoluciones_id');
            $table->foreign('estado_resoluciones_id')->references('id')->on('estados_resoluciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resoluciones', function (Blueprint $table) {
            $table->string('estados_id')->nullable();
            $table->dropColumn('estado_resoluciones_id');
        });
    }
}
