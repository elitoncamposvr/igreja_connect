<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->cascadeOnDelete();
            $table->foreignId('congregation_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('cpf', 14)->nullable();
            $table->string('birth_date')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            $table->string('photo_path')->nullable();

            $table->string('street')->nullable();
            $table->string('number', 20)->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zip_code', 10)->nullable();

            $table->enum('status', ['member', 'congregant', 'visitor', 'inactive'])->default('visitor');
            $table->date('baptism_date')->nullable();
            $table->date('conversion_date')->nullable();
            $table->date('membership_date')->nullable();

            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();

            $table->text('notes')->nullable();

            $table->string('password')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['church_id', 'status']);
            $table->index('email');
            $table->index('cpf');
            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
