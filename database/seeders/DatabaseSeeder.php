<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ஏற்கனவே அட்மின் பயனர் இல்லை என்றால் புதிய அட்மினை உருவாக்கும்
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'), // பாஸ்வேர்டை பாதுகாப்பாக ஹாஷ் செய்கிறோம்
            ]
        );
    }
}