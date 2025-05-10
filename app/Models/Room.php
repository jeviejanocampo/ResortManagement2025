<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rooms';

    protected $primaryKey = 'room_id';

    protected $fillable = [
        'room_number',
        'room_type',
        'user_id',
        'option_category_id',
        'pax',
        'rate_per_night',
        'rate_per_pax',
        'checked_in',
        'checked_out',
        'status',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(OptionCategory::class, 'option_category_id', 'option_category_id');
    }

    public function roomGallery()
    {
        return $this->hasMany(RoomGallery::class, 'room_id', 'room_id');
    }
}
