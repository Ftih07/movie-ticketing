<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable(); 
            $table->timestamps();
        });

        // 2. Tabel Pivot (category_movie)
        // Aturan penamaan Laravel: urutan abjad (c dulu baru m) -> category_movie
        Schema::create('category_movie', function (Blueprint $table) {
            $table->id(); // Optional, tapi bagus untuk performa

            // Relasi ke movies (asumsi tabelmu namanya 'movies' dan PK-nya 'id')
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();

            // Relasi ke categories
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_movie');
        Schema::dropIfExists('categories');
    }
};
