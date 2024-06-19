<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDerivacionesTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('derivaciones_tickets', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->foreignUuid('ticket_id')->constrained('tickets');
            $table->foreignId('rol_id')->constrained('roles');
            $table->foreignId('operador_id')->constrained('users');
            $table->foreignId('sede_id')->nullable()->constrained('sedes');
            $table->foreignId('carrera_id')->nullable()->constrained('carreras');
            $table->boolean('general')->default(false);
            $table->boolean('activa')->default(true);
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
        Schema::dropIfExists('derivaciones_tickets');
    }
}
