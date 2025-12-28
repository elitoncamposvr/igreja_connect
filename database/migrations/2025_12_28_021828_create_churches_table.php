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

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('cnpj', 18)->unique()->nullable();

            $table->string('street')->nullable();
            $table->string('number', 20)->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zip_code', 10)->nullable();

            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('denomination')->nullable();
            $table->date('founded_at')->nullable();

            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();

            $table->string('plan')->default('pequena');
            $table->date('subscription_started_at')->nullable();
            $table->date('subscription_end_at')->nullable();
            $table->boolean('is_trial')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->increments('status');
            $table->index('plan');
            $table->index(['subscription_end_at', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('churches');
    }
};
