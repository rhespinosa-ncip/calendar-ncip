<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'admin',
            'middle_name' => 'admin',
            'last_name' => 'admin',
            'position' => 'admin',
            'email' => 'admin',
            'username' => 'admin',
            'user_type' => 'admin',
            'password' => Hash::make('password'),
        ]);
    }
}
