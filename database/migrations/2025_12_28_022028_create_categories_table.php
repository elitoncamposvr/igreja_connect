<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug');
            $table->enum('type', ['income', 'expense']);
            $table->string('color', 7)->default('#3B82F6');
            $table->text('description')->nullable();
            $table->boolean('is_default')->default(false);

            $table->timestamps();

            $table->index(['church_id', 'type']);
            $table->unique(['church_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
