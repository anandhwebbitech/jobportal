<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Gowtham N',
            'email' => 'gowtham@example.com',
            'phone' => '9876543210',
            'password' => Hash::make('password123'),
            'city' => 'Kattur',
            'district' => 'Tiruchirappalli',
            'experience_level' => 'experienced',
            'highest_qualification' => 'bachelor',
            'resume' => null, // path if uploaded
            'profile_photo' => null, // path if uploaded
        ]);

        // Optional: create multiple users using factory
        \App\Models\User::factory(10)->create();
    }
}