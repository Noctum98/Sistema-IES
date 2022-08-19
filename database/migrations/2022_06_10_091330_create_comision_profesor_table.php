<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionProfesorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_profesor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comision_id')->constrained('comisiones');
            $table->unsignedInteger('profesor_id');
            $table->timestamps();

            $table->foreign('profesor_id')
                ->references('id')
                ->on('profesores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comision_profesor');
    }
}
