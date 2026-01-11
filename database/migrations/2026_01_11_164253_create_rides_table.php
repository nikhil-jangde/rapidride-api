<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('rider_id')
                  ->nullable()
                  ->constrained('riders')
                  ->nullOnDelete();

            // Pickup
            $table->decimal('pickup_lat', 10, 7);
            $table->decimal('pickup_lng', 10, 7);
            $table->string('pickup_address');

            // Drop
            $table->decimal('drop_lat', 10, 7);
            $table->decimal('drop_lng', 10, 7);
            $table->string('drop_address');

            // Fare
            $table->decimal('distance_km', 6, 2)->nullable();
            $table->decimal('estimated_fare', 8, 2)->nullable();
            $table->decimal('final_fare', 8, 2)->nullable();

            // Status
            $table->enum('ride_status', [
                'REQUESTED',
                'ACCEPTED',
                'STARTED',
                'COMPLETED',
                'CANCELLED'
            ])->default('REQUESTED');

            $table->enum('cancelled_by', ['USER', 'RIDER', 'SYSTEM'])->nullable();

            // Lifecycle timestamps
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();

            $table->index('ride_status');
            $table->index('user_id');
            $table->index('rider_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
