<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Coach extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'full_name', 'email', 'password', 'quotes',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function progressTrackers()
    {
        return $this->hasMany(ProgressTracker::class);
    }

    public function mealPlans()
    {
        return $this->hasMany(MealPlan::class);
    }

    public function sessionPlans()
    {
        return $this->hasMany(SessionPlan::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function messagesWithClient(Client $client)
    {
        return $this->messages()->where('client_id', $client->id)->orderBy('created_at', 'asc');
    }
}
