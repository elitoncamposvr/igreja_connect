<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('churches', function (Blueprint $table) {
            $table->id();

            // Dados básicos
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('cnpj', 18)->unique()->nullable();

            // Endereço
            $table->string('street')->nullable();
            $table->string('number', 20)->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zip_code', 10)->nullable();

            // Configurações
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('denomination')->nullable(); // Assembleia, Batista, etc
            $table->date('founded_at')->nullable();

            // Logo e banner
            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();

            // Plano e assinatura
            $table->string('plan')->default('pequena'); // pequena, media, grande, rede
            $table->date('subscription_started_at')->nullable();
            $table->date('subscription_ends_at')->nullable();
            $table->boolean('is_trial')->default(false);

            // Timestamps e soft delete
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('status');
            $table->index('plan');
            $table->index(['subscription_ends_at', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('churches');
    }
};
