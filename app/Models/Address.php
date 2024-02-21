<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'street', 'city', 'state', 'postalCode', 'country'
    ];

    protected $guarded = [
 
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

}
