<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('billing_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->constrained('billings')->cascadeOnDelete();

            $table->string('type'); // procedure | drug | service
            $table->string('name');

            $table->decimal('price', 14, 2);
            $table->integer('qty')->default(1);
            $table->decimal('total', 14, 2);

            $table->string('ref_type')->nullable(); // ExamProcedure / ExamDrug
            $table->unsignedBigInteger('ref_id')->nullable();

            $table->timestamps();
            $table->index(['ref_type','ref_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_items');
    }
};