<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VenuePricingTier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'venue_pricing_tiers';

    protected $primaryKey = 'pricing_tier_id';
    
    protected $fillable = [
        'user_id',
        'venue_id',
        'max_pax',
        'price',
        'included_overnight_pax',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'venue_id');
    }
}
