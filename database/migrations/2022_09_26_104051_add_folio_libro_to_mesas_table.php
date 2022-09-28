<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFolioLibroToMesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mesas', function (Blueprint $table) {
            $table->string('folio')->after('segundo_vocal_segundo')->nullable();
            $table->string('libro')->after('folio')->nullable();
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
            $table->dropColumn('folio');
            $table->dropColumn('libro');
        });
    }
}
