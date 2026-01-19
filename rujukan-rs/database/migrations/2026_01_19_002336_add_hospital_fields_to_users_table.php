<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('hospital_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('phone_whatsapp')->nullable()->after('email');
            $table->boolean('is_active')->default(true)->after('phone_whatsapp');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('hospital_id');
            $table->dropColumn(['phone_whatsapp', 'is_active', 'last_login_at']);
        });
    }
};