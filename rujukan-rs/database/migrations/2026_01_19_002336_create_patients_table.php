<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('nik')->nullable(); // nanti bisa encrypt/cast
            $table->string('name');
            $table->date('dob')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();

            $table->text('address_detail')->nullable();
            $table->string('phone')->nullable();

            $table->timestamps();

            $table->index(['nik', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};