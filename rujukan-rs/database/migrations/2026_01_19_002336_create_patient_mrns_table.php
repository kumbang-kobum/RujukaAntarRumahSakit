<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_mrns', function (Blueprint $table) {
            $table->id();
            $table->uuid('patient_id');
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('medical_record_no'); // no_rm per RS
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();

            $table->unique(['hospital_id', 'medical_record_no']);
            $table->unique(['patient_id', 'hospital_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_mrns');
    }
};