<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_method ENUM('bitpay', 'card', 'pay_at_hotel', 'credit') NOT NULL DEFAULT 'bitpay'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_method ENUM('bitpay', 'card', 'pay_at_hotel') NOT NULL DEFAULT 'bitpay'");
    }
};
