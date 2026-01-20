<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shared_links', function (Blueprint $table) {
        $table->id();
        $table->string('token', 80)->unique();
        $table->string('type'); // resume_pdf
        $table->unsignedBigInteger('visit_id');
        $table->timestamp('expires_at')->nullable();
        $table->timestamps();

        $table->foreign('visit_id')->references('id')->on('visits')->cascadeOnDelete();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_links');
    }
};
