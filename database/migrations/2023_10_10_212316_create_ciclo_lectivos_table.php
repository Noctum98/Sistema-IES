<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCicloLectivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciclo_lectivos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('year');
            $table->date('fst_sem');
            $table->date('snd_sem');
            $table->date('anual');
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
        Schema::dropIfExists('ciclo_lectivos');
    }
}
