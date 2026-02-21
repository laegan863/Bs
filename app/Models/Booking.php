<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'property_name',
        'property_image',
        'room_id',
        'room_name',
        'room_type',
        'bed_type',
        'check_in',
        'check_out',
        'rooms',
        'adults',
        'children',
        'price_per_night',
        'total_price',
        'currency',
        'guest_first_name',
        'guest_last_name',
        'guest_email',
        'guest_phone',
        'special_requests',
        'payment_method',
        'payment_status',
        'bitpay_invoice_id',
        'transaction_reference',
        'status',
        'free_cancellation',
        'cancellation_deadline',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'cancellation_deadline' => 'date',
            'price_per_night' => 'decimal:2',
            'total_price' => 'decimal:2',
            'free_cancellation' => 'boolean',
        ];
    }

    /**
     * Get the user who owns the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the number of nights for this booking.
     */
    public function getNightsAttribute(): int
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    /**
     * Generate a unique transaction reference.
     */
    public static function generateReference(): string
    {
        return 'ST-' . strtoupper(uniqid()) . '-' . now()->format('Ymd');
    }
}
