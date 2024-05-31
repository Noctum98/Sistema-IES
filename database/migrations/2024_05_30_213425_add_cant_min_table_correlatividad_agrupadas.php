<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCantMinTableCorrelatividadAgrupadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('correlatividad_agrupadas', function (Blueprint $table) {
            $table->integer('cantidad_min')
                ->after('resoluciones_id')
                ->default(1)
                ->comment('Cantidad mínima de materias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('correlatividad_agrupadas', function (Blueprint $table) {
            $table->dropColumn('cantidad_min');
        });
    }
}
