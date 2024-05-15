<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('regimens', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('identifier')->unique();
            $table->primary('id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regimens');
    }
};
