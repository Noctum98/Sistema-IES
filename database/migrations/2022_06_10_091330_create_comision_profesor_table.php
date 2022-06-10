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
            $table->unsignedBigInteger('comision_id');
            $table->unsignedBigInteger('profesor_id');
            $table->foreign('comision_id')
                ->references('id')
                ->on('comisiones')
                ->onDelete('cascade');
            $table->foreign('profesor_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('comision_profesor');
    }
}
