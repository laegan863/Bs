<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('card_name');
            $table->string('card_number_last4', 4);
            $table->string('card_brand')->nullable(); // visa, mastercard, etc.
            $table->string('expiry_month', 2);
            $table->string('expiry_year', 4);
            $table->boolean('is_default')->default(false);
            $table->boolean('text_alerts')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
