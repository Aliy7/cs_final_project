<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'bio',
        'phone_number',
        'bio',
        'date_of_birth',
        'image_url'
    ];

    protected $guarded = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static $rules = [
        'profile_picture' => 'nullable|image|max:2048',
    ];
}
