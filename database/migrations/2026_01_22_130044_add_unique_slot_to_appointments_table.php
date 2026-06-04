<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $indexes = Schema::getIndexes('appointments');
        $hasPatientDentistSlot = false;
        $hasDentistSlot = false;
        foreach ($indexes as $index) {
            if (($index['name'] ?? '') === 'unique_patient_dentist_slot') {
                $hasPatientDentistSlot = true;
            }
            if (($index['name'] ?? '') === 'unique_dentist_slot') {
                $hasDentistSlot = true;
            }
        }

        Schema::table('appointments', function (Blueprint $table) use ($hasPatientDentistSlot, $hasDentistSlot) {
            if ($hasPatientDentistSlot) {
                $table->dropUnique('unique_patient_dentist_slot');
            }

            if (!$hasDentistSlot) {
                $table->unique(
                    ['dentist_id', 'appointment_date', 'appointment_time'],
                    'unique_dentist_slot'
                );
            }
        });
    }

    public function down(): void
    {
        $indexes = Schema::getIndexes('appointments');
        $hasDentistSlot = false;
        $hasPatientDentistSlot = false;
        foreach ($indexes as $index) {
            if (($index['name'] ?? '') === 'unique_dentist_slot') {
                $hasDentistSlot = true;
            }
            if (($index['name'] ?? '') === 'unique_patient_dentist_slot') {
                $hasPatientDentistSlot = true;
            }
        }

        Schema::table('appointments', function (Blueprint $table) use ($hasDentistSlot, $hasPatientDentistSlot) {
            if ($hasDentistSlot) {
                $table->dropUnique('unique_dentist_slot');
            }

            if (!$hasPatientDentistSlot) {
                $table->unique(
                    ['user_id', 'dentist_id', 'appointment_date', 'appointment_time'],
                    'unique_patient_dentist_slot'
                );
            }
        });
    }
};
