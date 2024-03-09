<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['family_income', 'name', 'is_student', 'status'];

    protected $guarded =['user_id', 'address_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function emailNotifications()
    {
        return $this->hasOne(EmailNotification::class); 
    }

//     public function emailNotification()
//     {
//         return $this->belongsTo(EmailNotification::class);
// }
}
