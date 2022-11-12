<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPresidenteIdToMesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mesas', function (Blueprint $table) {
            $table->after('segundo_vocal_segundo',function($table){
                $table->bigInteger('presidente_id')->nullable();
                $table->bigInteger('primer_vocal_id')->nullable();
                $table->bigInteger('segundo_vocal_id')->nullable();
                $table->bigInteger('presidente_segundo_id')->nullable();
                $table->bigInteger('primer_vocal_segundo_id')->nullable();
                $table->bigInteger('segundo_vocal_segundo_id')->nullable(); 
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
            $table->dropColumn('presidente_id');
            $table->dropColumn('primer_vocal_id');
            $table->dropColumn('segundo_vocal_id');
            $table->dropColumn('presidente_segundo_id');
            $table->dropColumn('primer_vocal_segundo_id');
            $table->dropColumn('segundo_vocal_segundo_id');
        });
    }
}
