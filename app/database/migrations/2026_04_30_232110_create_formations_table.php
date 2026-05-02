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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('content')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->string('video_intro')->nullable();
            $table->integer('duration_hours')->nullable();
            $table->integer('max_students')->nullable();
            $table->enum('level', ['debutant', 'intermediaire', 'avance'])->default('debutant');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->json('modules')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
