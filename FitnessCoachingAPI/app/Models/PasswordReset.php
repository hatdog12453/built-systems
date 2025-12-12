<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PasswordReset extends Model
{
    protected $table = 'verification_codes';
    
    protected $fillable = [
        'email',
        'code',
        'role',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Check if the code is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if the code is valid
     */
    public function isValid(): bool
    {
        return !$this->isExpired();
    }

    /**
     * Clean up expired codes
     */
    public static function cleanupExpired()
    {
        static::where('expires_at', '<', now())->delete();
    }
}
