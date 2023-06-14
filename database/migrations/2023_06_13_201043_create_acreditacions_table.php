<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcreditacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acreditaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('trianual_id');
            $table->unsignedBigInteger('operador_id');
            $table->unsignedInteger('nota');
            $table->string('fecha_acreditacion');
            $table->string('libro');
            $table->string('folio');
            $table->boolean('excepcion');
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
        Schema::dropIfExists('acreditacions');
    }
}
