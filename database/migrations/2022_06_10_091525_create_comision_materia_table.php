<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_materia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comision_id');
            $table->unsignedBigInteger('materia_id');
            $table->foreign('comision_id')
                ->references('id')
                ->on('comisiones')
                ->onDelete('cascade');
            $table->foreign('materia_id')
                ->references('id')
                ->on('materias')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comision_materia');
    }
}
