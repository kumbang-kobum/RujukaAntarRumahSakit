<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examination_id')->constrained('examinations')->cascadeOnDelete();

            $table->unsignedSmallInteger('systolic')->nullable();
            $table->unsignedSmallInteger('diastolic')->nullable();
            $table->unsignedSmallInteger('pulse')->nullable();
            $table->unsignedSmallInteger('resp_rate')->nullable();
            $table->decimal('temp', 4, 1)->nullable();
            $table->unsignedSmallInteger('spo2')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->unsignedTinyInteger('pain_scale')->nullable();

            $table->timestamps();

            $table->unique(['examination_id']); // 1 examination 1 vital
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};