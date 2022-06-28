<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserBajaYMotivoBajaToMesaAlumno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mesa_alumno', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('motivo_baja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mesa_alumno', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('motivo_baja');
        });
    }
}
