<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceCategory::create([
            'name' => 'Pages', 
        ]);
        ServiceCategory::create([
            'name' => 'SEO', 
        ]);
        ServiceCategory::create([
            'name' => 'Hosting', 
        ]);
        ServiceCategory::create([
            'name' => 'Miscellaneous', 
        ]);
    }
}
