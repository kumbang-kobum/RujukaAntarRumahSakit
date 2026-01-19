<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('soap_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examination_id')->constrained('examinations')->cascadeOnDelete();

            $table->longText('subjective')->nullable();
            $table->longText('objective')->nullable();
            $table->longText('assessment')->nullable();
            $table->longText('plan')->nullable();

            $table->timestamp('signed_at')->nullable();
            $table->foreignId('signed_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->unique(['examination_id']); // 1 examination 1 soap
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soap_notes');
    }
};