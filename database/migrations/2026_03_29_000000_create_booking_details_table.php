<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');

            // Hotel info
            $table->string('hotel_address')->nullable();
            $table->text('hotel_remarks')->nullable();

            // Room details
            $table->string('room_type')->nullable();
            $table->integer('room_quantity')->default(1);

            // Guest counts
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);

            // Benefits (stored as JSON array)
            $table->json('benefits')->nullable();

            // Cancellation
            $table->text('cancellation_policy')->nullable();
            $table->boolean('free_cancellation')->default(false);
            $table->date('cancellation_deadline')->nullable();

            // Special requests
            $table->text('special_requests')->nullable();

            // Surcharges (stored as JSON - mandatory & excluded)
            $table->json('surcharges')->nullable();
            $table->decimal('surcharge_total', 12, 2)->default(0);

            // Payment type indicator
            $table->string('payment_type')->nullable(); // pay_now or pay_at_hotel

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
