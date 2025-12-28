<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('church_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->cascadeOnDelete();

            $table->boolean('allow_pix')->default(false);
            $table->string('pix_key')->nullable();
            $table->boolean('allow_credit_card')->default(false);
            $table->boolean('allow_recurring_donations')->default(false);

            $table->boolean('enable_whatsapp')->default(false);
            $table->boolean('enable_email')->default(true);
            $table->boolean('enable_sms')->default(false);

            $table->boolean('public_financial_reports')->default(true);
            $table->boolean('show_donor_names')->default(false);

            $table->boolean('require_member_photo')->default(false);
            $table->boolean('require_cpf')->default(false);

            $table->boolean('enable_attendance_control')->default(true);
            $table->boolean('require_qr_code_checkin')->default(false);

            $table->string('timezone')->default('America/Sao_Paulo');

            $table->timestamps();

            $table->unique('church_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_settings');
    }
};
