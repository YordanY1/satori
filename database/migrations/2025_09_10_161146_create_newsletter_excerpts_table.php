<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('newsletter_excerpts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file_path');
            $table->boolean('is_sent')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_excerpts');
    }
};
