<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Main admin account - always ensure password is correct
        $admin = Admin::firstOrCreate(
            ['email' => Admin::MAIN_ADMIN_EMAIL],
            [
                'full_name' => Admin::MAIN_ADMIN_NAME,
                'password' => Hash::make(Admin::MAIN_ADMIN_PASSWORD),
            ]
        );
        
        // Always ensure password is correct (in case it was changed)
        if (!Hash::check(Admin::MAIN_ADMIN_PASSWORD, $admin->password)) {
            $admin->password = Hash::make(Admin::MAIN_ADMIN_PASSWORD);
            $admin->full_name = Admin::MAIN_ADMIN_NAME;
            $admin->save();
        }
    }
}
