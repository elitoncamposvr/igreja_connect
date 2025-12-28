<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->cascadeOnDelete();
            $table->foreignId('congregation_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['worship', 'cell', 'meeting', 'conference', 'retreat', 'other'])->default('worship');

            // Data e hora
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_frequency', ['daily', 'weekly', 'monthly'])->nullable();

            // Local
            $table->string('location')->nullable();

            // Status
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])->default('scheduled');

            // Controle de presença
            $table->boolean('track_attendance')->default(false);
            $table->integer('expected_attendees')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['church_id', 'status']);
            $table->index(['church_id', 'starts_at']);
            $table->index('starts_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
