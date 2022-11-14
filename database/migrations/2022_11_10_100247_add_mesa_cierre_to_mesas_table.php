<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMesaCierreToMesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mesas', function (Blueprint $table) {
            $table->after('libro',function($table){
                $table->boolean('cierre_profesor')->default(false);
                $table->string('fecha_cierre_profesor')->nullable();
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
            $table->dropColumn('cierre_profesor');
            $table->dropColumn('fecha_cierre_profesor');
        });
    }
}
