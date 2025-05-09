<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $primaryKey = 'room_id';

    protected $fillable = [
        'room_number',
        'room_type',
        'user_id',
        'option_category_id',
        'pax',
        'additional_pax_id',
        'rate_per_night',
        'processed_by',
        'checked_in',
        'checked_out',
        'status',
        'image_id',
        'description',
    ];
}
