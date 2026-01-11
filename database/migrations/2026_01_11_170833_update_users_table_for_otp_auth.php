<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Add phone for OTP login
            $table->string('phone')->unique()->after('id');

            // Make name REQUIRED
            $table->string('name')->nullable(false)->change();

            // Email optional
            $table->string('email')->nullable()->change();

            // Active flag
            $table->boolean('is_active')->default(true)->after('email');

            // Remove password-based columns
            $table->dropColumn([
                'password',
                'remember_token',
                'email_verified_at',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('password');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();

            $table->dropColumn(['phone', 'is_active']);

            // Revert name nullable if rollback
            $table->string('name')->nullable()->change();
        });
    }
};
