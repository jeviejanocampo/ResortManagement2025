<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VenueGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'venue_galleries';

    protected $fillable = [
        'venue_id',
        'image_name',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'venue_id');
    }
}
