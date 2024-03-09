<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
    use HasFactory;

    public $fillable = ['is_read','subject', 'email_body',];
    
    protected $guarded = [
        'user_id', 'food_listing_id'
    ];
    public function foodlisting(){
        return $this->belongsTo(FoodListing::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function application(){
        return $this->belongsTo(Application::class);
    }
}
