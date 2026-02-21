<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Property details
            $table->string('property_id');
            $table->string('property_name');
            $table->string('property_image')->nullable();

            // Room details
            $table->string('room_id');
            $table->string('room_name');
            $table->string('room_type')->nullable();
            $table->string('bed_type')->nullable();

            // Stay details
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('rooms')->default(1);
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);

            // Pricing
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('currency', 10)->default('USD');

            // Guest info
            $table->string('guest_first_name');
            $table->string('guest_last_name');
            $table->string('guest_email');
            $table->string('guest_phone')->nullable();
            $table->text('special_requests')->nullable();

            // Payment
            $table->enum('payment_method', ['bitpay', 'card', 'pay_at_hotel'])->default('bitpay');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded', 'cancelled'])->default('pending');
            $table->string('bitpay_invoice_id')->nullable();
            $table->string('transaction_reference')->nullable()->unique();

            // Booking status
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'no_show'])->default('pending');

            // Cancellation
            $table->boolean('free_cancellation')->default(false);
            $table->date('cancellation_deadline')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
