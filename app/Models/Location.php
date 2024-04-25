<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The Location class represents a geographic location associated with a food listing.
 * It extends the Eloquent Model class and uses the HasFactory trait.
 */
class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'searchName', 'latitude', '', 'longitude',  'food_listing_id'

    ];

    /**
     * The attributes that are guarded against mass assignment.
     *
     * @var array
     */
    protected $guarded = [
        'food_listing_id'
    ];

    /**
     * Get the food listing associated with the location.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function foodListing()
    {
        return $this->belongsTo(FoodListing::class);
    }
}
