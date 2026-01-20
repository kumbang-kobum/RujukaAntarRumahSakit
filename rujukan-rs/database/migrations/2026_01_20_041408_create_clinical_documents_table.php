<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clinical_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('examination_id')
                ->constrained('examinations')
                ->cascadeOnDelete();

            $table->enum('type', ['lab','radiology','other']);
            $table->string('title');
            $table->string('file_path');
            $table->string('original_name');

            $table->foreignId('uploaded_by_user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->index(['examination_id','type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinical_documents');
    }
};