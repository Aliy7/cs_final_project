<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_CANCELLED = 'cancelled';
    protected $fillable = ['reservation_date', 'status'];

    protected $guarded = ['user_id', 'food_item_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function foodListing(){
        return $this->belongsTo(FoodListing::class);
    }
}
