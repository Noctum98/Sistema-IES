<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_managers', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('model');
            $table->string('name');
            $table->string('link');
            $table->boolean('enabled')->default(true);
            $table->string('icon');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_managers');
    }
};
