<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionPlan extends Model
{
    protected $fillable = [
        'client_id', 'coach_id', 'type_of_workout', 'description', 'target_muscle', 'status', 'date', 'duration',
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
