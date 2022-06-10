<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionProcesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_proceso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comision_id');
            $table->unsignedBigInteger('proceso_id');
            $table->foreign('comision_id')
                ->references('id')
                ->on('comisiones')
                ->onDelete('cascade');
            $table->foreign('proceso_id')
                ->references('id')
                ->on('procesos')
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
        Schema::dropIfExists('comision_proceso');
    }
}
