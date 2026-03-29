<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingDetail extends Model
{
    protected $fillable = [
        'booking_id',
        'hotel_address',
        'hotel_remarks',
        'room_type',
        'room_quantity',
        'adults',
        'children',
        'benefits',
        'cancellation_policy',
        'free_cancellation',
        'cancellation_deadline',
        'special_requests',
        'surcharges',
        'surcharge_total',
        'payment_type',
    ];

    protected function casts(): array
    {
        return [
            'benefits' => 'array',
            'surcharges' => 'array',
            'free_cancellation' => 'boolean',
            'cancellation_deadline' => 'date',
            'surcharge_total' => 'decimal:2',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
