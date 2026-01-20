<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('visit_id')
                ->constrained('visits')
                ->cascadeOnDelete();

            $table->foreignId('examiner_user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('examiner_hospital_id')
                ->constrained('hospitals')
                ->cascadeOnDelete();

            $table->dateTime('examined_at');

            $table->enum('status', ['draft','final'])->default('draft');

            $table->timestamps();

            $table->index(['visit_id','examined_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};