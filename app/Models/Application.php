<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The Application class represents a user's application information.
 * It extends the Eloquent Model class and uses the HasFactory trait.
 */
class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['family_income', 'name', 'is_student', 'status'];

    /**
     * The attributes that are guarded against mass assignment.
     *
     * @var array
     */
    protected $guarded = ['user_id', 'address_id'];

    /**
     * Get the user associated with the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the address associated with the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    /**
     * Get the email notification associated with the application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function emailNotifications()
    {
        return $this->hasOne(EmailNotification::class);
    }
}
