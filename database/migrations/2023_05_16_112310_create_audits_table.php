<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->string('table');
            $table->bigInteger('table_id');
            $table->bigInteger('user_id')->nullable();
            $table->string('model');
            $table->text('changes');
            $table->string('table_created_at')->nullable();
            $table->string('table_updated_at')->nullable();
            $table->string('table_deleted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audits');
    }
}
