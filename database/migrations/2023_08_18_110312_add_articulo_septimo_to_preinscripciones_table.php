<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArticuloSeptimoToPreinscripcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preinscripciones', function (Blueprint $table) {
            $table->boolean('articulo_septimo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preinscripciones', function (Blueprint $table) {
            $table->dropColumn('articulo_septimo');
        });
    }
}
