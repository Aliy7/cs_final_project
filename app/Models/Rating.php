<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    public $fillable = [
        'rating'
    ];

    protected $guarded = ['user_id','food_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foodListing()
    {
        return $this->belongsTo(FoodListing::class);
    }
}
