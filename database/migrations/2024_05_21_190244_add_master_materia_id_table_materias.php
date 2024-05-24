<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMasterMateriaIdTableMaterias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->foreignUuid('master_materia_id')->nullable();
            $table->foreign('master_materia_id')
                ->references('id')->
                on('master_materias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->dropForeign('materias_master_materia_id_foreign');
            $table->dropColumn('master_materia_id');
        });
    }
}
