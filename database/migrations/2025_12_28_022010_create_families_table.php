<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->foreignId('head_member_id')
                ->nullable()
                ->constrained('members')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->index('church_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
