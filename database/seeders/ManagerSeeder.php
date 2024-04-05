<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected static ?string $password;
    public function run(): void
    {
        User::create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            
        ])->assignRole('manager');
    }
}
