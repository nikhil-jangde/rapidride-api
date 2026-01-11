<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->nullable();

            // Live rider photo
            $table->binary('avatar_blob')->nullable();

            // Verification
            $table->enum('verification_status', ['PENDING', 'APPROVED', 'REJECTED'])
                  ->default('PENDING');

            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by_admin_id')
                  ->nullable()
                  ->constrained('admins')
                  ->nullOnDelete();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riders');
    }
};
