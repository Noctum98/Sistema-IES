<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDisabledTableEstadosResoluciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estados_resoluciones', function (Blueprint $table) {
            $table->boolean('disabled')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estados_resoluciones', function (Blueprint $table) {
            $table->boolean('disabled')->default(true)->change();
        });
    }
}
