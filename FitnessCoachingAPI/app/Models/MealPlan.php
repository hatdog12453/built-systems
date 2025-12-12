<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    protected $fillable = [
        'client_id', 'coach_id', 'description', 'notes', 'calories', 'meal_type', 'protein', 'carbs', 'fats',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}
