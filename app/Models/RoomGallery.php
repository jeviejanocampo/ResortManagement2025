<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomGallery extends Model
{
    use SoftDeletes;

    protected $table = 'rooms_gallery';

    protected $fillable = [
        'room_id',
        'image_name',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
}
