<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exam_procedures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('examination_id')->constrained('examinations')->cascadeOnDelete();
            $table->foreignId('procedure_id')->constrained('catalog_procedures')->cascadeOnDelete();

            $table->decimal('qty', 10, 2)->default(1);
            $table->decimal('price', 12, 2)->default(0); // snapshot dari default_price saat itu
            $table->string('note')->nullable();

            $table->foreignId('performed_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['examination_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_procedures');
    }
};