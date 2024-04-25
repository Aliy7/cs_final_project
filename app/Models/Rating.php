<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The Rating class represents user ratings for food listings.
 * It extends the Eloquent Model class and uses the HasFactory trait.
 */
class Rating extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'rating'
    ];

    /**
     * The attributes that are guarded against mass assignment.
     *
     * @var array
     */
    protected $guarded = ['user_id', 'food_id'];

    /**
     * Get the user who rated the food listing.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the food listing that was rated.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function foodListing()
    {
        return $this->belongsTo(FoodListing::class);
    }
}
