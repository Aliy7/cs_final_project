<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodListing extends Model
{
    use HasFactory;

    protected $table = "food_listings";

    public $timestamps = true;

    public $primarykey = 'id';

    protected $fillable = [
        'name',
        'ingredients',
        'quantity',
        'allergen',
        'description',
        'photo_url',
        'status',
    ];
    protected $guarded = [
        'user_id',
        'category_id'
    ];
    public function location()
    {
        return $this->hasOne(Location::class, 'food_listing_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function notification(){
        return $this->hasMany(EmailNotification::class);
    }
}
