<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'venues';

    protected $primaryKey = 'venue_id';

    protected $fillable = [
        'user_id',
        'option_category_id',
        'name',
        'check_in_time',
        'check_out_time',
        'visitor_time_limit',
        'additional_overnight_price_per_pax',
        'status',
        'description',
    ];

    public function tiers()
    {
        return $this->hasMany(VenuePricingTier::class, 'venue_id', 'venue_id');
    }

    public function category()
    {
        return $this->belongsTo(OptionCategory::class, 'option_category_id', 'option_category_id');
    }

    public function venueGallery()
    {
        return $this->hasMany(VenueGallery::class, 'venue_id', 'venue_id');
    }
}