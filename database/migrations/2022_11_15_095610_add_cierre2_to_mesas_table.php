<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCierre2ToMesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mesas', function (Blueprint $table) {
            $table->after('fecha_cierre_profesor',function($table){
                $table->string('libro_segundo')->nullable();
                $table->string('folio_segundo')->nullable();
                $table->boolean('cierre_profesor_segundo')->default(false);
                $table->string('fecha_cierre_profesor_segundo')->nullable();
                $table->boolean('visible')->default(true);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mesas', function (Blueprint $table) {
            $table->dropColumn('libro_segundo');
            $table->dropColumn('folio_segundo');
            $table->dropColumn('cierre_profesor_segundo');
            $table->dropColumn('fecha_cierre_profesor_segundo');
            $table->dropColumn('visible');
        });
    }
}
