<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('estado_id')->constrained('estado_tickets');
            $table->foreignId('ticket_id')->constrained('tickets')->nullable();
            $table->string('asunto');
            $table->text('descripcion');
            $table->string('captura')->nullable();
            $table->string('url')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('tickets');
    }
}
