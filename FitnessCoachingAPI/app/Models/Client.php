<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'coach_id', 'full_name', 'email', 'password', 'height', 'weight', 'age', 'goal', 'payment_status', 'subscription_type', 'subscription_expires_at', 'status',
    ];

    protected $casts = [
        'subscription_expires_at' => 'date',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function mealPlan()
    {
        return $this->hasOne(MealPlan::class)->latest();
    }

    public function mealPlans()
    {
        return $this->hasMany(MealPlan::class)->orderBy('created_at', 'desc');
    }

    public function sessionPlan()
    {
        return $this->hasOne(SessionPlan::class)->latest();
    }

    public function sessionPlans()
    {
        return $this->hasMany(SessionPlan::class)->orderBy('created_at', 'desc');
    }

    public function progressTracker()
    {
        return $this->hasOne(ProgressTracker::class)->latest();
    }

    public function progressTrackers()
    {
        return $this->hasMany(ProgressTracker::class)->orderBy('created_at', 'desc');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function messagesWithCoach(Coach $coach)
    {
        return $this->messages()->where('coach_id', $coach->id)->orderBy('created_at', 'asc');
    }

    /**
     * Check if subscription is expiring soon (within 7 days)
     */
    public function isSubscriptionExpiringSoon(): bool
    {
        if (!$this->subscription_expires_at) {
            return false;
        }
        
        $daysUntilExpiry = now()->diffInDays($this->subscription_expires_at, false);
        return $daysUntilExpiry >= 0 && $daysUntilExpiry <= 7;
    }

    /**
     * Check if subscription has expired
     */
    public function isSubscriptionExpired(): bool
    {
        if (!$this->subscription_expires_at) {
            return false;
        }
        
        return $this->subscription_expires_at->isPast();
    }
}
