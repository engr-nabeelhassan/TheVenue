<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_date',
        'customer_id',
        'customer_name',
        'event_type',
        'total_guests',
        'event_start_at',
        'event_end_at',
        'payment_status',
        'payment_option',
        'advance_amount',
        'items_subtotal',
        'items_discount_amount',
        'invoice_net_amount',
        'invoice_total_paid',
        'invoice_closing_amount',
        'amount_in_words',
        'remarks',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'event_start_at' => 'datetime',
        'event_end_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }
}


