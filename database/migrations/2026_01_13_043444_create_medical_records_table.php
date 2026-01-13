<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            // The patient/student the record belongs to
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // The dentist who provided the treatment
            $table->foreignId('dentist_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Link to the specific appointment if applicable
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->text('prescription')->nullable();
            $table->text('notes')->nullable();
            $table->date('next_visit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};