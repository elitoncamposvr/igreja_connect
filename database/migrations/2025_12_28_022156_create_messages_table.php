<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('message_template_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained();

            $table->enum('channel', ['whatsapp', 'email', 'sms'])->default('whatsapp');
            $table->string('recipient');
            $table->text('content');

            $table->enum('status', [
                'pending',
                'sent',
                'delivered',
                'read',
                'failed',
            ])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();

            $table->boolean('is_scheduled')->default(false);
            $table->timestamp('scheduled_for')->nullable();

            $table->string('external_id')->nullable();
            $table->text('error_message')->nullable();

            $table->timestamps();

            $table->index(['church_id', 'status']);
            $table->index(['church_id', 'member_id']);
            $table->index('sent_at');
            $table->index('external_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
