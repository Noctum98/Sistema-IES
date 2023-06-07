<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCargoToHourliesCompositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hourlies_compositions', function (Blueprint $table) {
            $table->foreignId('cargo_id')->nullable()->constrained('cargos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hourlies_compositions', function (Blueprint $table) {
            $table->dropColumn('cargo_id');
        });
    }
}
