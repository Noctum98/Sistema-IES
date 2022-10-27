<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToPreinscripcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preinscripciones', function (Blueprint $table) {
            $table->softDeletes();
            $table->string('responsable_delete');
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
            $table->dropSoftDeletes();
            $table->dropColumn('responsable_delete');
        });
    }
}
