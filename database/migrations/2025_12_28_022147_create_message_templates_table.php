<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug');
            $table->text('content');
            $table->enum('type', [
                'welcome',
                'birthday',
                'donation_thanks',
                'event_reminder',
                'custom',
            ]);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['church_id', 'is_active']);
            $table->index(['church_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_templates');
    }
};
