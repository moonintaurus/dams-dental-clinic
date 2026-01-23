<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropUnique('unique_patient_dentist_slot');

            $table->unique(
                ['dentist_id', 'appointment_date', 'appointment_time'],
                'unique_dentist_slot'
            );
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropUnique('unique_dentist_slot');

            $table->unique(
                ['user_id', 'dentist_id', 'appointment_date', 'appointment_time'],
                'unique_patient_dentist_slot'
            );
        });
    }
};
