<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('examination_id')
                ->constrained('examinations')
                ->cascadeOnDelete();

            $table->unsignedInteger('systolic')->nullable();
            $table->unsignedInteger('diastolic')->nullable();
            $table->unsignedInteger('pulse')->nullable();
            $table->unsignedInteger('resp_rate')->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->unsignedInteger('spo2')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->unsignedTinyInteger('pain_scale')->nullable();

            $table->timestamps();

            $table->unique('examination_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};