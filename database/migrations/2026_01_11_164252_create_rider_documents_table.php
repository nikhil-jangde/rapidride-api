<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rider_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rider_id')
                  ->constrained('riders')
                  ->cascadeOnDelete();

            // Aadhaar
            $table->string('aadhaar_number');
            $table->binary('aadhaar_pdf_blob');

            // Driving license
            $table->string('license_number');
            $table->binary('license_front_blob');
            $table->binary('license_back_blob');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rider_documents');
    }
};
