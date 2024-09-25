<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketEstadoTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_estado_ticket', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('ticket_id')->constrained('tickets');
            $table->foreignUuid('from_estado_ticket_id')->constrained('estado_tickets');
            $table->foreignUuid('to_estado_ticket_id')->constrained('estado_tickets');
            $table->foreignId('user_id')->constrained('users'); 
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
        Schema::dropIfExists('ticket_estado_ticket');
    }
}
