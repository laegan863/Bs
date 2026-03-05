<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Agoda booking tracking
            $table->unsignedBigInteger('agoda_booking_id')->nullable()->unique()->after('id');
            $table->string('agoda_status')->nullable()->after('status');
            $table->string('hotel_confirmation_number')->nullable()->after('agoda_status');
            $table->string('supplier_reference')->nullable()->after('hotel_confirmation_number');

            // Pricing from Agoda (net/selling)
            $table->decimal('selling_price', 10, 2)->nullable()->after('total_price');
            $table->decimal('net_rate', 10, 2)->nullable()->after('selling_price');
            $table->decimal('tax_amount', 10, 2)->nullable()->after('net_rate');
            $table->decimal('fees_amount', 10, 2)->nullable()->after('tax_amount');

            // Property address details from Agoda
            $table->string('property_country')->nullable()->after('property_image');
            $table->string('property_city')->nullable()->after('property_country');
            $table->string('property_address')->nullable()->after('property_city');

            // Rate plan info
            $table->string('rate_plan')->nullable()->after('bed_type');
            $table->string('rate_type')->nullable()->after('rate_plan');

            // Agoda metadata
            $table->json('room_benefits')->nullable()->after('rate_type');
            $table->json('amendments')->nullable()->after('room_benefits');
            $table->text('cancellation_policy')->nullable()->after('cancellation_deadline');
            $table->string('self_service_url')->nullable()->after('cancellation_policy');
            $table->string('booking_source')->nullable()->after('self_service_url');
            $table->string('credit_card_last4', 4)->nullable()->after('booking_source');
            $table->timestamp('agoda_booking_date')->nullable()->after('credit_card_last4');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'agoda_booking_id',
                'agoda_status',
                'hotel_confirmation_number',
                'supplier_reference',
                'selling_price',
                'net_rate',
                'tax_amount',
                'fees_amount',
                'property_country',
                'property_city',
                'property_address',
                'rate_plan',
                'rate_type',
                'room_benefits',
                'amendments',
                'cancellation_policy',
                'self_service_url',
                'booking_source',
                'credit_card_last4',
                'agoda_booking_date',
            ]);
        });
    }
};
