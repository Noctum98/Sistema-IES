<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionesTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaciones_tickets', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignUuid('derivacion_id')->constrained('tickets');
            $table->foreignUuid('ticket_id')->constrained('tickets');
            $table->boolean('responsable')->default(false);
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
        Schema::dropIfExists('asignaciones_tickets');
    }
}
