<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompletaToEncuestasSocioeconomicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('encuestas_socioeconomicas', function (Blueprint $table) {
            $table->boolean('completa')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('encuestas_socioeconomicas', function (Blueprint $table) {
            $table->dropColumn('completa');
        });
    }
}
