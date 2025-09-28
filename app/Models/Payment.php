<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'customer_name',
        'contact',
        'receipt_date',
        'payment_method',
        'payment_status',
        'previous_balance',
        'add_amount',
        'remaining_balance',
        'remarks',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'previous_balance' => 'decimal:2',
        'add_amount' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}