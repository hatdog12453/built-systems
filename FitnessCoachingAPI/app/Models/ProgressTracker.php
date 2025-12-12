<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressTracker extends Model
{
    protected $fillable = [
        'client_id', 'coach_id', 'weight_progress', 'body_fat_percentage', 'muscle_mass', 'record_at', 'remarks',
    ];

    protected $casts = [
        'record_at' => 'date',
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
