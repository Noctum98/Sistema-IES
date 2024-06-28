<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary( 'id');
            $table->string('name');
            $table->string('link');
            $table->unsignedInteger('orden')->default(99);
            $table->foreignId('user_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};
