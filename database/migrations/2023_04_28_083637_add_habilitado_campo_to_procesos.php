<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHabilitadoCampoToProcesos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->boolean('habilitado_campo')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->dropColumn('habilitado_campo');
        });
    }
}
