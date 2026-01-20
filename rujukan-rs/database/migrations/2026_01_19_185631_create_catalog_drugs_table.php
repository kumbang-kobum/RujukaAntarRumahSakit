<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('catalog_drugs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained('hospitals')->cascadeOnDelete();

            $table->string('code')->nullable();
            $table->string('name');
            $table->string('unit')->nullable(); // tablet, botol, ampul, dll
            $table->decimal('default_price', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['hospital_id','name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_drugs');
    }
};