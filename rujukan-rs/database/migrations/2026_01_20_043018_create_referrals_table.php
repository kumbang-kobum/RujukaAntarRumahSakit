<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('visit_id')->constrained('visits')->cascadeOnDelete();

            // Dari RS asal (snapshot)
            $table->foreignId('from_hospital_id')->constrained('hospitals')->cascadeOnDelete();
            $table->foreignId('from_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('from_department_id')->nullable()->constrained('departments')->nullOnDelete();

            // Ke RS tujuan
            $table->foreignId('to_hospital_id')->constrained('hospitals')->cascadeOnDelete();
            $table->foreignId('to_department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('to_user_id')->nullable()->constrained('users')->nullOnDelete(); // dokter tujuan (opsional)

            $table->enum('status', ['draft','sent','accepted','rejected','completed'])->default('sent');

            $table->text('reason')->nullable();
            $table->text('notes')->nullable();

            $table->timestamp('sent_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->index(['visit_id','status']);
            $table->index(['to_hospital_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};