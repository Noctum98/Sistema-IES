<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCicloLectivoProcesoModularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proceso_modular', function (Blueprint $table) {
            $table->integer('ciclo_lectivo')->nullable();
        });
        DB::statement('UPDATE proceso_modular SET ciclo_lectivo = 2022');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proceso_modular', function (Blueprint $table) {
            $table->dropColumn('ciclo_lectivo');
        });
    }
}
