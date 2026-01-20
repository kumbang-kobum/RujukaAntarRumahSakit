<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->uuid('patient_id');
            $table->string('no_rawat');
            $table->dateTime('visit_date');

            $table->enum('status', ['registered','in_exam','done_exam','referred','billing','paid','closed'])->default('registered');

            $table->unsignedBigInteger('linked_visit_id')->nullable();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();

            $table->unique(['hospital_id','no_rawat']);
            $table->index(['patient_id','visit_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};