<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'user_id' => 1,
            'contracted_hours' => 40,
            'wage_type' => 'Hourly',
            'wage_amount' => 15.50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Employee::create([
            'user_id' => 2,
            'contracted_hours' => 50,
            'wage_type' => 'Hourly',
            'wage_amount' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
