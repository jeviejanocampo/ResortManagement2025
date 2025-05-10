<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments';

    protected $primaryKey = 'payment_id';

    public $timestamps = true;

    protected $fillable = [
        'booking_id',
        'total_amount',
        'payment_method',
        'reference_number',
        'amount_paid',
        'change',
        'payment_notes',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }
}
