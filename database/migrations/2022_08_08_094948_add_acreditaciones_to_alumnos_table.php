<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcreditacionesToAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->string('fecha_primera_acreditacion')->after('pase')->nullable();
            $table->string('fecha_ultima_acreditacion')->after('fecha_primera_acreditacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn('fecha_primera_acreditacion');
            $table->dropColumn('fecha_ultima_acreditacion');
        });
    }
}
