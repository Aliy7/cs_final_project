<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The EmailNotification class represents an email notification.
 * It extends the Eloquent Model class and uses the HasFactory trait.
 */
class EmailNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['is_read', 'subject', 'email_body'];

    /**
     * The attributes that are guarded against mass assignment.
     *
     * @var array
     */
    protected $guarded = ['user_id', 'food_listing_id'];

    /**
     * Get the food listing associated with the email notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function foodlisting()
    {
        return $this->belongsTo(FoodListing::class);
    }

    /**
     * Get the user associated with the email notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the application associated with the email notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
