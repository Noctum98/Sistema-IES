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
            $table->boolean('cierre_profesor')->after('libro')->default(false);
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
        });
    }
}
