<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAsignanteIdToAsignacionesTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asignaciones_tickets', function (Blueprint $table) {
            $table->unsignedInteger('asignante_id')->nullable();
            $table->foreign('asignante_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asignaciones_tickets', function (Blueprint $table) {
            $table->dropColumn('asignante_id');
        });
    }
}
