<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespuestasTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas_tickets', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');            
            $table->unsignedInteger('user_id');
            $table->foreignUuid('ticket_id')->constrained('tickets');
            $table->text('contenido');
            $table->text('imagen')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('respuestas_tickets');
    }
}
