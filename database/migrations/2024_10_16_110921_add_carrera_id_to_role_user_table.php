<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarreraIdToRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rol_user', function (Blueprint $table) {
            $table->foreignId('carrera_id')->nullable()->constrained('carreras');
            $table->foreignId('materia_id')->nullable()->constrained('materias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rol_user', function (Blueprint $table) {
            $table->dropColumn('carrera_id');
            $table->dropColumn('materia_id');
        });
    }
}
