<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('family_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->enum('relationship', ['head', 'spouse', 'child', 'parent', 'other'])
                ->default('other');

            $table->timestamps();

            $table->unique(['family_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_member');
    }
};
