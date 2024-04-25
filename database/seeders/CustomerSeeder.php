<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'John',
            'last_name' => 'Walker',
            'phone_number' => '12345678912', 
            'email' => 'customer@customer.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ])->assignRole('customer');
    }
}
