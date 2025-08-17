<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->nullable()->constrained()->nullOnDelete();
            $table->string('cover')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->enum('format', ['paper', 'ebook'])->default('paper');
            $table->string('excerpt')->nullable();
            $table->boolean('is_book_of_month')->default(false);
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
