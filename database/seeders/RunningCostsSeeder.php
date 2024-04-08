<?php

namespace Database\Seeders;

use App\Models\RunningCost;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RunningCostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RunningCost::create([
            'category_id' => 1,
            'name' => 'Electricity Bill',
            'cost' => 200.00,
            'date_incurred' => '2024-04-01',
            'repeating' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        RunningCost::create([
            'category_id' => 2,
            'name' => 'SaaS Product',
            'cost' => 30.00,
            'date_incurred' => '2024-04-01',
            'repeating' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
