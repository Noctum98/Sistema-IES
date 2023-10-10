<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstanciaSedeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instancia_sede', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instancia_id')->constrained('instancias');
            $table->unsignedInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');
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
        Schema::dropIfExists('instancia_sede');
    }
}
