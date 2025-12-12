<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public const MAIN_ADMIN_EMAIL = 'jayraldmicarandayo@gmail.com';
    public const MAIN_ADMIN_PASSWORD = 'fitnesscoach';
    public const MAIN_ADMIN_NAME = 'Admin Jayrald';

    protected $fillable = [
        'full_name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check if this admin is the main admin account
     */
    public function isMainAdmin(): bool
    {
        return $this->email === self::MAIN_ADMIN_EMAIL;
    }

    /**
     * Get the main admin account, creating it if it doesn't exist
     * Always ensures the password is set correctly
     */
    public static function getMainAdmin()
    {
        $admin = static::firstOrCreate(
            ['email' => self::MAIN_ADMIN_EMAIL],
            [
                'full_name' => self::MAIN_ADMIN_NAME,
                'password' => bcrypt(self::MAIN_ADMIN_PASSWORD),
            ]
        );
        
        // Always ensure password is correct (in case it was changed)
        if (!Hash::check(self::MAIN_ADMIN_PASSWORD, $admin->password)) {
            $admin->password = bcrypt(self::MAIN_ADMIN_PASSWORD);
            $admin->save();
        }
        
        // Ensure full_name is correct
        if ($admin->full_name !== self::MAIN_ADMIN_NAME) {
            $admin->full_name = self::MAIN_ADMIN_NAME;
            $admin->save();
        }
        
        return $admin;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
