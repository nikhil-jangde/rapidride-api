<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ride_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ride_id')
                  ->constrained('rides')
                  ->cascadeOnDelete();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('rider_id')
                  ->constrained('riders')
                  ->cascadeOnDelete();

            $table->decimal('fare_amount', 8, 2);
            $table->decimal('platform_commission', 8, 2);
            $table->decimal('rider_earning', 8, 2);

            $table->enum('payment_method', ['CASH', 'UPI', 'WALLET']);
            $table->enum('payment_status', ['PENDING', 'PAID', 'FAILED'])
                  ->default('PENDING');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->index('rider_id');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_payments');
    }
};
