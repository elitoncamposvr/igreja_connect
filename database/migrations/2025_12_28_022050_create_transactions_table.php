<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('payment_method_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 15, 2);
            $table->text('description');
            $table->date('transaction_date');

            $table->boolean('is_recurring')->default(false);
            $table->enum('recurring_frequency', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();

            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed');

            $table->json('attachments')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['church_id', 'type', 'transaction_date']);
            $table->index(['church_id', 'category_id']);
            $table->index('transaction_date');
            $table->index('status');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
