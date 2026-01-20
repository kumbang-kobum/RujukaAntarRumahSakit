<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exam_drugs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('examination_id')->constrained('examinations')->cascadeOnDelete();
            $table->foreignId('drug_id')->constrained('catalog_drugs')->cascadeOnDelete();

            $table->decimal('qty', 10, 2)->default(1);
            $table->decimal('price', 12, 2)->default(0); // snapshot saat itu
            $table->string('note')->nullable();

            $table->timestamps();

            $table->index(['examination_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_drugs');
    }
};