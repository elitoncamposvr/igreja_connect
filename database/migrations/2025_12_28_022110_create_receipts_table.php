<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained();

            $table->string('receipt_number')->unique();
            $table->integer('year');
            $table->decimal('total_amount', 15, 2);

            $table->decimal('tithe_amount', 15, 2)->default(0);
            $table->decimal('offering_amount', 15, 2)->default(0);
            $table->decimal('special_amount', 15, 2)->default(0);

            $table->string('pdf_path')->nullable();
            $table->timestamp('gerenerated_at')->nullable();

            $table->boolean('sent_to_member')->default(false);
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();

            $table->index(['church_id', 'year']);
            $table->index(['member_id', 'year']);
            $table->index(['church_id', 'member_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
