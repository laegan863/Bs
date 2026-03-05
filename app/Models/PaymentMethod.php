<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_name',
        'card_number_encrypted',
        'card_number_last4',
        'card_brand',
        'expiry_month',
        'expiry_year',
        'cvv_encrypted',
        'is_default',
        'text_alerts',
    ];

    protected function casts(): array
    {
        return [
            'is_default'  => 'boolean',
            'text_alerts' => 'boolean',
        ];
    }

    /**
     * Get the decrypted full card number.
     */
    public function getCardNumberAttribute(): string
    {
        return $this->card_number_encrypted;
    }

    /**
     * Get the user that owns this payment method.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get masked card number display (e.g. **** **** **** 1234).
     */
    public function getMaskedCardNumberAttribute(): string
    {
        return '**** **** **** ' . $this->card_number_last4;
    }

    /**
     * Get formatted expiry (e.g. 03/27).
     */
    public function getFormattedExpiryAttribute(): string
    {
        return $this->expiry_month . '/' . substr($this->expiry_year, -2);
    }
}
