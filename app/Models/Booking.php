<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agoda_booking_id',
        'property_id',
        'property_name',
        'property_image',
        'property_country',
        'property_city',
        'property_address',
        'room_id',
        'room_name',
        'room_type',
        'bed_type',
        'rate_plan',
        'rate_type',
        'room_benefits',
        'amendments',
        'check_in',
        'check_out',
        'rooms',
        'adults',
        'children',
        'price_per_night',
        'total_price',
        'selling_price',
        'net_rate',
        'tax_amount',
        'fees_amount',
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
        'agoda_status',
        'hotel_confirmation_number',
        'supplier_reference',
        'free_cancellation',
        'cancellation_deadline',
        'cancellation_policy',
        'self_service_url',
        'booking_source',
        'credit_card_last4',
        'agoda_booking_date',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'cancellation_deadline' => 'date',
            'agoda_booking_date' => 'datetime',
            'price_per_night' => 'decimal:2',
            'total_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'net_rate' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'fees_amount' => 'decimal:2',
            'free_cancellation' => 'boolean',
            'room_benefits' => 'array',
            'amendments' => 'array',
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
     * Get the Agoda booking response details.
     */
    public function agodaBooking(): HasOne
    {
        return $this->hasOne(AgodaBooking::class);
    }

    /**
     * Scope: current (upcoming/active) bookings.
     */
    public function scopeCurrent($query)
    {
        return $query->where('check_out', '>=', now()->toDateString())
                     ->whereNotIn('agoda_status', ['BookingCancelledByCustomer', 'BookingCancelledByAgoda', 'BookingCancelledByProperty'])
                     ->whereNotIn('status', ['cancelled', 'completed']);
    }

    /**
     * Scope: previous (past or cancelled) bookings.
     */
    public function scopePrevious($query)
    {
        return $query->where(function ($q) {
            $q->where('check_out', '<', now()->toDateString())
              ->orWhereIn('agoda_status', ['BookingCancelledByCustomer', 'BookingCancelledByAgoda', 'BookingCancelledByProperty'])
              ->orWhereIn('status', ['cancelled', 'completed']);
        });
    }

    /**
     * Check if this booking is cancellable.
     */
    public function isCancellable(): bool
    {
        return $this->check_in->isFuture()
            && !in_array($this->agoda_status, ['BookingCancelledByCustomer', 'BookingCancelledByAgoda', 'BookingCancelledByProperty'])
            && !in_array($this->status, ['cancelled', 'completed']);
    }

    /**
     * Check if this booking can be amended/rescheduled.
     */
    public function isAmendable(): bool
    {
        return $this->isCancellable();
    }

    /**
     * Get a human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->agoda_status) {
            'Confirmed' => 'Confirmed',
            'BookingCancelledByCustomer' => 'Cancelled by You',
            'BookingCancelledByAgoda' => 'Cancelled by Agoda',
            'BookingCancelledByProperty' => 'Cancelled by Property',
            'Completed' => 'Completed',
            default => ucfirst($this->status ?? 'unknown'),
        };
    }

    /**
     * Get status badge CSS class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->agoda_status) {
            'Confirmed' => 'bg-success',
            'BookingCancelledByCustomer', 'BookingCancelledByAgoda', 'BookingCancelledByProperty' => 'bg-danger',
            'Completed' => 'bg-secondary',
            default => 'bg-warning text-dark',
        };
    }

    /**
     * Create or update a booking from Agoda API response data.
     */
    public static function syncFromAgoda(array $agodaBooking, int $userId): self
    {
        $totalRate = $agodaBooking['totalRates'][0] ?? [];

        return self::updateOrCreate(
            ['agoda_booking_id' => $agodaBooking['bookingId']],
            [
                'user_id' => $userId,
                'property_id' => $agodaBooking['bookingId'],
                'property_name' => $agodaBooking['property']['propertyName'] ?? '',
                'property_country' => $agodaBooking['property']['country'] ?? null,
                'property_city' => $agodaBooking['property']['city'] ?? null,
                'property_address' => trim(($agodaBooking['property']['addressLine1'] ?? '') . ' ' . ($agodaBooking['property']['addressLine2'] ?? '')),
                'room_name' => $agodaBooking['room']['roomType'] ?? '',
                'room_type' => $agodaBooking['room']['roomType'] ?? null,
                'rooms' => $agodaBooking['room']['roomsBooked'] ?? 1,
                'rate_plan' => $agodaBooking['room']['ratePlan'] ?? null,
                'rate_type' => $agodaBooking['room']['rateType'] ?? null,
                'room_benefits' => $agodaBooking['room']['benefits'] ?? [],
                'amendments' => $agodaBooking['amendments'] ?? [],
                'check_in' => $agodaBooking['checkIn'],
                'check_out' => $agodaBooking['checkOut'],
                'adults' => $agodaBooking['occupancy']['numberOfAdults'] ?? 1,
                'children' => $agodaBooking['occupancy']['numberOfChildren'] ?? 0,
                'total_price' => $totalRate['inclusive'] ?? 0,
                'selling_price' => $totalRate['inclusive'] ?? 0,
                'net_rate' => $totalRate['exclusive'] ?? 0,
                'tax_amount' => $totalRate['tax'] ?? 0,
                'fees_amount' => $totalRate['fees'] ?? 0,
                'currency' => $totalRate['currency'] ?? 'USD',
                'special_requests' => $agodaBooking['specialRequest'] ?? null,
                'agoda_status' => $agodaBooking['status'] ?? null,
                'status' => self::mapAgodaStatus($agodaBooking['status'] ?? ''),
                'hotel_confirmation_number' => $agodaBooking['hotelConfirmationNumber'] ?? null,
                'supplier_reference' => $agodaBooking['supplierReference'] ?? null,
                'cancellation_policy' => $agodaBooking['cancellationPolicy'] ?? null,
                'self_service_url' => $agodaBooking['selfService'] ?? null,
                'booking_source' => $agodaBooking['source'] ?? null,
                'credit_card_last4' => isset($agodaBooking['payment']['creditCardNumber'])
                    ? substr($agodaBooking['payment']['creditCardNumber'], -4)
                    : null,
                'agoda_booking_date' => $agodaBooking['bookingDate'] ?? null,
            ]
        );
    }

    /**
     * Map Agoda status to our internal status.
     */
    public static function mapAgodaStatus(string $agodaStatus): string
    {
        return match ($agodaStatus) {
            'Confirmed' => 'confirmed',
            'Completed' => 'completed',
            'BookingCancelledByCustomer', 'BookingCancelledByAgoda', 'BookingCancelledByProperty' => 'cancelled',
            default => 'pending',
        };
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
