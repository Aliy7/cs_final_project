<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The Profile class represents user profile information.
 * It extends the Eloquent Model class and uses the HasFactory trait.
 */
class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'bio',
        'phone_number',
        'date_of_birth',
        'image_url'
    ];

    /**
     * The attributes that are guarded against mass assignment.
     *
     * @var array
     */
    protected $guarded = [
        'user_id'
    ];

    /**
     * Get the user associated with the profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The validation rules for profile picture uploads.
     *
     * @var array
     */
    public static $rules = [
        'profile_picture' => 'nullable|image|max:2048',
    ];
}
