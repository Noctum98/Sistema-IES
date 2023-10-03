<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCicloLectivoTableEquivalencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equivalencias', function (Blueprint $table) {
            $table->integer('ciclo_lectivo')->unsigned()->nullable()->default(2023);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equivalencias', function (Blueprint $table) {
            $table->dropColumn('ciclo_lectivo');
        });
    }
}
