<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSegundoLlamadoToInstanciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
        Schema::table('instancias', function (Blueprint $table) {
            $table->boolean('segundo_llamado')->default(true)->change();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instancias', function (Blueprint $table) {
            $table->string('segundo_llamado')->change();
        });
    }
}
