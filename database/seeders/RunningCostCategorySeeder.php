<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RunningCostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RunningCostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            RunningCostCategory::create([
                'name' => 'Bills', 
            ]);
            RunningCostCategory::create([
                'name' => 'Subscriptions', 
            ]);
            RunningCostCategory::create([
                'name' => 'Software', 
            ]);
            RunningCostCategory::create([
                'name' => 'Hardware', 
            ]);
            RunningCostCategory::create([
                'name' => 'Miscellaneous', 
            ]);
        }
    }
}
