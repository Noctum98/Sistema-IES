<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLibroIdToActasVolantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actas_volantes', function (Blueprint $table) {
            $table->bigInteger('libro_id')->after('instancia_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actas_volantes', function (Blueprint $table) {
            $table->dropColumn('libro_id');
        });
    }
}
