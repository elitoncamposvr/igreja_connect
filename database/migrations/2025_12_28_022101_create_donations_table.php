<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->enum('type', ['tithe', 'offering', 'special', 'mission', 'other']);
            $table->decimal('amount', 15, 2);
            $table->date('donated_at');

            $table->string('external_id')->nullable();
            $table->enum('payment_status', ['pending', 'confirmed', 'failed', 'refunded'])->default('confirmed');

            $table->boolean('receipt_issued')->default(false);
            $table->date('receipt_issued_at')->nullable();

            $table->text('notes')->nullable()->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['church_id', 'member_id']);
            $table->index(['church_id', 'type', 'donated_at']);
            $table->index('donated_at');
            $table->index('external_id');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
