<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'searchName','latitude', '', 'longitude',  'food_listing_id'
 
    ];

    protected $guarded = [
        'food_listing_id'
    ];

    public function foodListing(){
        return $this->belongsTo(FoodListing::class);
    }
}
